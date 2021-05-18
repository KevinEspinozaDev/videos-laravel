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
        return $this->hasMany('App\Models\Comment');
    }

    //relacion many to one
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
