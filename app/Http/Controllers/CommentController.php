<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('level');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('back-end.comment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'txtRate'       => 'required|min:1|max:5|numeric',
            'txtBookId'     => 'required|min:1|numeric',
            'txtTitle'      => 'required|min:3',
            'txtContent'    => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
        }
        $comment = new Comment();

        $comment->book_id   = $request->txtBookId;
        $comment->title     = $request->txtTitle;
        $comment->user_id   = Auth::id();
        $comment->content   = $request->txtContent;
        $comment->rate      = $request->txtRate;

        $comment->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getlist()
    {
        return DB::select("
                            SELECT c.id,c.book_id,b.book_name,c.title,c.rate,c.content,u.name,c.updated_at
                            FROM comments as c
                            LEFT OUTER JOIN books  as b
                            ON c.book_id = b.id
                            LEFT OUTER JOIN users  as u
                            ON c.user_id = u.id
                            ORDER BY updated_at DESC
                        ");
    }
}
