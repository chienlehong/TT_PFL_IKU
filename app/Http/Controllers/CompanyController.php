<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
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
        return view('back-end.company.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back-end.company.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'txtNameCompany' => 'required|min:1',
            'txtCompanyInfo' => '',
            'txtCompanyLogo' => 'max:255',
]);
if ($validator->fails()) {
return redirect()
            ->route('company.create')
            ->withErrors($validator)
            ->withInput();
}
$company = new Company();

$company->company_name = $request->txtNameCompany;

$company->company_info = $request->txtcompanyInfo;

$company->company_image = $request->txtCompanyLogo;

$company->save();
return redirect()->route('company.index');
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
    public function edit(Company $id)
    {
        $books = Company::find($id)->books;

        $company=Company::find($id);

        return view('back-end.company.edit',
            [
                'company'   =>$company,
                'books'     =>$books
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $id)
    {
        $validator = Validator::make($request->all(), [
            'txtNameCompany' => 'required|min:1',
            'txtCompanyInfo' => '',
            'txtCompanyLogo' => 'max:255',
        ]);
        if ($validator->fails()) {
            return redirect()
                        ->route('company.edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        $company = Company::find($id);

        $company->company_name = $request->txtNameCompany;

        $company->company_info = $request->txtCompanyInfo;

        $company->company_image = $request->txtCompanyLogo;

        $company->save();
        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $id)
    {
        if (Company::find($id)!=null) {

            Company::destroy($id);

            return redirect()->route('company.index');
        }
    }

    public function getlist()
    {
        return Company::getAllCompany();
    }

    public static function getlistCompany()
    {
        return Company::select('id','company_name','company_image')
                        ->distinct()
                        ->orderBy('company_name')
                        ->get();
    }

    public function uploadCompanyLogo(Request $request){
        $file = $request->file('file');

        if(!empty($file)):

            $info=pathinfo($file->getClientOriginalName());

            $name='company-image/'.$info['filename'].time().'.'.$info['extension'];

            Storage::put($name, file_get_contents($file));

            $url = Storage::url('app/'.$name);
        endif;

        return Response::json(array('success' => true,'file'=>$url));
    }
}

