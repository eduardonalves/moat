<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name'
    ];

    public function albums(){
        return $this->hasMany('App\Models\Album');
    }

    public static function getValidationRules($id=null):array {
        return [
            'name' => ['required','string', 'max:255','unique:artists'. ($id ? ",id,$id" : '')],
        ];
    }
}
