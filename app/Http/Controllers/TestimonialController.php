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
    

    public function AllTestimonial()
    {
        $testimonials = Testimonial::get();
        return view('admin.Homepage.all-testimonial', compact('testimonials'));
    }

    public function Testimonial(Request $request, $id = null)
    {
         if($id == ""){
            $title = 'Add Testimonial';
            $testimonial = new Testimonial();
            $message = 'Add Testimonial Successful';
         }else{
            $title = 'Edit Testimonial';
            $testimonial = Testimonial::find($id);
            $message = 'Testimonial Updated Successfully';
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

            if($id==""){
                return redirect()->back()->with('success_msg', $message);
            }else{
                return redirect('admin/all-testimonial')->with('success_msg', $message);
            }
           
         }
         return view('admin.Homepage.testimonial')->with(compact('title', 'testimonial'));
    }


    public function DeleteTestimonial($id)
    {
       Testimonial::where('id', $id)->delete();
       return redirect()->back()->with('success_msg', 'Testimonial deleted successfully');
    }

    public function UpdateTestimonialStatus(Request $request){

        if($request->ajax()){
            $data = $request->all();
           //echo '<pre></pre>'; print_r($data);exit();
            if($data['status'] == 'active'){
                $status = 0;
            }else{
                $status = 1;
            }
            Testimonial::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id'], 'msg' => 'Status updated successfully']);
            //echo '<pre></pre>'; print_r($data);exit();
        }
    }
}
