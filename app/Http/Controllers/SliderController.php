<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Slider;

class SliderController extends Controller
{
     public function UploadSliderImage(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'slider_image' => 'required|image|mimes:webp,jpeg,jpg,png:max:2048',
                'alt_text' => 'nullable|max:255',
            ];

            $customMessage = [
                'slider_image.required' => 'Slider image required',
                'slider_image.image' => 'The file must be an image',
                'slider_image.mimes' => 'The file must be a jpeg, jpg, png, webp format',
                'slider_image.max' => 'The file size must not exceed 1MB',
            ];

            $validator = Validator::make($data, $rules, $customMessage);
            
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if($request->hasFile('slider_image')) {
                $manager = new ImageManager(new Driver());
                $path = 'assets/images/carousel/';
                if (!is_dir($path)) {
                    mkdir($path, 0755, true);
                }
                $uploadedImage = $request->file('slider_image');
                $image = $manager->read($uploadedImage);
                $image->resize(1920, 950);
                $image->encode(new WebpEncoder(quality: 65));
                $filename = uniqid() . '.' .'webp';
                $image->save($path.$filename);
                $data['slider_image'] = $path.$filename;
            }
            Slider::create($data);
            return redirect()->back()->with('success_msg', 'Slider image saved successfully');
        }
        $slider = Slider::where('status', '1')->get();
        return view('admin.Homepage.slider', compact('slider'));
    }

    public function DeleteSliderImage($id){
        $sliderData = Slider::find($id);
        if($sliderData){
            File::delete($sliderData['slider_image']);
            $sliderData->delete();
            return redirect()->back()->with('success_msg', 'Slider image deleted successfully');
        }else{
            return redirect()->back()->with('error_msg', 'Slider image not found');
        } 
    }
}
