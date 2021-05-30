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

        if ($video->save()) {
            $message = "El video se ha subido correctamente!";
            $result = 1;
        }else{
            $message = "El video no se ha podido subir...";
            $result = 0;
        }
        

        return redirect()->route('home')->with([
            'message' => $message,
            'result' => $result
        ]);
    }

    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    /* Busca un video para reproducirlo en una vista */
    public function getVideoDetail($video_id){
        $video = Video::find($video_id);
        return view('video/detail', array(
            'video' => $video
        ));
    }

    public function getVideo($filename){
        $file = Storage::disk('videos')->get($filename);
        return new Response($file, 200);
    }

    public function delete($video_id){
        $user = \Auth::user();
        $video = Video::find($video_id);

        // Busca todos los comments que tengan $video_id
        $comments = Comment::where('video_id', $video_id)->get();

        if ($user && $video->user_id == $user->id) {
            //Delete comments
            if ($comments && count($comments) >= 1) {

                foreach ($comments as $comment) {
                    $comment->delete();
                }

            }
            

            //Delete files stored
            Storage::disk('images')->delete($video->image);
            Storage::disk('videos')->delete($video->video_path);

            //Delete register
            $video->delete();

            $message = ['message' => 'Video eliminado correctamente.', 'result' => 1];

            
        }else{
            $message = ['message' => 'No se pudo eliminar el video.', 'result' => 0];
        }

        return redirect()->route('home')->with($message);
    }

    public function edit($id){
        // Busca pero devuelve mensaje de error si no encuentra
        $user = \Auth::user();

        $video = Video::findOrFail($id);

        if ($user && $video->user_id == $user->id) {
            return view('video/edit', ['video' => $video]);
        }else{
            return redirect('home');
        }
    }

    public function update($video_id, Request $request){
        $validate = $this->validate($request, [
            'title' => 'required',
            'title' => 'min:5',
            'description' => 'required',
            'video' => 'mimes:mp4'
        ]);

        $video = Video::findOrFail($video_id);
        $user = \Auth::user();

        // Se eliminan los archivos anteriores
        if ($user && $video->user_id == $user->id) {

            

            /* Se inicia la actualizacion */
            $video->user_id = $user->id;
            $video->title = $request->input('title');
            $video->description = $request->input('description');

            //Subida de miniatura
            $image = $request->file('image');
            if ($image) {
                //Borra el archivo anterior de la carpeta del servidor
                Storage::disk('images')->delete($video->image);
                
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $fecha = date('Y-m-d-H-i');
                $image_path = $fecha."-".$image->getClientOriginalName();
                \Storage::disk('images')->put($image_path, \File::get($image));
                $video->image = $image_path;
            }

            //Subida del video
            $video_file = $request->file('video');
            if ($video_file) {
                //Borra el archivo anterior de la carpeta del servidor
                Storage::disk('videos')->delete($video->video_path);

                $video_path = $fecha."-".$video_file->getClientOriginalName();
                \Storage::disk('videos')->put($video_path, \File::get($video_file));
                $video->video_path = $video_path;
            }

            $message = ['message' => 'Video editado correctamente.', 'result' => 1];

        }else{
            $message = ['message' => 'No se pudo editar el video.', 'result' => 0];
        }

        /* ACTUALIZACION DEL VIDEO */
        $video->update();

        return redirect()->route('home')->with($message);
    }

    public function search($search = null, $filter = null){

        if (is_null($search)) {
            $search = \Request::get('search');

            if (is_null($search)) {
                return redirect()->route('home');
            }

            return redirect()->route('videoSearch', [
                'search' => $search
            ]);
        }

        if (is_null($filter) && \Request::get('filter') && !is_null($search)) {
            $filter = \Request::get('filter');

            return redirect()->route('videoSearch', [
                'search' => $search,
                'filter' => $filter
            ]);
        }

        $column = 'id';
        $order = 'desc';

        if (!is_null($filter)) {
            if ($filter == 'new') {
                $column = 'id';
                $order = 'desc';
            }elseif ($filter == 'old') {
                $column = 'id';
                $order = 'asc';
            }elseif ($filter == 'alfa') {
                $column = 'title';
                $order = 'asc';
            }
        }

        // se busca coincidencia, no un titulo exactamente igual a $search
        $videos = Video::where('title', 'LIKE', '%'.$search.'%')->orderBy($column, $order)->paginate(5);

        return view('video/search', [
            'videos' => $videos,
            'search' => $search
        ]);
    }
}
