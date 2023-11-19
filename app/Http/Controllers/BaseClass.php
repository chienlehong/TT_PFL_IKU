<?php

namespace App\Http\Controllers;

use App\Category as AppCategory;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseClass extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        static public $categories      =array();
        static public $categoriesChild =array();
        static public $authorsChild    =array();
        static public $companyChild    =array();
        static public $categoryAll     =array();

        public function __construct()
        {
            BaseClass::$categories=Category::getCategoriesByParentID(0);//lấy danh mục theo parent id truyền vào

            BaseClass::$categoryAll=Category::getAll();//lấy toàn bộ danh mục

            foreach (BaseClass::$categories as $value) {

                BaseClass::$categoriesChild[$value->id]=Category::getCategoriesByParentID($value->id);

                $listCate=CategoryController::getAllIdCategories(BaseClass::$categoryAll,$value->id);

                BaseClass::$authorsChild[$value->id]=Auth::getTopAuthorInCategories($listCate);

                BaseClass::$companyChild[$value->id]=Company::getTopCompanyInCategories($listCate);
            }
        }

        public static function handlingView($viewLayout='front-end.home',$arrayValue=array())
        {
            $arrayDefault=[
                            'categories'        =>BaseClass::$categories,
                            'categoriesChild'   =>BaseClass::$categoriesChild,
                            'companyChild'      =>BaseClass::$companyChild,
                            'authorsChild'      =>BaseClass::$authorsChild
                        ];
            return view($viewLayout,array_merge($arrayDefault,$arrayValue));
        }
}
new BaseClass();
