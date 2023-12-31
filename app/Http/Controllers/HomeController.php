<?php

namespace App\Http\Controllers;

use App\Libs\PaginationCustom;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Company;
use App\Models\ModelClass;
use App\Models\Order;
use App\Models\Slide;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
        // $this->middleware('auth');
    }


    public function index()
    {
        $topCompany=Company::getTopCompany();

        $slides= Slide::getSlidesIndex();
        foreach (BaseClass::$categories as $value) {

            $listCate=CategoryController::getAllCategoriesId($value->id);

            $booksSuggest[$value->id]=Book::getAllBookSuggestByCategoryId($listCate);

            $booksHot[$value->id]=Book::getAllBookHotByCategoryId($listCate);

            $booksNew[$value->id]=Book::getAllBookNewByCategoryId($listCate);


        }
        return BaseClass::handlingView('front-end.home',[
            'booksSuggest'=>$booksSuggest,
            'booksHot'=>$booksHot,
            'booksNew'=>$booksNew,
            'slides'=>$slides,
            'topCompany'=>$topCompany
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

    public function viewCategory($categoryId=0)
    {
        $categorySelect= Category::find($categoryId);

        if ($categorySelect==null)
            return ;

        $booksChild=array();

        $categoriesChildSelect =Category::getCategoriesByParentID($categorySelect->id);//lấy các danh mục con của nó

        $listCate =CategoryController::getAllCategoriesId($categorySelect->id);//lấy các danh mục con và chính nó

        $booksChild=Book::getAllBookByCategoryId($listCate);//lấy toàn bộ số sách của nó và con nó

        $total=ModelClass::totalItem(array('categories'=>$listCate));//lấy tổng số result

        return BaseClass::handlingView('front-end.category',[
                            'categorySelect'        =>$categorySelect,
                            'categoriesChildSelect' =>$categoriesChildSelect,
                            'booksChild'            =>$booksChild,
                            'pagination'            =>PaginationCustom::showPagination($total)
                        ]);
    }
    public function flowOrder()
    {
        $orders =array();
        $books  =array();
        $arr  =array();

        $orders =Order::getAllOrderByUserId(Auth::id());

        foreach ($orders as  $order) {
            $books[$order->orderId]=Book::getAllBookByOrderId($order->orderId);
        }

        $total=Order::getTotalOrderByUserId(Auth::id());   //lấy tổng số đơn hàng của user

        return BaseClass::handlingView('front-end.users.flow-order',[
                                    'orders'                =>$orders,
                                    'books'                =>$books,
                                    'pagination'            =>PaginationCustom::showPagination($total)
                                ]);
    }
    public function viewHotBookWeek()
    {
        $booksHot=Book::getAllBookHotWeek();

        $total=Book::getTotalBookHotWeek();   //lấy tổng số đơn hàng của user

        return BaseClass::handlingView('front-end.hot-week',[
                                'booksHot'              =>$booksHot,
                                'pagination'            =>PaginationCustom::showPagination($total)
                            ]);
    }
    public function viewHotBookMonth()
    {
        $booksHot=Book::getAllBookHotMonth();

        $total=Book::getTotalBookHotMonth();   //lấy tổng số đơn hàng của user

        return BaseClass::handlingView('front-end.hot-month',[
                                'booksHot'              =>$booksHot,
                                'pagination'            =>PaginationCustom::showPagination($total)
                            ]);
    }
    public function viewBookNewPublish()
    {
        $bookNewPublish=Book::getAllBookNewPublish();


        return BaseClass::handlingView('front-end.new-publish',[
                                'bookNewPublish'        =>$bookNewPublish,
                                'pagination'            =>PaginationCustom::showPagination(50)
                            ]);
    }


    public function viewBook($bookId=0)
    {
        $book= Book::getBookByBookId($bookId);

        $comments= Comment::getCommentByBookId($bookId);

        $dt     = Carbon::now();
        Carbon::setLocale('vi');

        foreach ($comments as $comment)
            $comment->strTime=$dt->diffForHumans($comment->updated_at);

        if ($book==null)
            return;

        return BaseClass::handlingView('front-end.book',[
                        'book'                  =>$book,
                        'comments'              =>$comments,
                    ]);
    }


    public function viewAuthor($authorId=0)
    {
        $authorInfo= Author::find($authorId);

        if ($authorInfo!=null){
            $books= Book::getAllBookByAuthorId($authorId);

            $total=Book::getTotalBookByAuthorId($authorId);   //lấy tổng số đơn hàng của user

            return BaseClass::handlingView('front-end.author',[
                            'authorInfo'            =>$authorInfo,
                            'books'                 =>$books,
                            'pagination'            =>PaginationCustom::showPagination($total)
                        ]);
        }
        else{
            $authors= Author::getAllAuthor();

            return BaseClass::handlingView('front-end.all-author',[
                            'authors'               =>$authors,
                        ]);
        }
    }
    public function viewCompany($companyId=0)
    {
        $companyInfo= Company::find($companyId);

        if ($companyInfo!=null){
            $books= Book::getAllBookByCompanyId($companyId);

            $total=Book::getTotalBookByCompanyId($companyId);   //lấy tổng số cty

            return BaseClass::handlingView('front-end.company',[
                            'companyInfo'           =>$companyInfo,
                            'books'                 =>$books,
                            'pagination'            =>PaginationCustom::showPagination($total)
                        ]);
        }

        else{
            $companies= Company::getAllCompany();

            return BaseClass::handlingView('front-end.all-company',[
                            'companies'             =>$companies,
                        ]);
        }
    }
    public function search(Request $request)
    {
        $txtSearch= $request->input('txtSearch');

        $total=Book::getTotalBookByKeySearch($txtSearch);   //lấy tổng số search

        $books= Book::getAllBookByKeySearch($request->txtSearch);

            return BaseClass::handlingView('front-end.search',[
                            'books'                 =>$books,
                            'txtSearch'             =>$txtSearch,
                            'pagination'            =>PaginationCustom::showPagination($total)
                        ]);
    }
}
