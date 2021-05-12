<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = "videos";

    //relacion one to many
    public function comments(){
        return $this->hasMany('App\Comment');
    }

    //relacion many to one
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
