<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = "comments";

    //relacion many to one
    // Todos los comentarios asociados a un usuario
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    //relacion many to one
    //Todos los comentarios asociados a un video
    public function video(){
        return $this->belongsTo('App\Models\Video', 'video_id');
    }
}
