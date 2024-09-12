<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    
    public function Login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required:max:30',
            ];

            $customMessage = [
                'email.required' => 'Email is required',
                'email.email' => 'Valid Email is required',
                'password.required' => 'password is required'
            ];

            $validate = Validator::make($data, $rules, $customMessage);
            
            if($validate->fails()){
                return redirect()->back()->with($validate)->withInput();
            }
            if(Auth::guard('admin')->attempt(['email'=> $data['email'], 'password' => $data['password']])){

                if(isset($data['remember'])&&!empty($data['remember'])){
                    setcookie("email", $data['email'], time()+3600);
                    setcookie("password", $data['password'], time() + 3600);
                }else{
                    setcookie("email", "");
                    setcookie("password", "");
                }
                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with('error_msg', 'Invalid Email or password');
            }
        }
        return view('admin.login');
    }

    public function dashboard(){
        return view('admin.dashboard');
    }

    public function Logout(){
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
