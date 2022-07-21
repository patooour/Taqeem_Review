<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\products;
use App\Models\Review;
use App\Models\reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ReviewController extends Controller
{
  function get_product_reviews(Request $request){
      $product_id=Product::select('id')->where('product_name',$request->product)->value('id');
      $reviews=Review::select()->where('product_id',$product_id)->where('stars',5)->orderby('stars','DESC')->count();
      return $reviews;
  }
function get_review(Request $request){
      $i=$request->input('stars');
      if($i==0){
          $review =Review::select()->where('product_id',$request->product_id)->orderby('review_id','DESC')->get();

      }elseif ($i==1) {
                  $review = Review::select()->where('product_id', $request->product_id)->whereBetween('stars', [$i, $i+.9])->orderby('review_id', 'DESC')->get();

      }elseif ($i==2){
          $review = Review::select()->where('product_id', $request->product_id)->whereBetween('stars', [$i, $i+.9])->orderby('review_id', 'DESC')->get();
         // return $review;
      }elseif ($i==3){
          $review = Review::select()->where('product_id', $request->product_id)->whereBetween('stars', [$i, $i+.9])->orderby('review_id', 'DESC')->get();

      }elseif ($i==4){
          $review = Review::select()->where('product_id', $request->product_id)->whereBetween('stars', [$i, $i+.9])->orderby('review_id', 'DESC')->get();

      }elseif ($i==5){
          $review = Review::select()->where('product_id', $request->product_id)->where('stars',$i)->orderby('review_id', 'DESC')->get();

      }elseif ($i==6){
       $review=[];
      }
      return $review;
}
function add_review(Request $request){
    $validitor= Validator::make($request->all(),[
        'product_id'=>'required',
        'stars'=>'required',
        'Review'=>'required',
        'Date'=>'required'
    ]);


    if($validitor->fails()){
        return 'failed';

    }  else{

        Review::insert(['product_id'=>$request->input('product_id'),
        'stars'=>$request->input('stars'),
        'Review'=>$request->input('Review'),
        'Date'=>$request->input('Date')
        ]);
        $reviews=Review::select()->where('product_id',$request->input('product_id'))->orderBy('review_id','DESC')->get();
        return $reviews;
    }
}

}
