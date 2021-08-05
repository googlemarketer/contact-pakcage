<?php

namespace Googlemarketer\Contact\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Googlemarketer\Contact\Models\Admin\Service;
use Googlemarketer\Contact\Models\Admin\Subcategory;
use Googlemarketer\Contact\Models\Admin\Prioritylist;
use Googlemarketer\Contact\Traits\ImageUpload;

//use App\Http\Requests\ServiceRequest;
//use Intervention\Image\Facades\Image;

class ServiceController extends Controller
{

    use ImageUpload;
    private $lists ;
   /**
         * Check Autorization of a resource via controller method
         *
         * to check weather use is authorized to access that resource
         * @return \Illuminate\Http\Response
         */

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
            //$posts = Post::orderBy('title','desc')->take(1)->get();
            //$posts = DB::select('SELECT * FROM posts');
            //$user = Auth::user();
            // $posts = Post::orderBy('created_at','desc')->paginate(3);

            // return view('posts.index')->with('posts', $posts);
            // //return view('posts.index',compact('posts'));

            if(auth()->guard('admin')->id()==1){
            $services = Service::orderBy('subcategory_id', 'ASC')->paginate(27);
            }else {
                $services = Service::where('admin_id',auth()->guard('admin')->id())->orderBy('priority','ASC')->paginate(27);
            }

            return view('admin.service.index', compact('services','lists'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $service = new Service;
            $subcategories = SubCategory::pluck('title','id');
            $lists = $this->lists;
            return view('admin.service.create', compact('service','subcategories','lists'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store() {

            $data = $this->requestValidate();

            if(! request()->has('cover_image')){
                $data['cover_image'] = 'service\defaultservice.png' ;
            }
            $service = Service::create($data + ['slug' => strtolower(trim(preg_replace('/[\t\n\r\s]+/', '-', request()->title)))]);
            $this->storeImage($service, 'service');

            return redirect('service')->with('message', $service->title. ' service added Successfully');
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show(Service $service) {

            $lists = $this->lists;
            return view('admin.service.show',compact('service','lists'));

        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit(Service $service)
        {

         $lists = $this->lists;
         if(auth()->guard('admin')->id()==1 || auth()->guard('admin')->id() == $service->admin->id){

            $subcategories = SubCategory::pluck('title','id');
            return view('admin.service.edit', compact('subcategories','service','lists'));
        }
        else {
            return back()->with('message','Not Authorized to edit'.$service->title);
        }
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Service $service) {

        if(auth()->guard('admin')->id()==1 || auth()->guard('admin')->id() == $service->admin->id){

            if(request()->priority !== $service->priority) {
                $service->update(request(['priority']));
            }

            $service->update(['published' => request()->has('published')]);

                $data = $this->requestValidate();

                if(($service->image == 'service\defaultservice.png') && request()->has('cover_image')){
                Storage::delete('/public/'.$service->cover_image);
               }
         try {
                $service->update($data + ['slug' => strtolower(trim(preg_replace('/[\t\n\r\s]+/', '-', request()->title)))]);
                $this->updateImage($service, 'service');

            return redirect('service')->with('success', $service->title . ' updated Successfully');
        }
        catch (Exception $e) {
            return redirect("service")->with([
                'status' => 'danger',
                'message' => $e->getMessage()]);
           }
        }
        else {
            return redirect('service')->with('message', 'Not Authorized to  update'. $service->title);
            }
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Service $service)
        {
            if(auth()->guard('admin')->id()==1 || auth()->guard('admin')->id() == $service->admin->id){

            $service->delete();
            Storage::delete('public/'.$service->cover_image);

            return redirect('/service')->with('success', $service->title. ' removed Successfully');
        }
        else{
            return redirect('service')->with('message', 'Not Authorised to remove'.$service->title);
        }
        }

        private function requestValidate(){
                return request()->validate([
                    'title' => ['required','min:3','max:50'],
                    'body' => ['required','min:5','max:748'],
                    'priority' =>['sometimes'],
                    'published' =>['sometimes'],
                    'published_at' =>['sometimes'],
                    'cover_image' => 'sometimes | file|image|max:1999',
                    'subcategory_id' => 'required'
                ]);
        }

}
