<?php

namespace Googlemarketer\Contact\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Googlemarketer\Contact\Models\Admin\Category;
use Googlemarketer\Contact\Models\Admin\Prioritylist;
use App\Traits\ImageUpload;

class CategoryController extends Controller
{
    use ImageUpload;
    private $lists;

    public function __construct(){
        $this->middleware('auth.admin', ['except' => ['index','show']]);
        $this->lists =  Prioritylist::pluck('priority','id')->filter()->all();;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $lists = $this->lists;
        if(auth()->guard('admin')->id()==1){
            $categories = Category::orderBy('priority','ASC')->paginate(18);
        }else {
            $categories = Category::where('admin_id',auth()->guard('admin')->id())->orderBy('priority','ASC')->paginate(18);
        }
        return view('admin.category.index', compact('categories','lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $category = new Category;
        $lists = $this->lists;
        return view('admin.category.create', compact('category','lists'));
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = $this->requestValidate();

        if(! request()->has('cover_image')){
            $data['cover_image'] = 'category\defaultcategory.png' ;
        }

        try {

            $category = Category::create($data + [ 'slug' => strtolower(trim(preg_replace('/[\t\n\r\s]+/', '-', request()->title))), 'admin_id' => auth()->guard('admin')->id() ]);
            $this->storeImage( $category,'category');

            return redirect('category')->with('message', $category->title.'category added Successfully' );
        }
        catch (Exception $e){

            return redirect("category")->with([
                'status' => 'danger',
                'message' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category) {

        $lists = $this->lists;
        return view('admin.category.show', compact('category','lists'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category) {
        $lists = $this->lists;
        if(auth()->guard('admin')->id() == 1 || auth()->guard('admin')->id() == $category->admin->id ){
            return view('admin.category.edit', compact('category', 'lists'));
        }
        else {
            return back()->with('message','Not Authorized to edit'.$category->title);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category) {

        if(auth()->guard('admin')->id() == 1 || auth()->guard('admin')->id() == $category->admin->id){

            if(request()->priority !== $category->priority) {
                $category->update(request(['priority']));
            }

            $category->update(['published' => request()->has('published')]);

            $data = $this->requestValidate();

            if(($category->image == 'category\defaultcategory.png') && request()->has('cover_image')){
                Storage::delete('/public/'.$category->cover_image);
               }

               try {
                $category->update($data + ['slug' => strtolower(trim(preg_replace('/[\t\n\r\s]+/', '-', request()->title)))]);
                $this->updateImage($category, 'category');
                return redirect('category')->with('message', $category->title. ' updated Succssfully');
               }
               catch (Exception $e){
                return redirect("category")->with([
                    'status' => 'danger',
                    'message' => $e->getMessage()]);
               }

            }
            else {
                return redirect('category')->with('message', 'Not Authorized to  update'. $category->title);
                }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)  {

        if(auth()->guard('admin')->id()==1 || auth()->guard('admin')->id() == $category->admin->id){
            $category->delete();
            Storage::delete('/public/'.$category->cover_image);
            return redirect('category')->with('message', $category->title. ' removed Succssfully');
        }
        else{
            return redirect('category')->with('message', 'Not Authorised to remove'.$category->title);
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
                'body' => ['required','min:10','max:255'],
                'priority' =>['sometimes'],
                'published' =>['sometimes'],
                'published_at' =>['sometimes'],
                'cover_image' => 'sometimes | file | image| max:1999',
            ]);
        }
    }

    public function search(){
        dd('search category');
    }

}
