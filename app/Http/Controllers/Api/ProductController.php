<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\categories;
use App\Models\Image;
use App\Models\Product;
use App\Models\products;
use App\Models\Review;
use App\Models\reviews;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   function get_product(){

       $browser_total_raw = Review::raw('count(*) as total');
       $browser_total_raws = Review::raw('Round(avg(stars),1) as avgstars');
       $tops=Review::select('product_id',$browser_total_raw)->where('stars',5)->groupBy('product_id')->orderBy('total','DESC')->get();//->take(6)

       $product_id=[];
       $i=0;
       foreach ($tops as $pros_id){
           $product_id[$i]=$pros_id->product_id;
           $i++;
       }
       $stars=Review::select('product_id',$browser_total_raws)->whereIn('product_id',$product_id)->groupBy('product_id')->orderBy('avgstars','DESC');
       $top_product=Product::select('id','product_name','products.description','products.category_id','products.brand_id','avgstars')
           ->joinsub($stars,'stars',function ($join){
               $join->on('products.id','=','stars.product_id');
           });
       $product=Image::select('img.id','product_name','avgstars','description','category_id','brand_id','path')->joinsub($top_product,'prod',function ($join){
           $join->on('img.id','=','prod.id');
       })->get();

       return $product;
   }

   function get_top_product(Request $request){
       $browser_total_raw = Review::raw('count(*) as total');
       $browser_total_raws = Review::raw('Round(avg(stars),1) as avgstars');
       $tops=Review::select('product_id',$browser_total_raw)->where('stars',5)->groupBy('product_id')->orderBy('total','DESC')->get();//->take(6)

       $product_id=[];
       $i=0;
       foreach ($tops as $pros_id){
           $product_id[$i]=$pros_id->product_id;
           $i++;
       }

       $stars=Review::select('product_id',$browser_total_raws)->whereIn('product_id',$product_id)->groupBy('product_id')->orderBy('avgstars','DESC')->take(6);
       $starsa=Review::select($browser_total_raws)->whereIn('product_id',$product_id)->groupBy('product_id')->orderBy('avgstars','DESC')->take(6)->get();
       $product_ids=[];
       $i=0;
      // $starsss=round($stars->starss,2);
       foreach ($stars as $pros_id){
           $product_ids[$i]=$pros_id->product_id;
           $i++;
       }

       $top_product=Product::select('id','product_name','products.description','products.category_id','products.brand_id','avgstars')
           ->joinsub($stars,'stars',function ($join){
          $join->on('products.id','=','stars.product_id');
       });
       $topsproduct=Image::select('img.id','product_name','avgstars','description','category_id','brand_id','path')->joinsub($top_product,'prod',function ($join){
           $join->on('img.id','=','prod.id');
       })->orderBy('avgstars','DESC')->get();


 return $topsproduct;


   }

   public function stars_review(Request $request){
       $product_id=Product::select('id')->where('product_name',$request->product)->get();
       $browser_total_raw = Review::raw('count(*) as total');
       $present=[];
       $stars=Review::select('stars')->whereIn('product_id',$product_id)->get()->count();

       for($i=1;$i<=4;$i++){
           if($stars==0){
               $present[$i-1]=0;
           }else{
           $stars_1_to_4=Review::select('stars',$browser_total_raw)->whereIn('product_id',$product_id)->whereBetween('stars',[$i,$i+0.5])->groupBy('stars')->get()->sum('total');
           $present_of_stars_1_to_4=round((($stars_1_to_4/$stars)*100),2);
           $present[$i-1]=$present_of_stars_1_to_4;
       }}
       if($stars==0){
           $present[4]=0;
       }else {
           $stars_5 = Review::select('stars', $browser_total_raw)->whereIn('product_id', $product_id)->where('stars', 5)->groupBy('stars')->get()->sum('total');
           $present_of_stars5 = round((($stars_5 / $stars) * 100), 2);
           $present[4] = $present_of_stars5;
       } return $present;

   }

   public function searchs(Request $request){

       $product=Product::select('product_name')->where('product_name','Like','%'.$request->product.'%')->get();
       $browser_total_raw = Review::raw('count(*) as total');
       $browser_total_raws = Review::raw('Round(avg(stars),1) as avgstars');
       $tops=Review::select('product_id',$browser_total_raw)->where('stars',5)->groupBy('product_id')->orderBy('total','DESC')->get();//->take(6)

       $product_id=[];
       $i=0;
       foreach ($tops as $pros_id){
           $product_id[$i]=$pros_id->product_id;
           $i++;
       }
       $stars=Review::select('product_id',$browser_total_raws)->whereIn('product_id',$product_id)->groupBy('product_id')->orderBy('avgstars','DESC');
       $top_product=Product::select('id','product_name','products.description','products.category_id','products.brand_id','avgstars')
           ->joinsub($stars,'stars',function ($join){
               $join->on('products.id','=','stars.product_id');
           });
       $products=Image::select('img.id','product_name','avgstars','description','category_id','brand_id','path')->joinsub($top_product,'prod',function ($join){
           $join->on('img.id','=','prod.id');
       })->whereIN('product_name',$product)->take(8)->get();



       return $products;
   }

}
