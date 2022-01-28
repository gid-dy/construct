<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\Admin;
use Illuminate\Support\Facades\Hash;
use Validator;


class AdminLoginController extends Controller
{

    public function ShowLoginForm(){
        // $user = Auth::user();
        // if($user && $user->UserRole_id == 1)
        //     return redirect('admin/dashboard');

        return view('admin.admin_login');
    }

    public function login(Request $request)
    {

        $data = $request->input();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //echo $adminCount = Admin::where(['email'=> $data['email'], 'password' =>$data['password'], 'Status'=>1])->count();die;
         $adminCount = Admin::where(['email'=> $data['email'],'password'=>md5($data['password']),'Status' => 1])->count();

            if($adminCount>0){
                Session::put('adminSession', $data['email']);
                return redirect(url('/admin/dashboard'));

        }else{
           //return back()->with('faikure', 'invalid credentials');
            return redirect('/admin/login')->with('flash_message_error','Invalid Username or password');
        }

        return view('admin.admin_login');
    }



    // public function logout(Request $request) {
    //     Auth::logout();

    //     return redirect(url('admin/login'))->with('flash_message_success','logged out successfully');
    // }
}
