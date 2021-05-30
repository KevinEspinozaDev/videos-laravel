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

class UserController extends Controller
{
    public function channel($user_id){
        $user = User::find($user_id);
        $session_user = \Auth::user();

        if (!is_object($user)) {
            return redirect()->route('home');
        }
        
        $videos = Video::where('user_id', $user_id)->paginate(5);

        return view('user/channel', [
            'user' => $user,
            'videos' => $videos
        ]);
        
        
    }
}
