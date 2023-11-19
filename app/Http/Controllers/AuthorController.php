<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
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
        //
        return view('back-end.author.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('back-end.author.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'txtNameAuthor' => 'required|min:1',
            'txtAuthorInfo' => '',
            'txtAuthorImage' => 'max:255',
        ]);
        if ($validator->fails()) {
            return redirect()
                        ->route('author.create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $author = new Author();

        $author->author_name = $request->txtNameAuthor;

        $author->author_info = $request->txtAuthorInfo;

        $author->author_image = $request->txtAuthorImage;
        $author->save();
        return redirect()->route('author.index');
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
    public function edit(Author $id)
    {
        //
        $books = Author::find($id)->books;
        $author=Author::find($id);
        return view('back-end.author.edit',
            [
                'author'=>$author,
                'books'=>$books
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author  $id)
    {
        $validator = Validator::make($request->all(), [
            'txtNameAuthor'     => 'required|min:1',
            'txtAuthorInfo'     => '',
            'txtAuthorImage'    => 'max:255',
        ]);
        if ($validator->fails()) {
            return redirect()
                        ->route('author.edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        $author = Author::find($id);
        $author->author_name    = $request->txtNameAuthor;
        $author->author_info    = $request->txtAuthorInfo;
        $author->author_image   = $request->txtAuthorImage;
        $author->save();
        return redirect()->route('author.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $id)
    {
        if (Author::find($id)!=null) {
            Author::destroy($id);

            return redirect()->route('author.index');
        }
    }

    public function getlist()
    {
        return Author::getTopAuthor();
    }

    public function uploadAvatarAuthor(Request $request){
        $file = $request->file('file');
        if(!empty($file)):
            $info=pathinfo($file->getClientOriginalName());
            $name='author-image/'.$info['filename'].time().'.'.$info['extension'];
            Storage::put($name, file_get_contents($file));
            $url = Storage::url('app/'.$name);
        endif;
        return Response::json(array('success' => true,'file'=>$url));
    }
}
