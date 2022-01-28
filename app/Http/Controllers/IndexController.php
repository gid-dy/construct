<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services;
use App\Category;
use App\Banner;

class IndexController extends Controller
{
    public function index()
    {
        //Get all tour packages
        $servicesAll = Services::inRandomOrder()->where('Status',1)->where('featured_service',1)->paginate(6);

        // $servicesAll = json_decode(json_encode($servicesAll));
        //get all categories
        $servicecategory = Category::with('servecategories')->where($id=null)->get();


        $banners = Banner::where('Status', '1')->get();
        

        //Meta tags
        $meta_title = "MS World";
        $meta_description = "Online Construction Equipment Rental";
        $meta_keywords = "MS World, Onilne Equipment Rental";
        return view('index')->with(compact('servicesAll','servicecategory','meta_title','meta_description','meta_keywords','banners'));
    }
    
}
