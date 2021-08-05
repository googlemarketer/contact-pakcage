<?php

namespace Googlemarketer\Contact\Http\Controllers\Admin;

use Exception;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Googlemarketer\Contact\Models\Admin\Category;
use Googlemarketer\Contact\Models\Admin\Subcategory;
use Googlemarketer\Contact\Models\Admin\Prioritylist;
use Illuminate\Support\Facades\Storage;

class SubcategoryController extends Controller
{
    use ImageUpload;
    private $lists ;

    public function __construct(){
        $this->middleware('auth.admin', ['except' => ['index','show']]);
        $this->lists =  Prioritylist::pluck('priority','id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = $this->lists;
        if(auth()->guard('admin')->id()==1){
            $subcategories = Subcategory::orderBy('priority','ASC')->paginate(27);
        }else {
            $subcategories = Subcategory::where('admin_id',auth()->guard('admin')->id())->orderBy('priority','ASC')->paginate(27);
        }
        return view('admin.subcategory.index', compact('subcategories','lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subcategory = new Subcategory;
        $categories = Category::pluck('title','id');
        $lists = $this->lists;
        return view('admin.subcategory.create', compact('subcategory','categories','lists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  request()
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

           $data = $this->requestValidate();

           if(! request()->has('cover_image')){
            $data['cover_image'] = 'subcategory\defaultsubcategory.png' ;
           }
           $subcategory = Subcategory::create($data + [ 'slug' => strtolower(trim(preg_replace('/[\t\n\r\s]+/', '-', request()->title))), 'admin_id' => auth()->guard('admin')->id() ]);
            $this->storeImage($subcategory, 'subcategory');

            return redirect('subcategory')->with('message', $subcategory->ttile .' subcategory added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory) {

        $lists = $this->lists;
        return view('admin.subcategory.show', compact('subcategory','lists'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $subcategory)
    {
        $lists = $this->lists;
        if(auth()->guard('admin')->id()==1 || auth()->guard('admin')->id() == $subcategory->admin->id){
            $categories = Category::pluck('title','id');
         return view('admin.subcategory.edit', compact('categories', 'subcategory','lists'));
        }
        else {
            return back()->with('message','Not Authorized to edit'.$subcategory->title);
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  request()
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Subcategory $subcategory)
    {

        if(auth()->guard('admin')->id()==1 || auth()->guard('admin')->id() == $subcategory->admin->id){

            if(request()->priority !== $subcategory->priority) {
                $subcategory->update(request(['priority']));
            }

            $subcategory->update(['published' => request()->has('published')]);


                $data = $this->requestValidate();

                 if(($subcategory->image == 'subcategory\defaultsubcategory.png') && request()->has('cover_image')){
                Storage::delete('/public/'.$subcategory->cover_image);
               }
         try {
            $subcategory->update($data + [strtolower(trim(preg_replace('/[\t\n\r\s]+/', '-', request()->title)))]);
            $this->updateImage($subcategory, 'subcategory');

            return redirect('subcategory')->with('messsage', $subcategory->title. ' subcategory udpated Successfully');
        }
        catch (Exception $e) {
            return redirect("subcategory")->with([
                'status' => 'danger',
                'message' => $e->getMessage()]);
           }
        }
        else {
            return redirect('subcategory')->with('message', 'Not Authorized to  update'. $subcategory->title);
            }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        if(auth()->guard('admin')->id()==1 || auth()->guard('admin')->id() == $subcategory->admin->id){

            $subcategory->delete();
            Storage::delete('/public/'.$subcategory->cover_image);
            return redirect('subcategory')->with('message', $subcategory->title . ' subcategory removed Successfully');
        }
        else{
            return redirect('subcategory')->with('message', 'Not Authorised to remove'.$subcategory->title);
        }
    }

     /**
     * Validatating the form data.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */

    private function requestValidate(){
        {
            return request()->validate([
                'title' => ['required','min:3','max:50'],
                'body' => ['required','min:5','max:255'],
                'priority' =>['sometimes'],
                'published' =>['sometimes'],
                'published_at' =>['sometimes'],
                'cover_image' => 'sometimes | file | image| max:1999',
                'category_id' => 'required'

            ]);
        }
    }

}
