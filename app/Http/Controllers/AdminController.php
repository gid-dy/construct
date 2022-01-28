<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Hash;
use App\User;
use App\Booking;
use App\Admin;
use App\Country;
use Illuminate\Support\Facades\Mail;
use Auth;
use DB;
use Carbon\Carbon;
use Validator;

class AdminController extends Controller
{



    public function dashboard()
    {

         
        return view('admin.dashboard');
    }

    public function settings()
    {
        $adminDetails = Admin::where(['email'=>Session::get('adminSession')])->first();
        // dd($adminDetails);
        return view('admin.settings')->with(compact('adminDetails'));
    }

    public function chkpassword(Request $request)
    {
        $data = $request->all();
        $adminCount = Admin::where(['email'=> Session::get('adminSession'),'password'=>md5($data['current_pwd'])])->count();
        if($adminCount == 1){
            echo "true"; die;
        }else {
            echo "false"; die;
        }
    }

    public function updatepassword(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $adminCount = Admin::where(['email'=> Session::get('adminSession'),'password'=>md5($data['current_pwd'])])->count();
            if($adminCount == 1){
                $password = md5($data['new_pwd']);
                Admin::where('email',Session::get('adminSession'))->update(['password'=>$password]);
                return redirect('/admin/settings')->with('flash_message_success','password updated Successfully!');
            }else {
                return redirect('/admin/settings')->with('flash_message_error','Incorrect Current password!');
            }
        }
    }

    public function forgotpassword(Request $request){
        $meta_title ="Forgot password - MS World";
         if($request->isMethod('post')){
             $data = $request->all();
             $adminCount = Admin::where('email',$data['email'])->count();
             if($adminCount == 0){
                 return redirect()->back()->with('flash_message_error', 'Email does not exists!');
             }
             $AdminDetails = Admin::where('email', $data['email'])->first();

             //Generate random password
             $random_password = str_random(8);

             //Encode/ Secure password
             $new_pwd = md5($random_password);

             //Update password
             User::where('email', $data['email'])->update(['password'=>$new_pwd]);

             //Send forgot password Email Code
             $email = $data['email'];
             $messageData=[
                 'email'=>$email,
                 'password'=>$random_password
             ];
             Mail::send('emails.adminforgotpassword', $messageData, function($message)use($email){
                 $message->to($email)->subject('New password - MS World');
             });
             return redirect('/admin/login')->with('flash_message_success','Please check your email for new password');
         }
         return view('admin.admin_login')->with(compact('meta_title'));
     }

    public function logout()
    {
        Session::flush();
        return redirect('/admin/login')->with('flash_message_success','logged out successfull');
    }

    public function viewAdmins(){
        $admins = Admin::get();

        return view('admin.admins.view_admins')->with(compact('admins'));
    }

    public function addAdmin(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // dd($data);
            $adminCount = Admin::where('email',$data['email'])->count();
            if($adminCount>0){
                return redirect()->back()->with('flash_message_error', 'Admin already exist!');
            }else{
                if(empty($data['Status'])){
                    $data['Status'] = 0;
                }
                if ($data['Type']=="Admin") {
                    $admin = new Admin;
                    $admin->Type =$data['Type'];
                    $admin->email = $data['email'];
                    $admin->password = md5($data['password']);
                    $admin->Status = $data['Status'];
                    $admin->save();
                    return redirect()->back()->with('flash_message_success', 'Admin added successfully');
                }elseif ($data['Type']=="Sub-Admin") {
                    if(empty($data['Categories_access'])){
                        $data['Categories_access'] = 0;
                    }
                    if(empty($data['Services_access'])){
                        $data['Services_access'] = 0;
                    }
                    if(empty($data['Bookings_access'])){
                        $data['Bookings_access'] = 0;
                    }
                    if(empty($data['Users_access'])){
                        $data['Users_access'] = 0;
                    }

                    $admin = new Admin;
                    $admin->Type =$data['Type'];
                    $admin->email = $data['email'];
                    $admin->password = md5($data['password']);
                    $admin->Status = $data['Status'];
                    $admin->Categories_access = $data['Categories_access'];
                    $admin->Services_access =$data['Services_access'];
                    $admin->Bookings_access =$data['Bookings_access'];
                    $admin->Users_access =$data['Users_access'];
                    $admin->save();
                    return redirect()->back()->with('flash_message_success', 'Sub Admin added successfully');
                }

            }
        }
        return view('admin.admins.add_admin');
    }

    public function editAdmin(Request $request, $id){
        $adminDetails = Admin::where('id', $id)->first();
        // $adminDetails = json_decode(json_encode($adminDetails));
        // dd($adminDetails);
        if ($request->isMethod('post')) {
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            //dd($data);
            if(empty($data['Status'])){
                $data['Status'] = 0;
            }
            if ($data['Type']=="Admin") {
                Admin::where('email', $data['email'])->update(['password'=>md5($data['password']), 'Status'=>$data['Status']]);
                return redirect()->back()->with('flash_message_success', 'Admin updated successfully');
            }elseif ($data['Type']=="Sub-Admin") {
                if(empty($data['Categories_access'])){
                    $data['Categories_access'] = 0;
                }
                if(empty($data['Services_access'])){
                    $data['Services_access'] = 0;
                }
                if(empty($data['Bookings_access'])){
                    $data['Bookings_access'] = 0;
                }
                if(empty($data['Users_access'])){
                    $data['Users_access'] = 0;
                }

                Admin::where('email', $data['email'])->update(['password'=>md5($data['password']),
                'Status'=>$data['Status'],
                'Categories_access'=>$data['Categories_access'],
                'Services_access'=>$data['Services_access'],
                'Bookings_access'=>$data['Bookings_access'],
                'Users_access'=>$data['Users_access']]);
                return redirect()->back()->with('flash_message_success', 'Sub Admin updated successfully');
            }
        }
        return view('admin.admins.edit_admin')->with(compact('adminDetails'));
    }

    public function viewUsersChart(){

    }

}
