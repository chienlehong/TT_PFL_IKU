<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
        $this->middleware('level');
    }
    public function index()
    {
        return view('back-end.slide.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back-end.slide.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'txtLinkSlide'  => '',
            'txtImageSlide' => 'required',
            'cb_status'     => '',
]);
if ($validator->fails()) {
    return redirect()
                ->route('slide.create')
                ->withErrors($validator)
                ->withInput();
}
$request->cb_status = ($request->cb_status=='on') ? 1 : 0 ;

$slide = new Slide();

$slide->link = $request->txtLinkSlide;

$slide->slide_image = $request->txtImageSlide;

$slide->status = $request->cb_status;

$count=Slide::count();

if ($count==0)
    $slide->order =1;
else
    $slide->order=$count+1;

$slide->save();

return redirect()->route('slide.index');
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
    public function edit(Slide $id)
    {
        $slide=Slide::find($id);

        return view('back-end.slide.edit',['slide'=>$C]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slide $id)
    {
        $request->cb_status = ($request->cb_status=='on') ? 1 : 0 ;

        $validator = Validator::make($request->all(), [
            'txtImageSlide' => 'max:255|min:4',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->route('slide.edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $slide = Slide::find($id);

        $slide->link = $request->txtLinkSlide;

        $slide->status = $request->cb_status;

        $slide->slide_image = $request->txtImageSlide;

        $slide->save();
        return redirect()->route('slide.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slide $id)
    {
        if (Slide::find($id)!=null) {

            Slide::destroy($id);

            return redirect()->route('slide.index');
        }
    }
    public function getlist()
    {
        return Slide::orderBy('order')->get();
    }

    public function order(Request $request)
    {
        foreach ($request->order as $key => $value) {

            $slide = Slide::find($value);

            $slide->order = $key+1;

            $slide->save();
        }
        return redirect()->route('slide.index');
    }

    public function uploadSlideImage(Request $request){
        $file = $request->file('file');

        if(!empty($file)):

            $info=pathinfo($file->getClientOriginalName());

            $name='slide-image/'.$info['filename'].time().'.'.$info['extension'];

            Storage::put($name, file_get_contents($file));

            $url = Storage::url('app/'.$name);

        endif;
        return Response::json(array('success' => true,'file'=>$url));
    }
}
