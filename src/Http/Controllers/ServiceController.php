<?php

namespace Googlemarketer\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Googlemarketer\Contact\Models\Tag;
use Googlemarketer\Contact\Models\Location;
use Googlemarketer\Contact\Models\Admin\Service;
use Googlemarketer\Contact\Models\Admin\Category;
use Googlemarketer\Contact\Models\Member\Property;
use Googlemarketer\Contact\Models\Admin\Subservice;
use Googlemarketer\Contact\Models\Admin\Subcategory;

class ServiceController extends Controller
{

    public function category(){
         $categories = Category::where('published',true)->orderBy('priority','asc')->get();
        $locs = Location::pluck('area','id');
        $tags = Tag::all()->whereBetween('id',[1,2,3,4])->pluck('property','id');
        $property = new Property;
        return view('app.services.categories', compact('categories', 'locs','tags','property'));
     }

    public function subcategory(Category $category, SubCategory $subcategory){
        if( $category !== null ){
          $subcategories = Subcategory::where('category_id', $category->id)->orderBy('title','ASC')->get();
      } else {
          $subcategories = Subcategory::orderBy('title','ASC')->get();
      }
           //$services = Service::all();
           //dd($category->slug);
           //foreach($subcategories as $subcategory) {
           //dd($subcategory->slug);

           //}
           //die();

           $locs = Location::pluck('area','id');
           $tags = Tag::all()->whereBetween('id',[1,2,3,4])->pluck('property','id');

          return view('app.services.subcategories', compact('category','subcategories','locs','tags'));

      }


      public function services(Category $category, SubCategory $subcategory){

        if( $subcategory !== null) {
            $services = Service::where('subcategory_id', $subcategory->id )->orderBy('title','desc')->get();
        } else {
            $services = Service::all();
        }
       // dd($subcategory->slug);
        switch($subcategory->slug) {

            case 'buy-property':
                $properties = Property::where('service','sell')->orderBy('priority','asc')->paginate(4);
                return view('app.properties.index',compact('properties'));
            break;
            case 'sell-property':
                $properties = Property::where('service','buy')->orderBy('priority','asc')->paginate(4);
                return view('app.properties.index',compact('properties'));
            break;
            case 'leaseout-rent-tolet':
                $properties = Property::where('service','leaseout')->orderBy('priority','asc')->paginate(4);
                return view('app.properties.index',compact('properties'));
            break;
            case 'leasein-rent-tolet':
                $properties = Property::where('service','leasein')->orderBy('priority','asc')->paginate(4);
                return view('app.properties.index',compact('properties'));
            break;
            case 'paying-guest':
                $properties = Property::where('service','pg')->orderBy('priority','asc')->paginate(4);
                return view('app.properties.index',compact('properties'));
            break;

            default:
                return view('app.services.services', compact('category','subcategory','services'));
            break;

        }
        // if ( $subcategory->slug = "buy_property"){
        //     $properties = Property::orderBy('priority','asc')->paginate(4);
        //     return view('member.property.index',compact('properties'));
        // } else {
        //     return view('pages.service', compact('category','subcategory','services'));
        // }


      }

       public function subservices(Category $category, SubCategory $subcategory, Service $service){
        if( $service !== null) {
            $subservices = Subservice::where('service_id', $service->id )->orderBy('title','desc')->get();
        } else {
            $subservices = Service::all();
        }

        return view('app.services.subservices', compact('service','subservices'));
      }

}
