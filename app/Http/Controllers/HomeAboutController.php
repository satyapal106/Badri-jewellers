<?php

namespace App\Http\Controllers;

use App\Models\HomeAbout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Facades\File;

class HomeAboutController extends Controller
{
   
    public function AboutIndex(Request $request, $id=null)
    {
        if($id==""){
            $title= 'Add Home About';
            $homeAbout = new HomeAbout();
            $message = 'Add Home About successfully';
        }else{
            $title = 'Edit Home About';
        }
       if($request->isMethod('post')){
          $data = $request->all();
          $rules = [
            'heading' => 'required|max:255',
            'sub_heading' => 'required|max:255',
            'description' => 'required',
            'video' => 'nullable|mimes:mp4,avi,wmv,mov|max:10240',
        ];
          $customMessage = [
          'heading.required' => 'Heading field is required',
          'heading.max' => 'Heading should not exceed 255 characters',
          'sub_heading.required' => 'Sub Heading field is required',
          'sub_heading.max' => 'Sub Heading should not exceed 255 characters',
          'description.required' => 'Description field is required',
          'video.mimes' => 'The video must be a file of type: mp4, avi, wmv, mov',
          'video.max' => 'The video size should not exceed 10MB',
          ];

        $validator = Validator::make($data, $rules, $customMessage);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $homeAbout->heading = $data['heading'];
        $homeAbout->sub_heading = $data['sub_heading'];
        $homeAbout->description = $data['description'];

        // Handle the video upload
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $videoDirectory = public_path('assets/images/video'); 
           
            // Ensure the directory exists
            if (!file_exists($videoDirectory)) {
                mkdir($videoDirectory, 0755, true); 
            }
            // Move the uploaded video to the directory
            $video->move($videoDirectory, $videoName);

            $homeAbout->video = 'assets/images/video/' . $videoName; 
        }
        $homeAbout->save();
        return redirect('admin/home-about')->with('success_msg', $message);
       }
       return view('admin.Homepage.about')->with(compact('title'));
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
    public function show(HomeAbout $homeAbout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeAbout $homeAbout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeAbout $homeAbout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeAbout $homeAbout)
    {
        //
    }
}
