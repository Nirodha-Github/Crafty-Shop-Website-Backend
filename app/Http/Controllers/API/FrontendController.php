<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Feedback;
use File;

class FrontendController extends Controller
{
    public function category()
    {
        $category = Category::where('status','0')->get();
        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);
    }

    public function product($slug)
    {
        $category = Category::where('slug',$slug)->where('status','0')->first();
        if($category){
            $product = Product::where('category_id',$category->id)->where('status','0')->get();
            if($product){
                return response()->json([
                    'status'=>200,
                    'product_data'=>[
                        'product'=>$product,
                        'category'=>$category
                    ],
                ]); 

            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'No Product Available',
                ]); 
            }
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Category Found',
            ]); 
        }
    }

    public function user($id)
    {
        $user = User::find($id);
        if($user){
            return response()->json([
                'status'=>200,
                'user' =>$user,
            ]);
        }
        else{
          return response()->json([
              'status'=>404,
              'message' =>'User Not Found',
          ]);     
        }
    }

    
    public function userupdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'firstname'=>'required|max:191',
            'lastname'=>'required|max:191',
            'email'=>'required|email|max:191',
            'phoneno'=>'required|max:10',
            'address'=>'required|max:191',
             'uimage'=>'image|mimes:jpeg,png,jpg|max:10000',

        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $user = User::find($id);

            if($user){
                $user  -> firstname = $request->input('firstname');
                $user  -> lastname = $request->input('lastname');
                $user  -> email = $request->input('email');
                $user  -> phoneno = $request->input('phoneno');
                $user  -> address = $request->input('address');
                

                if($request -> hasFile('uimage')){
                    $path = $user->uimage;
 
                    if(File::exists($path)){
                        File::delete($path);
                    }


                    $file = $request->file('uimage');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extension;
                    //$file->move('uploads/users/',$filename);    
                    $request ->file('uimage')->storeAs('uploads/users/',$filename,'public');          
                    $user -> uimage = 'uploads/users/'.$filename;
                    
                
                    
                }
               

                $user -> update();

                return response()->json([
                    'status'=>200,
                    'message'=>'Profile Updated Successfully',


                ]);
            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'You Are Not Registered.Please Sign Up!',
                ]);
            }
    }


}

    public function viewproduct($category_slug,$product_slug)
    {
        $category = Category::where('slug',$category_slug)->where('status','0')->first();

        if($category){
            $product = Product::where('category_id',$category->id)
                                ->where('slug',$product_slug)
                                ->where('status','0')
                                ->first();

            if($product){
                return response()->json([
                    'status'=>200,
                    'product'=>$product,
                   
                ]); 

            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'No Product Available',
                ]); 
            }
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Category Found',
            ]); 
        }
    }

    public function feedback(Request $request)
    {
         $validator = Validator::make($request -> all(), [
             'name'=>'required|max:191',
             'title'=>'required|max:191',
             'email'=>'required|max:191|email',
             'description'=>'required'

         ]); 
 
         if($validator->fails()){
             return response()->json([
                 'status'=>422,
                 'errors'=>$validator ->messages(),
             ]);
         }
         else{
             $feedback = new Feedback;
             $feedback-> name = $request -> input('name');
             $feedback-> email = $request -> input('email');
             $feedback-> phonenumber = $request -> input('phonenumber');
             $feedback-> title = $request -> input('title');
             $feedback-> description = $request -> input('description');
             $feedback -> save();

             return response()->json([
                 'status'=>200,
                 'message'=>'Feedback Sent Successfully',
             ]);
         }
        
    }

    public function viewfeedback()
    {
        $feedback = Feedback::all();

        if($feedback){
            return response()->json([
                'status'=>200,
                'feedback' =>$feedback,
            ]);
        }
        else{
          return response()->json([
              'status'=>404,
              'message' =>'Feedback Not Found',
          ]);     
        }
    }

}