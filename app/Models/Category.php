<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
        'parent_id',
        'order'
    ];
    protected $table ='categories';
    protected $guarded =[];

    public function books(){
        return $this->hasMany(Book::class);
    }
    public static function getCategoriesByParentID($parentID=0)
    {
        return Category::select('id','category_name')
                        ->orderBy('order')
                        ->where('parent_id', $parentID)
                        ->get();
    }
    public static function getAll()
    {
        return Category::get();
    }
}
