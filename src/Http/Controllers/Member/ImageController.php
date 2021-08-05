<?php

namespace Googlemarketer\Contact\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Googlemarketer\Contact\Models\Member\Image;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Caster\ImgStub;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return 'reached index of imagecontroller';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request, [
                'images' => 'required',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                //'images.*' => 'mimes:doc,pdf,docx,zip'
        ]);
        $maxImages = count($request->file('images'));
        if( $maxImages > 7 ){

             return back()->with('message', 'Maxiumn 7 Images are allowed to upload, Image Uplaod failed');
        }
// dd($request);
        // $images = [];

        // if($files = $request->file('images')) {
        //     foreach($files as $file) {
        //         $name = time().'.'.$file->getClientOriginalExtension();
        //         $destinationPath = public_path('/uploads');
        //         if($file->move($destinationPath, $name)) {
        //             $images[] = $name;
        //             $saveResult = Image::create(['images' => $name]);
        //         }
        //     }

        if($request->hasfile('images'))
         {
            foreach($request->file('images') as $file)
            {
                $name = time().'.'.$file->extension();
                $destinationPath = public_path('/images/');
                if ($file->move($destinationPath , $name)) {
                    $data[] = $name;
                }
            }
         }
         $file= new Image();
         //$file->images=json_encode($data);
         $file->images = $data;
         $file->save();

        return back()->with('success', "$maxImages Images has been successfully added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //dd('reached');
        $data = Image::all();
        // dd($data[1]->images);
        return $images = response()->json(($data[1]->images));
      return view('app.images.show',compact('images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
