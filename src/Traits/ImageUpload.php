<?php

namespace Googlemarketer\Contact\Traits;

//use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

trait ImageUpload {

  public function storeImage($data, $folder) {

    if (request()->has('cover_image')) {
  // dd(storage_path('app\public/'));
      $data->update(['cover_image' => request()->cover_image->storeAs($folder, $data->slug.'.png','public')]);
      $cover_image = Image::make(storage_path('app\public/'.$data->cover_image))->fit(300,400);
      $cover_image->save();

    }
  }

  public function updateImage($data, $folder) {

    if (request()->has('cover_image')) {

      // $data->update(['cover_image' => request()->cover_image->store($folder,'public')]);
      // $cover_image = Image::make(storage_path('app\public/'.$data->cover_image))->fit(300,300);
      // $cover_image->save();
      $data->update(['cover_image' => request()->cover_image->storeAs($folder, $data->slug.'.png','public')]);
      $cover_image = Image::make(storage_path('app\public/'.$data->cover_image))->resize(300,200);
      $cover_image->save();

    }
  }

}
