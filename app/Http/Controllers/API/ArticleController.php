<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Article;
use File;

class ArticleController extends Controller
{
    public function index()
    {
        $article = Article::all();
        return response()->json([
            'status'=>200,
            'article'=>$article,
           
        ]);
    }

    public function recent()
    {
        $article = Article::orderBy('created_at','desc')->limit(3)->get();
        return response()->json([
            'status'=>200,
            'article'=>$article,
           
        ]);
    }


    public function edit($id)
    {
      $article = Article::find($id);

      if($article){
          return response()->json([
              'status'=>200,
              'article' =>$article,
          ]);
      }
      else{
        return response()->json([
            'status'=>404,
            'message' =>'Article Id Not Found',
        ]);     
      }
    }

    public function single($id)
    {
      $article = Article::find($id);

      if($article){
          return response()->json([
              'status'=>200,
              'article' =>$article,
          ]);
      }
      else{
        return response()->json([
            'status'=>404,
            'message' =>'Article Id Not Found',
        ]);     
      }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'slug'=>'required|max:191',
            'title'=>'required|max:191',
            'article_body'=>'required', 
            'meta_keyword'=>'required', 
            'coverimage'=>'required|image|mimes:jpeg,png,jpg|max:50000',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $article = new Article();
            $article -> slug = $request->input('slug');
            $article -> title = $request->input('title');
            $article -> article_body = $request->input('article_body');
            $article -> description = $request->input('description');
            $article -> meta_title = $request->input('meta_title');
            $article -> meta_keyword = $request->input('meta_keyword');
            $article -> meta_description = $request->input('meta_description');            

            if($request -> hasFile('coverimage')){
                $file = $request->file('coverimage');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('uploads/articles/',$filename);
                $article -> coverimage = 'uploads/articles/'.$filename;
            }

            $article -> status = $request->input('status') === true ? '1':'0';
            $article->save();

            return response()->json([
                'status'=>200,
                'message'=>'Article Added Successfully',
            ]);
        }
       
    }
        public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'slug'=>'required|max:191',
            'title'=>'required|max:191',
            'article_body'=>'required', 
            'meta_keyword'=>'required', 
            

        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $article = Article::find($id);

            if($article){
                $article -> slug = $request->input('slug');
                $article -> title = $request->input('title');
                $article -> article_body = $request->input('article_body');
                $article -> description = $request->input('description');
                $article -> meta_title = $request->input('meta_title');
                $article -> meta_keyword = $request->input('meta_keyword');
                $article -> meta_description = $request->input('meta_description');            
    
                if($request -> hasFile('coverimage')){
                    $file = $request->file('coverimage');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extension;
                    $file->move('uploads/articles/',$filename);
                    $article -> coverimage = 'uploads/articles/'.$filename;
                }
                

                if($request -> hasFile('coverimage')){
                    $path = $article->coverimage;

                    if(File::exists($path)){
                        File::delete();
                    }

                    $file = $request->file('coverimage');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extension;
                    $file->move('uploads/articles/',$filename);
                    $article -> coverimage = 'uploads/articles/'.$filename;
                }
 
                $article -> status = $request->input('status') === true ? '1':'0';

                $article->update();

                return response()->json([
                    'status'=>200,
                    'message'=>'Article Updated Successfully',
                ]);
            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Article Not Found',
                ]);
            }
    }
}

    public function destroy($id)
    {
        $article = Article::find($id);
        if($article){
            $article -> delete();
            return response()->json([
                'status'=>200,
                'message'=>'Article Deleted Successfully',
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Article Not Found',
            ]);
    }
    }
}
