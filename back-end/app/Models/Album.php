<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    //use HasFactory;
    protected $fillable = [
        'album_name', 'year','artist_id'
    ];
    public function artist(){
        return $this->belongsTo('App\Models\Artist');
    }
}
