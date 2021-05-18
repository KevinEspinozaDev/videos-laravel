<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Filesystem\Filesystem;

use App\Models\Video;
use App\Models\Comment;
use App\Models\User;

class VideoController extends Controller
{
    public function createVideo(){
        return view('video/createVideo');
    }

    public function saveVideo(Request $request){
        //Validar formulario
        $validatedData = $this->validate($request, [
            'title' => 'required',
            'title' => 'min:5',
            'description' => 'required',
            'video' => 'mimes:mp4'
        ]);

        $video = new Video();
        $user = \Auth::user();
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        //Subida de miniatura
        $image = $request->file('image');
        if ($image) {
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fecha = date('Y-m-d-H-i');
            $image_path = $fecha."-".$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
            $video->image = $image_path;
        }

        //Subida del video
        $video_file = $request->file('video');
        if ($video_file) {
            $video_path = $fecha."-".$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path;
        }

        $video->save();

        return redirect()->route('home')->with(array(
            'message' => 'El video se ha subido correctamente!'
        ));
    }

    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }
}
