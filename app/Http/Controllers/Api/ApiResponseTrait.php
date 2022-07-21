<?php

namespace App\Http\Controllers\Api;

use http\Env\Request;
use Illuminate\Support\Facades\Validator;

trait ApiResponseTrait
{
public function apiresponse($data=null,$message=null,$status=null){
   $array=[
       'data'=>$data,
       'message'=>$message,
       'status'=>$status,
   ];
   return response($array,200);
}
public function validates(Request $request){
   $valid= Validator::make($request->all(),[
        'user_id'=>'required',
        'title'=>'required|max:250',
        'body'=>'required',
    ]);
   return $valid;
}

}
