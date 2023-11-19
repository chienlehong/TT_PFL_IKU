<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;
    protected $fillable = [
        'slide_image',
        'link',
        'order',
        'status'
    ];
    protected $table ='slides';

    public static function getSlidesIndex()
    {
    	return Slide::where('status','=',1)->orderBy('order')->get();
    }
}
