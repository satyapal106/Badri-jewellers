<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Testimonial(Request $request, $id = null)
    {
         if($id == ""){
            $title = 'Add Testimonial';
            $testimonial = new Testimonial;
            $message = 'Add Testimonial Successful';
         }else{
            $title = 'Edit Testimonial';
            $testimonial = Testimonial::find($id);
            $message = 'Update Testimonial Successful';
         }

         if($request->isMethod('POST')){
            $data = $request->all();
            $rules = [
                'name' =>'required|max:255',
                'description' =>'required',
            ];

            $customMessage = [
                'name.required' => 'Name is required',
                'name.max' => 'Name should not exceed 255 characters',
                'description.required' => 'description is required',
            ];

            $validator = Validator::make($data, $rules, $customMessage);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $testimonial->name = $data['name'];
            $testimonial->description = $data['description'];

            if($request->hasfile('image')){
                $manager = new ImageManager(new Driver());
                $path = 'assets/images/testimonial/';
                if(!is_dir($path)){
                 mkdir($path, 0777, true);
                }
                $image_file = $request->file('image');
                $image = $manager->read($image_file);
                $image->resize(100, 100);
                $image->encode(new  WebpEncoder(quality:65));
                $filename = uniqid() . '.' . 'webp';
                $image->save($path.$filename);
                $data['image'] = $path.$filename;
            }
            $testimonial->save();
            return redirect('admin/testimonial')->with('success_msg', $message);
         }
        return view('admin.Homepage.testimonial')->with(compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        //
    }
}
