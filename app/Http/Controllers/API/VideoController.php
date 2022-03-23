<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Video;
use File;

class VideoController extends Controller
{

    public function index()
    {
        $video = Video::all();
        return response()->json([
            'status'=>200,
            'video'=>$video,
           
        ]);
    }

    public function recent()
    {
        $video = Video::orderBy('created_at','desc')->limit(4)->get();
        return response()->json([
            'status'=>200,
            'video'=>$video,
           
        ]);
    }

    public function edit($id)
    {
      $video = Video::find($id);

      if($video){
          return response()->json([
              'status'=>200,
              'video' =>$video,
          ]);
      }
      else{
        return response()->json([
            'status'=>404,
            'message' =>'Video Id Not Found',
        ]);     
      }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'slug'=>'required|max:191',
            'title'=>'required|max:191',
            'video_link'=>'required|url', 
            'meta_keyword'=>'required', 
            'coverimage'=>'required|image|mimes:jpeg,png,jpg',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $video = new Video();
            $video -> slug = $request->input('slug');
            $video -> title = $request->input('title');
            $video -> video_link = $request->input('video_link');
            $video -> description = $request->input('description');
            $video -> meta_title = $request->input('meta_title');
            $video -> meta_keyword = $request->input('meta_keyword');
            $video -> meta_description = $request->input('meta_description');            

            if($request -> hasFile('coverimage')){
                $file = $request->file('coverimage');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move('uploads/videos/',$filename);
                $video -> coverimage = 'uploads/videos/'.$filename;
            }

            $video -> status = $request->input('status') === true ? '1':'0';
            $video->save();

            return response()->json([
                'status'=>200,
                'message'=>'Video Added Successfully',
            ]);
        }
       
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'slug'=>'required|max:191',
            'title'=>'required|max:191',
            'video_link'=>'required|url', 
            'meta_keyword'=>'required', 
            

        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $video = Video::find($id);

            if($video){
                $video -> slug = $request->input('slug');
                $video -> title = $request->input('title');
                $video -> video_link = $request->input('video_link');
                $video -> description = $request->input('description');
                $video -> meta_title = $request->input('meta_title');
                $video -> meta_keyword = $request->input('meta_keyword');
                $video -> meta_description = $request->input('meta_description');            
    
                if($request -> hasFile('coverimage')){
                    $file = $request->file('coverimage');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extension;
                    $file->move('uploads/videos/',$filename);
                    $video -> coverimage = 'uploads/videos/'.$filename;
                }
                

                if($request -> hasFile('coverimage')){
                    $path = $video->coverimage;

                    if(File::exists($path)){
                        File::delete();
                    }

                    $file = $request->file('coverimage');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extension;
                    $file->move('uploads/videos/',$filename);
                    $video -> coverimage = 'uploads/videos/'.$filename;
                }

                $video -> status = $request->input('status') === true ? '1':'0';

                $video->update();

                return response()->json([
                    'status'=>200,
                    'message'=>'Video Updated Successfully',
                ]);
            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Video Not Found',
                ]);
            }
    }
}

    public function destroy($id)
    {
        $video = Video::find($id);
        if($video){
            $video -> delete();
            return response()->json([
                'status'=>200,
                'message'=>'Video Deleted Successfully',
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'Video Not Found',
            ]);
    }
    }
}
