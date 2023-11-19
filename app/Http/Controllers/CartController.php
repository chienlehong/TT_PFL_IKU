<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booksInCart=array();

        foreach (Cart::content() as $key => $value) {
            $booksInCart[$value->id]=Book::getBookInCart($value->id);
        }

        return BaseClass::handlingView('front-end.cart',[
                            'booksInCart'       =>$booksInCart,
                        ]);
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
        //
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

    public function addCart(Request $request)
    {
        $book=Book::select('id','book_name','price','quality','book_image')->find($request->txtBookId);
        // dd($book);
        if (!isset($book)) {
            return 'Có lỗi xảy ra';
        }
        if ($book->quality<$request->qty) {
            return 'Không đủ hàng để cung cấp';
        }
        Cart::add([
                'id'        => $book->id,
                'name'      => $book->book_name,
                'qty'       => (int)$request->qty,
                'price'     => $book->price,
                // 'options'   =>['book_image' => $book->book_image]
            ]);
        // dd(Cart::content());
        return redirect()->route('cart.index');
        //
    }
}
