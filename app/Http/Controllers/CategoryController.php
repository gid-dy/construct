<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Input;
use Image;
use Session;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.

     *
     * @return \Illuminate\Http\Response
     */
    public function addCategory(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'CategoryName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'CategoryDescription' => 'nullable',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            //echo "<pre>"; print_r($data);die;
            if(empty($data['CategoryStatus'])){
                $CategoryStatus = 0;
            }else{
                $CategoryStatus = 1;
            }
            if(empty($data['meta_title'])){
                $data['meta_title'] = "";
            }
            if(empty($data['meta_description'])){
                $data['meta_description'] = "";
            }
            if(empty($data['meta_keywords'])){
                $data['meta_keywords'] = "";
            }
            $category = new Category;
            $category->CategoryName = $data['CategoryName'];
            $category->CategoryDescription = $data['CategoryDescription'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->CategoryStatus = $CategoryStatus;
            //upload image
            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,999999).'.'.$extension;
                    $large_image_path = 'images/backend_images/categories/large/'.$filename;
                    $medium_image_path = 'images/backend_images/categories/medium/'.$filename;

                    //Resize Images
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(270,180)->save($medium_image_path);

                    //store image name in tours table
                    $category->image =$filename;
                }
            }
            $category->save();
            return redirect('/admin/view-categories')->with('flash_message_success', 'Category added Successfully!');
         }
        // if(Session::has('adminSession')){

        // }else{
        //     return redirect('/admin/login')->with('flash_message_error','Please login to access');
        // }
        return view('admin.categories.add_category');
    }

    public function viewCategories()
    {
        $category = Category::get();
        // $category = json_decode(json_encode($category));

        return view('admin.categories.view_categories')->with(compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function editCategory(Request $request, $id=null)
    {

        if($request->isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'CategoryName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'CategoryDescription' => 'nullable',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if(empty($data['CategoryStatus'])){
                $CategoryStatus = 0;
            }else{
                $CategoryStatus = 1;
            }
            if(empty($data['meta_title'])){
                $data['meta_title'] = "";
            }
            if(empty($data['meta_description'])){
                $data['meta_description'] = "";
            }
            if(empty($data['meta_keywords'])){
                $data['meta_keywords'] = "";
            }

            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,999999).'.'.$extension;
                    $large_image_path = 'images/backend_images/categories/large/'.$filename;
                    $medium_image_path = 'images/backend_images/categories/medium/'.$filename;

                    //Resize Images
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(270,180)->save($medium_image_path);
                }
            }else{
                $filename = $data['current_image'];
            }
            Category::where(['id'=>$id])->update([
                'CategoryName'=>$data['CategoryName'],
                'CategoryDescription'=>$data['CategoryDescription'],
                'meta_title'=>$data['meta_title'],
                'meta_description'=>$data['meta_description'],
                'meta_keywords'=>$data['meta_keywords'],
                'CategoryStatus'=>$CategoryStatus,
                'image'=>$filename
            ]);
            return redirect('/admin/view-categories')->with('flash_message_success','Category updated Successfully!');
        }
        $categoryDetails = Category::where(['id'=>$id])->first();
        return view('admin.categories.edit_category')->with(compact('categoryDetails'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCategory($id = null)
    {
        // if(!empty($id)){
            Category::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success', 'Category deleted Successfully!');
        //}
    }

    public function deleteCategoryImage($id = null)
    {
        $categoryimage = Category::where(['id'=>$id])->first();
        //echo $tourpackageimage->image; die;
        $large_image_path = 'images/backend_images/categories/large/';
        $medium_image_path = 'images/backend_images/categories/medium/';

        //deleting large image if not exist in folder
        if(file_exists($large_image_path.$categoryimage->image)){
            unlink($large_image_path.$categoryimage->image);
        }

         //deleting medium image if not exist in folder
         if(file_exists($medium_image_path.$categoryimage->image)){
            unlink($medium_image_path.$categoryimage->image);
        }

        Category:: where(['id'=>$id])->update(['image'=>'']);
        return redirect()->back()->with('flash_message_success', 'Category Image has been deleted successfully!');
    }

}
