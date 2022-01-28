<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Closure;
use Session;
use App\Admin;

class Adminlogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty(Session::has('adminSession'))){
            return redirect('admin/login');
        }else{
            $adminDetails = Admin::where('email',Session::get('adminSession'))->first();
            $adminDetails = json_decode(json_encode($adminDetails),true);
           
            Session::put('adminDetails',$adminDetails);

            // echo "<pre>"; print_r($adminDetails); die;

            //Get current Path
            $currentPath = Route::getFacadeRoot()->current()->uri();

           
        }
        return $next($request);
    }
}
