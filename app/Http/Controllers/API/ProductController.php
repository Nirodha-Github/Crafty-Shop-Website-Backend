<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use File;

class ProductController extends Controller
{

    public function index()
    {
        $product = Product::all();
        return response()->json([
            'status'=>200,
            'product'=>$product,
           
        ]);
    }

    public function popular()
    {
        $product = Product::where('popular', 1)->get();
        return response()->json([
            'status'=>200,
            'product'=>$product,
           
        ]);
    }

    public function edit($id)
    {
      $product = Product::find($id);

      if($product){
          return response()->json([
              'status'=>200,
              'product' =>$product,
          ]);
      }
      else{
        return response()->json([
            'status'=>404,
            'message' =>'Product Id Not Found',
        ]);     
      }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category_id'=>'required',
            'slug'=>'required|max:191',
            'name'=>'required|max:191',
            'selling_price'=>'required|max:20',
            'original_price'=>'required|max:20',
            'qty'=>'required|max:4',
            'pimage'=>'required|image|mimes:jpeg,png,jpg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $product = new Product();
            $product -> category_id = $request->input('category_id');
            $product -> slug = $request->input('slug');
            $product -> name = $request->input('name');
            $product -> description = $request->input('description');
            $product -> meta_title = $request->input('meta_title');
            $product -> meta_keyword = $request->input('meta_keyword');
            $product -> meta_description = $request->input('meta_description');
            $product -> selling_price = $request->input('selling_price');
            $product -> original_price = $request->input('original_price');
            $product -> qty = $request->input('qty');
            

            if($request -> hasFile('pimage')){
                $file = $request->file('pimage');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('uploads/products/',$filename);
                $product -> pimage = 'uploads/products/'.$filename;
            }

            $product -> featured = $request->input('featured') === true ? '1':'0';
            $product -> popular = $request->input('popular') === true ? '1':'0';
            $product -> status = $request->input('status') === true ? '1':'0';
            $product->save();

            return response()->json([
                'status'=>200,
                'message'=>'Product Added Successfully',
            ]);
        }
       
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'category_id'=>'required',
            'slug'=>'required|max:191',
            'name'=>'required|max:191',
            'selling_price'=>'required|max:20',
            'original_price'=>'required|max:20',
            'qty'=>'required|max:4',

        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $product = Product::find($id);

            if($product){
                $product -> category_id = $request->input('category_id');
                $product -> slug = $request->input('slug');
                $product -> name = $request->input('name');
                $product -> description = $request->input('description');
                $product -> meta_title = $request->input('meta_title');
                $product -> meta_keyword = $request->input('meta_keyword');
                $product -> meta_description = $request->input('meta_description');
                $product -> selling_price = $request->input('selling_price');
                $product -> original_price = $request->input('original_price');
                $product -> qty = $request->input('qty');
                

                if($request -> hasFile('pimage')){
                    $path = $product->pimage;

                    if(File::exists($path)){
                        File::delete();
                    }

                    $file = $request->file('pimage');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extension;
                    $file->move('uploads/products/',$filename);
                    $product -> pimage = 'uploads/products/'.$filename;
                }

                $product -> featured = $request->input('featured');
                $product -> popular = $request->input('popular');
                $product -> status = $request->input('status');
                $product->update();

                return response()->json([
                    'status'=>200,
                    'message'=>'Product Updated Successfully',
                ]);
            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Product Not Found',
                ]);
            }
    }
        
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if($product){
            $product -> delete();
             return response()->json([
                 'status'=>200,
                 'message'=>'Product Deleted Successfully',
             ]);
        }
        else{
             return response()->json([
                 'status'=>404,
                 'message'=>'Product Not Found',
             ]);
     }
    }
}
