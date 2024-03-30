<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class SupportController extends Controller
{
    public function upload(Request $request){

        $image = $request->file('file');
        $filename = time() . '.' . $image->getClientOriginalExtension();

        $image=Image::make($image)->resize(null, 200, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->stream();
        $a=Storage::disk('local')->put('public/images/summernote-image/' . $filename, $image, 'public');
        return 'images/summernote-image/' . $filename;
    }
}
