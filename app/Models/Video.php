<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = "videos";

    //relacion one to many
    //Todos los comments asociados a un video
    public function comments(){
        return $this->hasMany('App\Models\Comment')->orderBy('id', 'desc');
    }

    //relacion many to one
    //Todos los videos asociados a un usuario
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
