<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request){
        $validate = $this->validate($request, [
            'body' => 'required'
        ]);

        $comment = new Comment();
        //se identifica al usuario y se lo guarda
        $user = \Auth::user();

        $comment->user_id = $user->id;
        $comment->video_id = $request->input('video_id');
        $comment->body = $request->input('body');

        $comment->save();

        return redirect()->route('detailVideo', [
            'video_id' => $comment->video_id
        ])->with('message', 'Comentario añadido correctamente!');
    }

    public function delete($comment_id){
        $user = \Auth::user();
        $comment = Comment::find($comment_id);

        if ($user && ($comment->user_id == $user->id || $comment->video->user_id == $user->id)) {
            $comment->delete();

            return redirect()->route('detailVideo', [
                'video_id' => $comment->video_id
            ])->with('message', 'Comentario eliminado correctamente!');
        }
    }
}
