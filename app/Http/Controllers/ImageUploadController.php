<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
 * The following code is inspired of the source:
 * Source: https://www.itsolutionstuff.com/post/laravel-8-image-upload-tutorial-exampleexample.html
 * Author: Hardik Savani
 */

/**
 * Controller for the image uploading.
 */
class ImageUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageUpload()
    {
        return view('imageUpload');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function imageUploadPost(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();

        $request->image->move(public_path('images'), $imageName);

        return $imageName;
    }
}
