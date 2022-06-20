<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    
    use HasFactory;
    
    protected $fillable = [
        'album_name', 'year','artist_id'
    ];
    public function artist(){
        return $this->belongsTo('App\Models\Artist');
    }

    public static function getValidationRules($id=null): array
    {
        return [
            'album_name' => ['required','string','max:255','unique:albums'. ($id ? ",id,$id" : '')],
            'year' => ['required', 'string','max:4'],
            'artist_id' => 'required|integer',
        ];
    }
}
