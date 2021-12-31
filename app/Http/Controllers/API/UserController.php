<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Cache;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        // $status = [];

        // foreach ($user as $singleUser) {

        //     if (Cache::has('user-is-online-' . $singleUser->Uid))
        //          $status[$singleUser->Uid] = $singleUser->FirstName . " is online. Last seen: " . Carbon::parse($singleUser->LastSeen)->diffForHumans() . " ";
        //     else {
        //         if ($singleUser ->LastSeen != null) {
        //           $status[$singleUser->Uid]  = $singleUser->FirstName . " is offline. Last seen: " . Carbon::parse($singleUser->LastSeen)->diffForHumans() . " ";
        //         } else {
        //           $status[$singleUser->Uid]  = $singleUser->FirstName . " is offline. Last seen: No data ";
        //         }
        //     }
        // }

        return response()->json([
            'status'=>200,
            'user'=>$user,
            //'status' => $status,
        ]);
    } 

}
