<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Country;
use Auth;
use Session;
use Hash;
use Illuminate\Support\Facades\Mail;
use App\Exports\usersExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DB;
use Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     /**
      * Where to redirect users after registration.
      *
      * @var string
      */
     //protected $redirectTo = '/cart';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function showRegistrationForm(){
        $meta_title ="User Register - MS World";
        return view('user.register')->with(compact('meta_title'));
    }

    public function register(Request $request){
      //if($request->isMethod('post')){
         $data = $request->all();
         $validator = Validator::make($request->all(), [
            'SurName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'OtherNames' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'email' => 'required|email',
            'Mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' =>'min:8',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

         //check if user already exists
         $UserCount = User::where('email',$data['email'])->count();
         if($UserCount>0){
             return redirect()->back()->with('flash_message_error', 'Email already exists!');
         }else{
            $user = new User;
            $user->SurName = $data['SurName'];
            $user->OtherNames = $data['OtherNames'];
            $user->email = $data['email'];
            $user->Mobile = $data['Mobile'];
            $user->password = bcrypt($data['password']);
            $user->save();

            //Send Register Email
            // $email = $data['email'];
            // $messageData = ['email'=>$data['email'],'SurName'=>$data['SurName']];
            // Mail::send('emails.register', $messageData,function($message) use($email){
            //     $message->to($email)->subject('Registration with MS World');
            // });

            //Send Confirmation Email
            $email = $data['email'];
            $messageData = ['email'=>$data['email'], 'SurName'=>$data['SurName'], 'code'=>base64_encode($data['email'])];
            Mail::send('emails.confirmation', $messageData,function($message) use($email){
                $message->to($email)->subject('E-mail confirmation');
            });
            return redirect()->back()->with('flash_message_success', 'Confirm your email to activate your account');

            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                Session::put('frontSession', $data['email']);

                if(!empty(Session::get('Session_id'))){
                    $Session_id = Session::get('Session_id');
                    DB::table('carts')->where('Session_id', $Session_id)->update(['email'=> $data['email']]);
                }
                return redirect('/cart');
            }


        }
         //}

    }


     public function showLoginForm(Request $request){
        $meta_title ="User Login - MS World";
         return view('user.login')->with(compact('meta_title'));
     }

     public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $request->input();
        $user = User::where('email', $data['email'])->first();

        if ($user && Hash::check($data['password'], $user->password)){
            $users = User::where('email', $data['email'])->first();
            if($user->Status == 0){
                return redirect()->back()->with('flash_message_error','Your account is not activated!');
            }
            Session::put('frontSession', $data['email']);
            Auth::login($user);
            //if($user->Status == 1)

            if(!empty(Session::get('Session_id'))){
                $Session_id = Session::get('Session_id');
                DB::table('carts')->where('Session_id',$Session_id)->update(['email'=> $data['email']]);
            }
            return redirect(url('/cart'));
        }else{
            return redirect()->back()->with('flash_message_error','Invalid Username or password');
        }



     }


     public function forgotpassword(Request $request){
        $meta_title ="Forgot password - MS World";
         if($request->isMethod('post')){
             $data = $request->all();
             $UserCount = User::where('email',$data['email'])->count();
             if($UserCount == 0){
                 return redirect()->back()->with('flash_message_error', 'Email does not exists!');
             }
             $userDetails = User::where('email', $data['email'])->first();

             //Generate random password
             $random_password = str_random(8);

             //Encode/ Secure password
             $new_password = bcrypt($random_password);

             //Update password
             User::where('email', $data['email'])->update(['password'=>$new_password]);

             //Send forgot password Email Code
             $email = $data['email'];
             $SurName =$userDetails->SurName;
             $OtherNames =$userDetails->OtherNames;
             $messageData=[
                 'email'=>$email,
                 'SurName'=>$SurName,
                 'OtherNames'=>$OtherNames,
                 'password'=>$random_password
             ];
             Mail::send('emails.forgotpassword', $messageData, function($message)use($email){
                 $message->to($email)->subject('New password - MS World');
             });
             return redirect('/login')->with('flash_message_success','Please check your email for new password');
         }
         return view('user.forgot_password')->with(compact('meta_title'));
     }


     public function confirmAccount($email){
         $email = base64_decode($email);
         $UserCount = User::where('email', $email)->count();
         if($UserCount>0){
             $userDetails=User::where('email', $email)->first();
             if($userDetails->Status == 1){
                 return redirect('/register')->with('flash_message_success','Your Email account is already activated.You can login in now');
             }else{
                 User::where('email', $email)->update(['Status'=>1]);

                 //Send Register Email
                $messageData = ['email'=>$email,'SurName'=>$userDetails->SurName];
                Mail::send('emails.welcome', $messageData,function($message) use($email){
                    $message->to($email)->subject('Welcome to MS World');
                });
                 return redirect('/register')->with('flash_message_success','Your Email account is activated.You can login in now');
             }
         }else{
             abort(404);
         }
     }

     public function account(Request $request)
     {
        $meta_title ="User Update Account - MS World";
            $user_id = Auth::user()->id;
            $userDetails = User::find($user_id);

            if($request->isMethod('post')){
                $data = $request->all();
                $validator = Validator::make($request->all(), [
                    'SurName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                    'OtherNames' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                    'email' => 'required|email',
                    'Mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                    'OtherContact' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                    'City' => 'regex:/^[\pL\s\-]+$/u|max:255'

                ]);
                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                if(empty($data['SurName'])){
                    return redirect()->back()->with('flash_message_error', 'Please enter your name');
                }

                if(empty($data['City'])){
                    $data['City']='';
                }
                

                if(empty($data['OtherContact'])){
                    $data['OtherContact']='';
                }

                $user = User::find($user_id);
                $user->SurName = $data['SurName'];
                $user->OtherNames = $data['OtherNames'];
                $user->email = $data['email'];
                $user->City = $data['City'];
                $user->Mobile = $data['Mobile'];
                $user->OtherContact = $data['OtherContact'];
                $user->save();
                return redirect()->back()->with('flash_message_success', 'Your account details has been successfully updated!');
            }
            return view('user.account')->with(compact('userDetails','meta_title'));

        }

        public function change_password()
        {
            return view('user.change_password');
        }

     public function chkUserpassword(Request $request) {
         $data = $request->all();
         //echo "<pre>"; print_r($data); die;
         $current_password =$data['current_pwd'];
         $user_id = Auth::User()->id;
         $check_password = User::where('id',$user_id)->first();
         if(Hash::check($current_password, $check_password->password)){
             echo "true"; die;
         }else{
             echo "false"; die;
         }

     }

     public function updatepassword(Request $request) {
        $data = $request->all();
        $old_pwd =User::where('id',Auth::User()->id)->first();
        $current_pwd = $data['current_pwd'];
        if(Hash::check($current_pwd,$old_pwd->password)){
            //update password
            $new_pwd =bcrypt($data['new_pwd']);
            User::where('id',Auth::User()->id)->update(['password'=>$new_pwd]);
            return redirect()->back()->with('flash_message_success', 'password updated Successfully!');
        }else{
            return redirect()->back()->with('flash_message_error', 'Current password is incorrect!');
        }
     }

    public function logout(Request $request) {
        Auth::logout();
        Session::forget('Session_id');
        return redirect(url('/'));
    }

    public function viewUsers(){
        $users = User::get();
        return view('admin.users.view_users')->with(compact('users'));
    }

    public function exportUsers(){
        if(Session::get('adminDetails')['Users_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        return Excel::download(new usersExport, 'users.xlsx');

    }

    public function viewUsersChart(){
         $current_month_users =User::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->month)->count();
        $last_month_users =User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1))->count();
         $last_to_last_month_users =User::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->subMonth(2))->count();
        return view('admin.users.view_users_chart')->with(compact('current_month_users','last_month_users','last_to_last_month_users'));
    }

    public function viewUsersCountriesChart(){
        if(Session::get('adminDetails')['Users_access']==0){
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module');
        }
        $getUserCountries = User::select('Country',DB::raw('count(Country) as count'))->groupBy('Country')->get();
        $getUserCountries = json_decode(json_encode($getUserCountries),true);
        // dd($getUserCountries[0]['Country']);
        return view('admin.users.view_users_countries_chart')->with(compact('getUserCountries'));

    }

}
