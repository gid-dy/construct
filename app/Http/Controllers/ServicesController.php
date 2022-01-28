<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Exports\servicesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Str;
use App\Services;
use App\Feedback;
use App\Country;
use App\Servicetype;
use App\Tourlocations;
use App\Accommodation;
use App\Serviceimages;
use App\Tourtransportation;
use App\Tourinclude;
use App\Coupon;
use App\User;
use App\Booking;
use App\BookingsService;
use App\RentalAddress;
use Auth;
use Image;
use App\Category;
use Dompdf\Dompdf;
use Session;
use DB;
use Carbon\Carbon;
use Validator;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addservice(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
             //echo "<pre>"; print_r($data); die;
             if(empty($data['featured_service'])){
                $featured_service = 0;
            }else{
                $featured_service = 1;
            }
            if(empty($data['Status'])){
                $Status = 0;
            }else{
                $Status = 1;
            }

             if(empty($data['Category_id'])){
                 return redirect()->back()->with('flash_message_error', 'Select Under category option!');
             }
            
            if(empty($data['ServicePrice'])){
                return redirect()->back()->with('flash_message_error', 'Price cannot be empty!');
            }

            $validator = Validator::make($request->all(), [
                'ServiceName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'ServicePrice' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $services = new Services;
            $services->Category_id = $data['Category_id'];
            $services->ServiceName = $data['ServiceName'];
            if (!empty($data['Description'])) {
                $services->Description = $data['Description'];
            }else{
                $services->Description = '';
            }
            $services->ServicePrice = $data['ServicePrice'];
            $services->Status = $Status;
            $services->featured_service = $featured_service;

             //upload image
             if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,999999).'.'.$extension;
                    $large_image_path = 'images/backend_images/services/large/'.$filename;
                    $medium_image_path = 'images/backend_images/services/medium/'.$filename;
                    $small_image_path = 'images/backend_images/services/small/'.$filename;

                    //Resize Images
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(270,180)->save($medium_image_path);
                    Image::make($image_tmp)->resize(135,90)->save($small_image_path);

                    //store image name in services table
                    $services->image =$filename;
                }

            }
            $services->save();
            return redirect('/admin/view_services')->with('flash_message_success','Service has been added successfully!');
        }
        $category = Category::get();
        $category_dropdown ="<option value='' selected disabled>Select</option>";
        foreach ($category as $cat) {
            $category_dropdown .= "<option value='".$cat->id."'>".$cat->CategoryName."</option>";
        }
        return view('admin.service.service')->with(compact('category_dropdown'));
    }

    public function viewService()
    {
        $services = Services::get();
        $services = json_decode(json_encode($services));
            foreach($services as $key => $val){
                $CategoryName = Category::where(['id'=>$val->Category_id])->first();
                $services[$key]->CategoryName = $CategoryName->CategoryName;
            }

        return view('admin.service.view_services')->with(compact('services'));
    }

    public function editService(Request $request, $id=null)
    {
       
        if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['Status'])){
                $Status = 0;
            }else{
                $Status = 1;
            }

            if(empty($data['featured_service'])){
                $featured_service = 0;
            }else{
                $featured_service = 1;
            }

            if(empty($data['Category_id'])){
                return redirect()->back()->with('flash_message_error', 'Select Under category option!');
            }

            $validator = Validator::make($request->all(), [
                'ServiceName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'ServicePrice' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,999999).'.'.$extension;
                    $large_image_path = 'images/backend_images/services/large/'.$filename;
                    $medium_image_path = 'images/backend_images/services/medium/'.$filename;
                    $small_image_path = 'images/backend_images/services/small/'.$filename;

                    //Resize Images
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(270,180)->save($medium_image_path);
                    Image::make($image_tmp)->resize(135,90)->save($small_image_path);
                }
            }else{
                $filename = $data['current_image'];
            }
            if (empty($data['description'])) {
                $data['description']= '';
            }

            Services::where(['id'=>$id])->update([
                'Category_id'=>$data['Category_id'],
                'ServiceName'=>$data['ServiceName'],
                'Description'=>$data['Description'],
                'ServicePrice'=>$data['ServicePrice'],
                'Status'=>$Status,
                'featured_service'=>$featured_service,
                'image'=>$filename

            ]);
            return redirect()->back()->with('flash_message_success', 'Service has been updated successfully!');
        }

        $servicesDetails = Services::where(['id'=>$id])->first();

        $category = Category::get();
        $category_dropdown ="<option value='' selected disabled>Select</option>";
        foreach ($category as $cat) {
            if($cat->id==$servicesDetails->Category_id){
                $selected ="selected";
            }else{
                $selected = " ";
            }
            $category_dropdown .= "<option value='".$cat->id."' ".$selected.">".$cat->CategoryName."</option>";
        }

        return view('admin.service.edit_services')->with(compact('servicesDetails', 'category_dropdown'));
    }

    public function deleteServiceImage($id = null)
    {
      
        $serviceimage = Services::where(['id'=>$id])->first();
        //echo $serviceimage->image; die;
        $large_image_path = 'images/backend_images/services/large/';
        $medium_image_path = 'images/backend_images/services/medium/';
        $small_image_path = 'images/backend_images/services/small/';

        //deleting large image if not exist in folder
        if(file_exists($large_image_path.$serviceimage->image)){
            unlink($large_image_path.$serviceimage->image);
        }

         //deleting medium image if not exist in folder
         if(file_exists($medium_image_path.$serviceimage->image)){
            unlink($medium_image_path.$serviceimage->image);
        }

        //deleting small image if not exist in folder
        if(file_exists($small_image_path.$serviceimage->image)){
            unlink($small_image_path.$serviceimage->image);
        }

        Services:: where(['id'=>$id])->update(['image'=>'']);
        return redirect()->back()->with('flash_message_success', 'Service Image has been deleted successfully!');
    }

    public function deleteService($id=null)
    {
       
        Services::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Service has been deleted successfully!');
    }

    public function deleteServicetype($id = null)
    {
       
        Servicetype::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Service type has been deleted successfully!');
    }


    public function Servicetype(Request $request, $id = null)
    {
     
        $servicesDetails = Services::with('servicetypes')->where(['id'=>$id])->first();
        // $servicesDetails = json_decode(json_encode($servicesDetails ));
        // echo "<pre>"; print_r($servicesDetails); die;


        if($request->isMethod('post')){
            $data = $request->all();

            foreach($data['SKU'] as $key => $val){
                if(!empty($val)){
                    //prevent duplicate sku
                    $typeCountSKU = Servicetype::where('SKU', $val)->count();
                    if($typeCountSKU>0){
                        return redirect('admin/add-Servicetype/'.$id)->with('flash_message_error', 'SKU already exist! Please add another SKU.');
                    }

                    //prevent duplicate Servicetype
                    $typeCountName = Servicetype::where(['Service_id'=>$id,'ServiceType'=>$data['ServiceType'][$key]])->count();
                    if($typeCountName>0){
                        return redirect('admin/add-Servicetype/'.$id)->with('flash_message_error','"'.$data['ServiceType'][$key].'"Service type name already exist for this tour! Please add another name.');
                    }


                    $Servicetype = new Servicetype;
                    $Servicetype->Service_id =$id;
                    $Servicetype->SKU =$val;
                    $Servicetype->ServiceType =$data['ServiceType'][$key];
                    $Servicetype->ServiceSize =$data['ServiceSize'][$key];
                    $Servicetype->ServicePrice =$data['ServicePrice'][$key];
                    $Servicetype->save();
                }
            }
            return redirect('admin/add-Servicetype/'.$id)->with('flash_message_success', 'Service Type has been added successfully');
        }
        return view('admin.service.add_servicetype')->with(compact('servicesDetails'));
    }

    public function editservicetype(Request $request, $id = null)
    {
       
        if($request->isMethod('post')){
            $data = $request->all();

            //echo "<pre>"; print_r($data); die;
             foreach($data['idType'] as $key => $type){
                 Servicetype::where(['id' =>$data['idType'][$key]])->update([
                     'ServicePrice'=>$data['ServicePrice'][$key],
                     'ServiceSize'=>$data['ServiceSize'][$key]
                     ]);
             }
             return redirect()->back()->with('flash_message_success', 'Service Type has been updated successfully');
         }
    }



    public function image(Request $request, $id = null)
    {
     
        $servicesDetails = Services::with('serviceimages')->where(['id'=>$id])->first();

        if($request->isMethod('post')){
            $data = $request->all();
           if($request->hasFile('Image')){
            $files = $request->file('Image');
               foreach($files as $file){
                //upload image
                 $Image = new Serviceimages;
                 $extension = $file->getClientOriginalExtension();
                 $fileName = rand(111,999999).'.'.$extension;

                 $large_image_path = 'images/backend_images/services/large/'.$fileName;
                 $medium_image_path = 'images/backend_images/services/medium/'.$fileName;
                 $small_image_path = 'images/backend_images/services/small/'.$fileName;

                 //Resize Images
                 Image::make($file)->save($large_image_path);
                 Image::make($file)->resize(270,180)->save($medium_image_path);
                 Image::make($file)->resize(135,90)->save($small_image_path);

                 $Image->Image =$fileName;
                 $Image->Service_id = $data['Service_id'];
                 $Image->save();
               }
               return redirect('admin/add-image/'.$id)->with('flash_message_success', 'Image has been added successfully');
            }
        }
        $serviceimages = Serviceimages::where(['Service_id' => $id])->get();
        $serviceimages = json_decode(json_encode($serviceimages));

        return view('admin.service.add_image')->with(compact('servicesDetails','serviceimages'));
    }

    public function deleteAltimage($id = null)
    {
       
        $serviceimage = Serviceimages::where(['id'=>$id])->first();
        //echo $serviceimage->image; die;
        $large_image_path = 'images/backend_images/services/large/';
        $medium_image_path = 'images/backend_images/services/medium/';
        $small_image_path = 'images/backend_images/services/small/';

        //deleting large image if not exist in folder
        if(file_exists($large_image_path.$serviceimage->Image)){
            unlink($large_image_path.$serviceimage->Image);
        }

         //deleting medium image if not exist in folder
         if(file_exists($medium_image_path.$serviceimage->Image)){
            unlink($medium_image_path.$serviceimage->Image);
        }

        //deleting small image if not exist in folder
        if(file_exists($small_image_path.$serviceimage->Image)){
            unlink($small_image_path.$serviceimage->Image);
        }

        Serviceimages:: where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Alt Image has been deleted successfully!');
    }


    public function Serve($CategoryName = null)
    {

        $countCategory = Category::where(['CategoryName'=>$CategoryName, 'CategoryStatus'=>1])->count();
        if ($countCategory==0){
            abort(404);
        }
        $servicecategory = Category::with('servecategories')->where($id=null)->get();
        $categoryDetails = Category::where(['CategoryName'=>$CategoryName])->first();

        $servicesAll = Services::where(['services.Category_id' => $categoryDetails->id ])->where('services.Status','1')->orderBy('services.id','DESC');


        if(!empty($_GET['ServiceType'])){
            $TourTypeNameArray = explode('-', $_GET['ServiceType']);
            $servicesAll = $servicesAll->join('servicetypes','servicetypes.Service_id','=','services.id')
            ->select('services.*','servicetypes.Service_id','servicetypes.ServiceType')
            ->groupBy('servicetypes.Service_id')
            ->whereIn('servicetypes.ServiceType',$TourTypeNameArray);
        }

        $servicesAll = $servicesAll->paginate(6);
        // $servicesAll = json_decode(json_encode($servicesAll));
        // dd($servicesAll);

        $TourTypeNameArray = Servicetype::select('ServiceType')->groupBy('ServiceType')->get();
        $TourTypeNameArray =array_flatten(json_decode(json_encode($TourTypeNameArray),true));
        //dd($TourTypeNameArray);
        //echo "<pre>"; print_r($TourTypeNameArray); die;

        //meta
        $meta_title = $categoryDetails->meta_title;
        $meta_description = $categoryDetails->meta_description;
        $meta_keywords = $categoryDetails->meta_keywords;
        return view('service.package')->with(compact('servicecategory','categoryDetails', 'servicesAll','meta_title','meta_description','meta_keywords','CategoryName','TourTypeNameArray'));
    }

    public function filter(Request $request){
        $data = $request->all();
        //dd($data);

        $TourTypeNameUrl="";
        if(!empty($data['TourTypeNameFilter'])){
            foreach($data['TourTypeNameFilter'] as $ServiceType){
                if(empty($TourTypeNameUrl)){
                    $TourTypeNameUrl = "&ServiceType=".$ServiceType;
                }else{
                    $TourTypeNameUrl .= "-".$ServiceType;
                }
            }
        }
        $finalUrl = "serve/".$data['CategoryName']."?".$TourTypeNameUrl;
        return redirect::to($finalUrl);
    }

    public function searchServe(Request $request){
        $data = $request->all();
        $servicecategory = Category::with('servecategories')->where($id=null)->get();
        $search_service = $data['service'];
        // $servicesAll = Services::where('ServiceName', 'like','%'.$search_tour.'%')->orwhere('PackageCode',$search_tour)->where('Status',1)->get();

        $servicesAll = Services::where(function($query) use($search_service){
            $query->where('ServiceName','like','%'.$search_service.'%');
        })->where('Status',1)->get();
        return view('service.package')->with(compact('servicecategory','search_service', 'servicesAll'));
     }



    public function services($id = null)
    {

        $servicesCount = Services::where(['id'=>$id, 'Status'=>1])->count();
        if($servicesCount == 0){
            abort(404);
        }

        //$servicecategory = Category::with('servecategories')->where($id=null)->get();
        $servicesDetails = Services::with('servicetypes')->where('id', $id)->first();
        $servicesDetails = json_decode(json_encode($servicesDetails));

       // echo "<pre>"; print_r($servicesDetails);die;
       $relatedService = Services::where('id','!=',$id)->where(['Category_id'=>$servicesDetails->Category_id])->get();


       $serviceAltImage = Serviceimages::where('Service_id',$id)->get();
        //    $tourAltImage = json_decode(json_encode($tourAltImage));
        //    echo "<pre>"; print_r($tourAltImage); die;

        $total_availability = Servicetype::where('Service_id',$id)->sum('ServiceSize');
        //dd( $servicesDetails);

        $feedbacks = Feedback::where('Status', '1')->get();
        // $banners = Banner::where('Status', '1')->get();


        //meta
        $meta_title = $servicesDetails->ServiceName;
        $meta_description = $servicesDetails->Description;
        $meta_keywords = $servicesDetails->ServiceName;
        return view('service.details')->with(compact('servicesDetails','serviceAltImage','relatedService','total_availability','meta_title','meta_description','meta_keywords','feedbacks'));
    }


    public function getServicePrice(Request $request)
    {
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        $serviceArr = explode("-", $data['idServiceType']);
        //echo $tourArr[0]; echo $tourArr[1]; die;

        $servicetypeAtt = Servicetype::where(['Service_id' => $serviceArr[0], 'ServiceType' => $serviceArr[1]])->first();
        echo $servicetypeAtt->ServicePrice;
        
    }


    // public function getTransportCost(Request $request)
    // {
    //     $data = $request->all();
    //     // echo "<pre>"; print_r($data); die;
    //     $tranArr = explode("-", $data['idTransportName']);

    //     //echo $tourArr[0]; echo $tourArr[1]; die;

    //     $tranAtt = Tourtransportation::where(['Service_id' => $tranArr[0], 'TransportName' => $tranArr[1]])->first();
    //     echo $tranAtt->TransportCost;
    // }

    public function addtocart(Request $request){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $data = $request->all();
          //echo "<pre>"; print_r($data); die;


        if(!empty($data['wishlistbutton']) && $data['wishlistbutton']=="Add to wishlist"){
            // echo"Wish list selected";die;

            if(!Auth::check()){
                return redirect()->back()->with('flash_message_error','Please login to add to your wishlist');
            }

            //check size is selected
            if(empty($data['ServiceType'])){
                return redirect()->back()->with('flash_message_error','Please select Service Type to add to your wishlist');
            }

            //Get Service Type
            $ServiceTypeArr = explode("-", $data['ServiceType']);
            $ServiceType = $ServiceTypeArr[1];
            //Get Service package price
            $servePrice = Servicetype::where(['Service_id'=>$data['Service_id'], 'ServiceType'=>$ServiceType])->first();
            $ServicePrice = $servePrice->ServicePrice;


            // if (empty($data['TransportName'])){
            //     $data['TransportName'] = '';
            // }

            // $TransportNameArr = explode("-", $data['TransportName']);
            // $TransportName = $TransportNameArr[1];


            //Get User Email
            $email = Auth::user()->email;

            //Set Quantity as 1
            //$Quantity =1;

            //Get current date
            $created_at = Carbon::now();

            $wishlistCount = DB::table('wishlist')->where(['email'=>$email,'Service_id'=>$data['Service_id'],'ServiceName'=>$data['ServiceName'],'ServiceType'=>$ServiceType])->count();

            if($wishlistCount>0){
                return redirect()->back()->with('flash_message_error','Service  already exists in wishlist');
            }else{
                DB::table('wishlist')->insert([
                    'Service_id'=>$data['Service_id'],
                    'ServiceName'=>$data['ServiceName'],
                    'ServicePrice'=>$ServicePrice,
                    'ServiceType'=>$ServiceType,
                    'Quantity'=>$data['Quantity'],
                    'email'=>$email,
                    'created_at'=>$created_at]);
            return redirect()->back()->with('flash_message_success','Service  has been added to your wishlist');

            }


        }else{
            if (!empty($data['cartbutton']) && $data['cartbutton']=="Add-to-wishlist") {
                // $data['Quantity'] =1;
            }
            if(empty($data['ServiceType'])){
                return redirect()->back()->with('flash_message_error', 'Select Service type !');
            }
            //checking tour package availability
            $ServiceType = explode("-", $data['ServiceType']);
            //echo $data['Quantity']; die;
            $getServiceSize = Servicetype::where(['Service_id'=>$data['Service_id'],'ServiceType'=>$ServiceType[1]])->first();


            if($getServiceSize->ServiceSize<$data['Quantity']){
                return redirect()->back()->with('flash_message_error','Required Quantity is not available');
            }



            if(empty(Auth::user()->email)){
                $data['email'] = '';
            }else{
                $data['email'] = Auth::user()->email;
            }

            $Session_id = Session::get('Session_id');
            if(!isset($Session_id)){
                $Session_id = str::random(40);
                Session::put('Session_id',$Session_id);
            }

            // if (empty($data['TransportName'])){
            //     $data['TransportName'] = '';
            // }


            $ServiceTypeArr = explode("-", $data['ServiceType']);
            $ServiceType = $ServiceTypeArr[1];

            // $TransportNameArr = explode("-", $data['TransportName']);
            // $TransportName = $TransportNameArr[1];

            if(empty($data['ServiceType'])){
                return redirect()->back()->with('flash_message_error', 'Select Service type !');
            }
            if(empty(Auth::check())){
                $countServices = DB::table('carts')->where([
                    'Service_id'=>$data['Service_id'],
                    'ServiceName'=>$data['ServiceName'],
                    'ServiceType'=>$ServiceType,
                    'Session_id'=>$Session_id])->count();
                if($countServices>0){
                    return redirect()->back()->with('flash_message_error',  'Service  already exist in cart!');
                }
            }else{
                $countServices = DB::table('carts')->where([
                    'Service_id'=>$data['Service_id'],
                    'ServiceName'=>$data['ServiceName'],
                    'ServiceType'=>$ServiceType,
                    'email'=>$data['email']])->count();
                if($countServices>0){
                    return redirect()->back()->with('flash_message_error',  'Service  already exist in cart!');
                }
            }


                $getSKU =Servicetype::select('SKU')->where(['Service_id' =>$data['Service_id'],'ServiceType'=>$ServiceType])->first();
                DB::table('carts')->insert([
                    'Service_id'=>$data['Service_id'],
                    'ServiceName'=>$data['ServiceName'],
                    'ServicePrice'=>$data['ServicePrice'],
                    'Quantity'=>$data['Quantity'],
                    'ServiceType'=>$ServiceType,
                    // 'TransportName'=>$TransportName,
                    'email'=>$data['email'],
                    'Session_id'=>$Session_id]);

            return redirect('cart')->with('flash_message_success','tour added to cart');
        }

    }


    public function cart()
    {
        if(Auth::check()){
            $email = Auth::user()->email;
            $userCart = DB::table('carts')->where(['email'=>$email])->get();
        }else{
            $Session_id = Session::get('Session_id');
            $userCart = DB::table('carts')->where(['Session_id'=>$Session_id])->get();
        }

        foreach($userCart as $key =>$services){
            $servicesDetails = Services::where('id', $services->Service_id)->first();
            $userCart[$key]->image = $servicesDetails->image;
        }
        $meta_title = "Renting Cart - MS World";
        $meta_description = "View Renting Cart of MS World";
        $meta_keywords = "Renting cart, MS World";
        return view('service.cart')->with(compact('userCart','meta_title','meta_description','meta_keywords'));
    }
    public function wishlist(){
        if(Auth::check()){
            $email = Auth::user()->email;
        $userwishlist = DB::table('wishlist')->where('email',$email)->get();
        foreach($userwishlist as $key => $services){
            $servicesDetails = Services::where('id',$services->Service_id)->first();
            $userwishlist[$key]->image =$servicesDetails->image;
            }
        }else{
            $userwishlist = array();

        }
        $meta_title = "Wishlist - MS World";
        $meta_description = "View wishlist of MS World";
        $meta_keywords = "Wishlist, MS World";
        return view('tour.wishlist')->with(compact('userwishlist','meta_title','meta_description','meta_keywords'));
    }

    public function deletewishlistPackage($id = null){
        DB::table('wishlist')->where('id', $id)->delete();
        return redirect('wishlist')->with('flash_message_success', 'Service  has been deleted from wishlist!');
    }

    public function deleteCartPackage($id = null){
        DB::table('carts')->where('id', $id)->delete();
        return redirect('cart')->with('flash_message_success', 'Service  has been deleted from cart!');
    }

    public function UpdateCartQuantity($id = null, $Quantity=null){
        DB::table('carts')->where('id', $id)->increment('Quantity', $Quantity);
        return redirect('cart')->with('flash_message_success', 'Quantity  has been Updated Successfully!');
    }

    public function applyCoupon(Request $request)
    {
        Session::put('CouponAmount');
        Session::put('CouponCode');

        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        $couponCount = Coupon::where('CouponCode', $data['CouponCode'])->count();
        if($couponCount == 0){
            return redirect()->back()->with('flash_message_error', 'This coupon does not exist');
        }else{
            //get coupon details
            $couponDetails = Coupon::where('CouponCode', $data['CouponCode'])->first();

            //if coupon is Inactive
            if($couponDetails->Status==0){
                return redirect()->back()->with('flash_message_error', 'This coupon is not active');
            }
            //if coupon is expired
             $ExpiryDate = $couponDetails->ExpiryDate;
            $current_date = date('Y-m-d');
            if($ExpiryDate < $current_date){
                return redirect()->back()->with('flash_message_error', 'This coupon is expired');
            }

            //Coupon is valid for discount

            //Get Cart Total Amount
            $Session_id = Session::get('Session_id');

            if(Auth::check()){
                $email = Auth::user()->email;
                $userCart = DB::table('carts')->where(['email'=>$email])->get();
            }else{
                $Session_id = Session::get('Session_id');
                $userCart = DB::table('carts')->where(['Session_id'=>$Session_id])->get();
            }

            $total_amount = 0;
            foreach($userCart as $item){
                $total_amount = $total_amount + ($item->ServicePrice * $item->Quantity);

            }

            //check if amount type is fixed or percentage
            if($couponDetails->AmountType=="Fixed"){
                $couponAmount = $couponDetails->Amount;
            }else{
                //echo $total_amount;die;
                $couponAmount = $total_amount * ($couponDetails->Amount/100);
            }

            //add coupon code $ amount in session
            Session::put('CouponAmount', $couponAmount);
            Session::put('CouponCode', $data['CouponCode']);

            return redirect()->back()->with('flash_message_success', 'Coupon code successfully applied. You are availing discount!');
        }
    }

    public function billing(Request $request){
        $user_id =Auth::user()->id;
        $email =Auth::user()->email;
        $userDetails = User::find($user_id);
       
        //checking if Travelling Address exists
        $rentingCount = RentalAddress::where('user_id',$user_id)->count();
        $rentingDetails = array();
            if($rentingCount>0){
                $rentingDetails = RentalAddress::where('user_id',$user_id)->first();
            }

            //update cart table with user Email
            $Session_id = Session::get('Session_id');
            DB::table('carts')->where(['Session_id'=>$Session_id])->update(['email'=>$email]);
        if($request->isMethod('post')){
            $data =$request->all();

            //return to checkout page if any of the field is empty
            if(empty($data['billing_SurName']) || empty($data['billing_OtherNames']) ||
              empty($data['billing_Mobile']) || empty($data['billing_OtherContact']) ||
              empty($data['billing_City'])  ||
              empty($data['renting_SurName']) || empty($data['renting_OtherNames']) ||
              empty($data['renting_Mobile']) || empty($data['renting_OtherContact']) ||
               empty($data['renting_City'])){


                  return redirect()->back()->with('flash_message_error', 'Please fill all fields to Checkout!');
              }
              //Update user details
              User::where('id',$user_id)->update([
                  'SurName'=>$data['billing_SurName'],
                  'OtherNames'=>$data['billing_OtherNames'],
                  'Mobile'=>$data['billing_Mobile'],
                  'City'=>$data['billing_City'],
                  'OtherContact'=>$data['billing_OtherContact'],
              ]);

              if($rentingCount>0){
                  //update Travelling Address
                  RentalAddress::where('user_id',$user_id)->update([
                    'SurName'=>$data['renting_SurName'],
                    'OtherNames'=>$data['renting_OtherNames'],
                    'Mobile'=>$data['renting_Mobile'],
                    'City'=>$data['renting_City'],
                    'OtherContact'=>$data['renting_OtherContact']
                ]);
              }else{
                  //Add new renting Address
                  $renting = new RentalAddress;
                  $renting->user_id =$user_id;
                  $renting->email =$email;
                  $renting->SurName=$data['renting_SurName'];
                  $renting->OtherNames=$data['renting_OtherNames'];
                  $renting->Mobile=$data['renting_Mobile'];
                  $renting->OtherContact=$data['renting_OtherContact'];
                  $renting->City=$data['renting_City'];
                  $renting->save();
              }
              return redirect('/service-review');

        }
        $meta_title = "Checkout - MS World";
        return view('service.billing')->with(compact('userDetails','rentingDetails','meta_title'));
    }

    
    public function serviceReview(Request $request)
    {
        $user_id =Auth::user()->id;
        $email =Auth::user()->email;
        $userDetails = User::where('id',$user_id)->first();
        $rentingDetails = RentalAddress::where('user_id',$user_id)->first();
        $rentingDetails = json_decode(json_encode($rentingDetails));
        $userCart = DB::table('carts')->where(['email'=>$email])->get();
        foreach($userCart as $key =>$services){
            $servicesDetails = Services::where('id', $services->Service_id)->first();
            $userCart[$key]->image = $servicesDetails->image;
        }

        $meta_title = "Booking review - MS World";
        return view('service.service_review')->with(compact('userDetails','rentingDetails','userCart','meta_title'));
    }


    public function placePackage(Request $request)
    {
        if($request->isMethod('post')){
            $data= $request->all();
            $user_id = Auth::user()->id;
            $email = Auth::user()->email;

            //Prevent Sold out Packages from Booking
            $userCart = DB::table('carts')->where('email', $email)->get();
            foreach($userCart as $cart){

                $getServiceTypeCount =Services::getServiceTypeCount($cart->Service_id,$cart->ServiceType);
                if($getServiceTypeCount ==0){
                    Services::deleteCartPackage($cart->Service_id,$email);
                    return redirect('/cart')->with('flash_message_error', ' Service Type is not available! Please check again another time');
                }

                $servicesize = Services::getServiceSize($cart->Service_id,$cart->ServiceType);
                if($servicesize ==0){
                    Services::deleteCartPackage($cart->Service_id,$email);
                    return redirect('/cart')->with('flash_message_error', ' Service  is sold out and removed from Cart! Please check again another time');
                }
                if($cart->Quantity>$servicesize){
                    return redirect('/cart')->with('flash_message_error', 'Required quantity is not availalable now! Please try again later');
                }
                $serviceStatus = Services::getServiceStatus($cart->Service_id);
                if($serviceStatus==0){
                    Services::deleteCartPackage($cart->Service_id,$email);
                    return redirect('/cart')->with('flash_message_error', ' Disabled Service  removed from Cart! Please check again another time');
                }
                $getCatgoryId = Services::select('Category_id')->where('id', $cart->Service_id)->first();
                //echo $getCatgoryId->Category_id; die;
                $categoryStatus = Services::getCategoryStatus($getCatgoryId->Category_id);
                if($categoryStatus==0){
                    Services::deleteCartPackage($cart->Service_id,$email);
                    return redirect('/cart')->with('flash_message_error', ' One of the services category is disabled! Please try again');
                }

            }

            //Get renting Address of User
            $rentingDetails =RentalAddress::where(['email' => $email])->first();

            if(empty(Session::get('CouponCode'))){
                $CouponCode ='';
            }else{
                $CouponCode = Session::get('CouponCode');
            }

            if(empty(Session::get('CouponAmount'))){
                $Amount ='';
            }else{
                $Amount = Session::get('CouponAmount');
            }


            $Grand_total = Services::getGrandTotal();

            $booking = new Booking;
            $booking->user_id = $user_id;
            $booking->email = $email;
            $booking->SurName = $rentingDetails->SurName;
            $booking->OtherNames = $rentingDetails->OtherNames;
            $booking->City = $rentingDetails->City;
            $booking->Mobile = $rentingDetails->Mobile;
            $booking->OtherContact = $rentingDetails->OtherContact;
            $booking->CouponCode = $CouponCode;
            $booking->Amount = $Amount;
            $booking->Status = "new";
            $booking->Payment_method = $data['Payment_method'];
            $booking->Grand_total = $data['Grand_total'];
            $booking->save();

            $Booking_id = DB::getPdo()->lastInsertId();
            $cartPackages = DB::table('carts')->where(['email'=>$email])->get();
            foreach($cartPackages as$pro){
                $cartPro = new BookingsService;
                $cartPro->Booking_id = $Booking_id;
                $cartPro->user_id = $user_id;
                $cartPro->Service_id = $pro->Service_id;
                $cartPro->ServiceName = $pro->ServiceName;
                $cartPro->ServiceType = $pro->ServiceType;
                $cartPro->Quantity = $pro->Quantity;
                $ServicePrice = Services::getservicePrice($pro->Service_id, $pro->ServiceType);
                $cartPro->ServicePrice = $ServicePrice;
                $cartPro->save();

                //reduce TourSize
                $getServiceSize = Servicetype::where('SKU', $pro->ServiceType)->first();
                //  echo "Original Size: " .$getTourSize->ServiceSize;
                //  echo "ServiceSize to reduce: " .$pro->Quantity;
                //  $newSize = $getServiceSize->ServiceSize - $pro->Quantity;
                //  if($newSize<0){
                //      $newSize = 0;
                //  }
                 //Servicetype::where('SKU',$pro->ServiceType)->update(['ServiceSize'=>$newSize]);


            }
            Session::put('Booking_id',$Booking_id);
            Session::put('Grand_total',$data['Grand_total']);

            $servicesDetails = Booking::with('bookings')->where('id', $Booking_id)->first();
            $servicesDetails = json_decode(json_encode($servicesDetails),true);
            //dd($servicesDetails);

            $userDetails = User::where('id', $user_id)->first();
            $userDetails = json_decode(json_encode($userDetails),true);
            //dd($userDetails);
            /*Code for Booking Email starts*/
            $email = $email;
            $messageData = [
                'email'=>$email,
                'SurName'=>$rentingDetails->SurName,
                'OtherNames'=>$rentingDetails->OtherNames,
                'Booking_id'=>$Booking_id,
                'servicesDetails' =>$servicesDetails,
                'userDetails'=>$userDetails
            ];
            Mail::send('emails.booking', $messageData, function($message) use($email){
                $message->to($email)->subject('Booking Placed - MS World');
            });

            if($data['Payment_method']=="flutterwave"){
                //cod......redirect user to thanks page
                return redirect('/flutterwave');
            }else{
                //Ipay.....redirect user to ipay page
                return redirect('/ipay');
            }
        }
    }

    public function thanks(Request $request){
        $email = Auth::user()->email;
        DB::table('carts')->where('email', $email)->delete();
        return view('booking.thanks');
    }

    public function ipaythanks(Request $request){
        $email = Auth::user()->email;
        DB::table('carts')->where('email', $email)->delete();
        return view('booking.thanks_ipay');
    }

    public function ipaycancel(Request $request){
        $email = Auth::user()->email;
        DB::table('carts')->where('email', $email);
        return view('booking.cancel_ipay');
    }


    public function ipay(Request $request){
        $email = Auth::user()->email;
        DB::table('carts')->where('email', $email);
        return view('booking.ipay');
    }




    public function flutterwave(Request $request){
        $email = Auth::user()->email;
        DB::table('carts')->where('email', $email);
        $Booking_id = Session::get('Booking_id');
        $Grand_total = Session::get('Grand_total');
        $bookingDetails = Booking::getBookingDetails($Booking_id);
        $bookingDetails = json_decode(json_encode($bookingDetails));

        return view('booking.flutterwave');
    }
    public function flutterwavethanks(Request $request){
        $email = Auth::user()->email;
        DB::table('carts')->where('email', $email)->delete();
        return view('booking.thanks_flutterwave');
    }

    public function userBookings(){
        $user_id =Auth::user()->id;
        $bookings = Booking::with('Bookings')->where('user_id', $user_id)->orderBy('id','DESC')->get();

        return view('booking.users_bookings')->with(compact('bookings'));
    }

    public function userBookingDetails($Booking_id){
        $user_id = Auth::user()->id;
        $bookingDetails = Booking::with('bookings')->where('id',$Booking_id)->first();
        $bookingDetails = json_decode(json_encode($bookingDetails));

        return view('booking.users_bookings_details')->with(compact('bookingDetails'));
    }

    public function viewBookings(){
        $bookings = Booking::with('bookings')->orderBy('id', 'DESC')->get();
        $bookings = json_decode(json_encode($bookings));

        return view('admin.bookings.view_bookings')->with(compact('bookings'));
    }

    public function viewBookingDetails($Booking_id){
        $bookingDetails = Booking::with('bookings')->where('id',$Booking_id)->first();
        $bookingDetails =json_decode(json_encode($bookingDetails));
        $user_id = $bookingDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        return view('admin.bookings.booking_details')->with(compact('bookingDetails','userDetails'));
    }

    public function viewBookingInvoice($Booking_id){
       
        $bookingDetails = Booking::with('bookings')->where('id',$Booking_id)->first();
        $bookingDetails =json_decode(json_encode($bookingDetails));
        $user_id = $bookingDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        return view('admin.bookings.booking_invoice')->with(compact('bookingDetails','userDetails'));
    }

    public function viewPDFInvoice($Booking_id){
        
        $bookingDetails = Booking::with('bookings')->where('id', $Booking_id)->first();
        $bookingDetails =json_decode(json_encode($bookingDetails));
        $user_id = $bookingDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();

        $output = '<!DOCTYPE html>
        <html lang="en">
          <head>
            <meta charset="utf-8">
            <title>Example 1</title>
            <link rel="stylesheet" href="style.css" media="all" />
            <style>
            .clearfix:after {
                content: "";
                display: table;
                clear: both;
              }

              a {
                color: #5D6975;
                text-decoration: underline;
              }

              body {
                position: relative;
                width: 21cm;
                height: 29.7cm;
                margin: 0 auto;
                color: #001028;
                background: #FFFFFF;
                font-family: Arial, sans-serif;
                font-size: 12px;
                font-family: Arial;
              }

              header {
                padding: 10px 0;
                margin-bottom: 30px;
              }

              #logo {
                text-align: center;
                margin-bottom: 10px;
              }

              #logo img {
                width: 90px;
              }

              h1 {
                border-top: 1px solid  #5D6975;
                border-bottom: 1px solid  #5D6975;
                color: #5D6975;
                font-size: 2.4em;
                line-height: 1.4em;
                font-weight: normal;
                text-align: center;
                margin: 0 0 20px 0;
                background: url(dimension.png);
              }

              #project {
                float: left;
              }

              #project span {
                color: #5D6975;
                text-align: right;
                width: 52px;
                margin-right: 10px;
                display: inline-block;
                font-size: 0.8em;
              }

              #company {
                float: right;
                text-align: right;
              }

              #project div,
              #company div {
                white-space: nowrap;
              }

              table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
              }

              table tr:nth-child(2n-1) td {
                background: #F5F5F5;
              }

              table th,
              table td {
                text-align: center;
              }

              table th {
                padding: 5px 20px;
                color: #5D6975;
                border-bottom: 1px solid #C1CED9;
                white-space: nowrap;
                font-weight: normal;
              }

              table .service,
              table .desc {
                text-align: left;
              }

              table td {
                padding: 20px;
                text-align: right;
              }

              table td.service,
              table td.desc {
                vertical-align: top;
              }

              table td.unit,
              table td.qty,
               {
                font-size: 1.2em;
              }

              table td.grand {
                border-top: 1px solid #5D6975;;
              }

              #notices .notice {
                color: #5D6975;
                font-size: 1.2em;
              }

              footer {
                color: #5D6975;
                width: 100%;
                position: absolute;
                bottom: 0;
                border-top: 1px solid #C1CED9;
                padding: 8px 0;
                text-align: center;
              }
            </style>
          </head>
          <body>
            <header class="clearfix">
                <div id="logo">
                    <h2>GHANA<span style="color: #fafd44;">TREK</span></h2>
                </div>
                <h1>Booking #'. $bookingDetails->id.'</h1>
                <div id="project" class="clearfix">
                    <h2 class="to"><strong>Billing Address:</strong></h2>
                    <div><span>Name</span>  '. $userDetails->SurName.' '. $userDetails->OtherNames.'</div>
                    <div><span>City</span>  '. $userDetails->City.'</div>
                    <div><span>Mobile</span>    '. $userDetails->Mobile.'</div>
                    <div><span>OtherContact</span>  '. $userDetails->OtherContact .'</div>
                    <h2>Info</h2>
                    <div><span>Payment Method</span>   '. $bookingDetails->Payment_method.'</div>
                    <div><span>Booking Status</span>   '. $bookingDetails->Status.'</div>
                    <div><span>Booking Date</span>   '. $bookingDetails->created_at.'</div>
                </div>
                <div id="project" style="float:right">
                    <h2 class="to"><strong>Travelling Address:</strong></h2>
                    <div><span>Name</span>  '. $bookingDetails->SurName.' '. $bookingDetails->OtherNames.'</div>
                    <div><span>City</span>  '. $bookingDetails->City.'</div>
                    <div><span>Mobile</span>    '. $bookingDetails->Mobile.'</div>
                    <div><span>OtherContact</span>  '. $bookingDetails->OtherContact .'</div>
                </div>
            </header>
            <main>
              <table>
                <thead>
                  <tr>
                  <td class="text-center"><strong>ServiceName</strong></td>
                  <td class="text-center"><strong>ServiceType</strong></td>
                  <td class="text-center"><strong>ServicePrice</strong></td>
                  <td class="text-center"><strong>Quantity</strong></td>
                  <td class="text-right"><strong>Total</strong></td>
                  </tr>
                </thead>
                <tbody>';
                    $Subtotal = 0;
                    foreach ($bookingDetails->bookings as $pro) {
                    $output .='<tr>
                                <td style="text-align: center">'. $pro->ServiceName .'</td>
                                <td style="text-align: center">'. $pro->ServiceType .'</td>
                                <td style="text-align: center">GHS '. $pro->ServicePrice .'</td>
                                <td style="text-align: center">'. $pro->Quantity .'</td>
                                <td style="text-align: center">GHS '. $pro->ServicePrice * $pro->Quantity .'</td>
                            </tr>';

                    $Subtotal = $Subtotal + ($pro->ServicePrice * $pro->Quantity);
                }

            $output .='<tr>
                    <td colspan="5">SUBTOTAL</td>
                    <td class="total">GHS '. $Subtotal .'</td>
                  </tr>
                  <tr>
                    <td colspan="5">Coupon Discount (-)</td>
                    <td class="total">GHS '. $bookingDetails->Amount .'</td>
                  </tr>
                  <tr>
                    <td colspan="5" class="grand total">GRAND TOTAL</td>
                    <td class="grand total">GHS '. $bookingDetails->Grand_total .'</td>
                  </tr>
                </tbody>
              </table>
            </main>
            <footer>
              Invoice was created on a computer and is valid without the signature and seal.
            </footer>
          </body>
        </html>';

            // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($output);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
    }

    public  function updateBookingStatus(Request $request){
        
        if($request->isMethod('post')){
            $data = $request->all();
            Booking::where('id',$data['Booking_id'])->update(['Status'=>$data['Status']]);
            return redirect()->back()->with('flash_message_success', 'Booking Status has been updated successfully!');
        }
    }

    public function exportServices(){
        return Excel::download(new servicesExport,'services.xlsx');
    }

    public function viewBookingsChart(){

        $current_month_booking =Booking::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->month)->count();
        $last_month_booking =Booking::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->subMonth(1))->count();
        $last_to_last_month_booking =Booking::whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', Carbon::now()->subMonth(2))->count();
        return view('admin.service.view_booking_chart')->with(compact('current_month_booking','last_month_booking','last_to_last_month_booking'));
    }


}
