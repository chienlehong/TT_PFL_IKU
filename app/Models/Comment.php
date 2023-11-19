<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table ='comments';
    protected $fillable = [
        'book_id',
        'user_id',
        'title',
        'content',
        'rate'
    ];

    public function book(){
        return $this->belongsTo(Book::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public static function getCommentByBookId($bookId=null)
    {
        return Comment::select('comments.id','rate','name','title','content','comments.updated_at')
        				->where('book_id',$bookId)
        				->leftJoin('users as u','u.id','=','comments.user_id')
        				->leftJoin('books as b','b.id','=','comments.book_id')
        				->orderBy('updated_at','desc')
        				->get();
    }
}
