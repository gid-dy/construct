<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;
use DB;

class Services extends Model
{
    public function servicetypes(){
        return $this->hasMany('App\Servicetype','Service_id');
    }

    public function serviceimages(){
        return $this->hasMany('App\Serviceimages','Service_id');
    }

    public static function cartCount(){
        if(Auth::check()){
            //user is logged in, we will use Auth
            $email = Auth::user()->email;
            $cartCount = DB::table('carts')->where('email',$email)->count('Session_id');
        }else{
            $Session_id = Session::get('Session_id');
            $cartCount = DB::table('carts')->where('Session_id',$Session_id)->count('Session_id');
        }
        return $cartCount;
    }
    public static function servicesCount($cat_id){
        $catCount = Services::where(['Category_id'=>$cat_id, 'Status'=>1])->count();
        return $catCount;
    }
  
    public static function getServiceSize($Service_id, $ServiceType){
        $getServiceSize = Servicetype::select('ServiceSize')->where(['Service_id'=>$Service_id, 'ServiceType'=>$ServiceType])->first();
        return $getServiceSize->ServiceSize;
    }

    public static function getServicePrice($Service_id,$ServiceType){
        $getServicePrice = Servicetype::select('ServicePrice')->where(['Service_id'=>$Service_id,'ServiceType'=>$ServiceType])->first();
        return $getServicePrice->ServicePrice;
    }

    public static function deleteCartPackage($Service_id, $email){
        DB::table('carts')->where(['Service_id'=>$Service_id,'email'=>$email])->delete();
    }

    public static function getServiceStatus($Service_id){
        $getServiceStatus = Services::select('Status')->where('id', $Service_id)->first();
        return $getServiceStatus->Status;
    }

    public static function getCategoryStatus($Category_id){
        $getCategoryStatus = Category::select('CategoryStatus')->where('id', $Category_id)->first();
        return $getCategoryStatus->CategoryStatus;
    }

    public static function getServiceTypeCount($Service_id,$ServiceType){
        $getServiceTypeCount = Servicetype::where(['Service_id'=>$Service_id,'ServiceType'=>$ServiceType])->count();
        return $getServiceTypeCount;
    }

    public static function getCart($ServicePrice){
        $getCart = DB::table('carts')->where(['ServicePrice'=>$ServicePrice])->count();
        return $getCart;
    }

    public static function getGrandTotal(){
        $getGrandTotal = "";
        $SurName = Auth::user()->email;
        $userCart = DB::table('carts')->where('email',$SurName)->get();
        $userCart = json_decode(json_encode($userCart),true);
        // echo "<pre>"; print_r($userCart); die;
        foreach($userCart as $serve){
            $servePrice = Servicetype::where(['Service_id'=>$serve['Service_id'],'ServiceType'=>$serve['ServiceType']])->first();
            $ServicePriceArray[] = $servePrice->ServicePrice;
        }
        //echo print_r($PackagePriceArray);die;
        $GrandTotal = array_sum($ServicePriceArray) - Session::get('CouponAmount');
        return $GrandTotal;
    }
}
