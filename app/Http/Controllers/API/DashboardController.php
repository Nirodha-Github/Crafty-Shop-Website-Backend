<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Feedback;
use App\Models\Video;
use App\Models\Article;

class DashboardController extends Controller
{
    public function summary()
    {
        $users = User::all()->count();
        $product = Product::all()->count();
        $category = Category::all()->count();
        $feedback = Feedback::all()->count();
        $video = Video::all()->count();
        $article = Article::all()->count();

        if($users|$product|$category|$feedback|$video|$article){

                return response()->json([
                    'status'=>200,      
                    'product'=>$product,
                    'category'=>$category,
                    'users'=>$users,
                    'feedback'=>$feedback,
                    'video'=>$video,
                    'article'=>$article
                    
                ]);
            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Data Not Found',
                ]);
            }
    }
}
