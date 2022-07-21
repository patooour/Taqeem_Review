<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\brands;
use App\Models\cat_barnd;
use App\Models\categories;
use App\Models\Category;
use App\Models\CategoryBrand;
use App\Models\Product;
use App\Models\products;
use App\Models\Review;
use App\Models\reviews;
use Illuminate\Http\Request;

class CatogeryController extends Controller
{
   function get_top_product(Request $request){
$catogery_id=Category::select('id')->where('category_name',$request->catogery)->value('id');
$productss=Product::select('product_name')->where('category_id',$catogery_id)->get();
$products_id=Product::select('id')->where('category_id',$catogery_id)->get();
$numofstarsrev=Review::select('stars')->whereIn('product_id',$products_id)->where('stars',5)->count();


$top_reviews=Review::select('product_id')->whereIn('product_id',$products_id)->where('stars',5)->orderby('stars','DESC')->get();
$cat_pro=Product::select('product_name')->whereIn('id',$top_reviews)->get();
  return $cat_pro;
   }

   function get_best_product_of_catogery(Request $request){
       $catogery_id=Category::select('id')->where('category_name',$request->catogery)->value('id');
      // $productss=products::select('product_name')->where('category_id',$catogery_id)->get();
       $products_id=Product::select('id')->where('category_id',$catogery_id)->get();
       $numofstarsrev=Review::select('product_id')->whereIn('product_id',$products_id)->where('stars',5)->groupBy('product_id')->get();
       $browser_total_raw = Review::raw('count(*) as total');
       $nums=Review::select('product_id',$browser_total_raw)->whereIn('product_id',$products_id)->where('stars',5)->groupBy('product_id')->orderBy('total','DESC')->get();
       $max=Review::select('product_id',$browser_total_raw)->whereIn('product_id',$products_id)->where('stars',5)->groupBy('product_id')->get()->max('total');
       $pro_id=0;
   foreach ($nums as $maxs){
       if($maxs->total==$max){
           $pro_id=$maxs->product_id;
           break;
       }
   }
   $best_product_of_review=Product::select()->where('product_id',$pro_id)->get();

$pro_ids=[];
$i=0;
   foreach ($nums as $pros_id){
       $pro_ids[$i]=$pros_id->product_id;
       $i++;
   }
   $best_products_review=Product::select()->whereIn('product_id',$pro_ids)->get();
     return $best_products_review;
   }


   public function get_brand_from_cat(Request $request){
       $cat_id=Category::select('id')->where('category_name',$request->catogery)->value('id');
       $brands_id=CategoryBrand::select('brand_id')->where('catogry_id',$cat_id)->get();
       $brands=Brand::select('brand_name')->whereIn('id',$brands_id)->get();
       return $brands;
}
}
