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

class brandsController extends Controller
{
    function get_best_product_of_brands(Request $request){
        $barnds_id=Brand::select('id')->where('brand_name',$request->brand)->value('id');
        // $productss=::select('product_name')->where('category_id',$catogery_id)->get();
        $products_id=Product::select('id')->where('brand_id',$barnds_id)->get();
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
        $best_product_of_review=Product::select()->where('id',$pro_id)->get();

        $pro_ids=[];
        $i=0;
        foreach ($nums as $pros_id){
            $pro_ids[$i]=$pros_id->product_id;
            $i++;
        }
        $best_products_review=Product::select()->whereIn('id',$pro_ids)->get();
        return $best_product_of_review;
    }
    function worest_pro_barands(Request $request){
        $barnds_id=Brand::select('id')->where('brand_name',$request->brand)->value('id');
        // $productss=products::select('product_name')->where('category_id',$catogery_id)->get();
        $products_id=Product::select('id')->where('brand_id',$barnds_id)->get();
        $numofstarsrev=Review::select('product_id')->whereIn('product_id',$products_id)->where('stars',1)->groupBy('product_id')->get();
        $browser_total_raw = Review::raw('count(*) as total');
        $nums=Review::select('product_id',$browser_total_raw)->whereIn('product_id',$products_id)->where('stars',1)->groupBy('product_id')->orderBy('total','DESC')->get();
        $max=Review::select('product_id',$browser_total_raw)->whereIn('product_id',$products_id)->where('stars',1)->groupBy('product_id')->get()->max('total');
        $pro_id=0;
        foreach ($nums as $maxs){
            if($maxs->total==$max){
                $pro_id=$maxs->product_id;
                break;
            }
        }
        $worest_product_of_review=Product::select()->where('product_id',$pro_id)->get();
        return $worest_product_of_review;
}

    public function get_cat_from_brand(Request $request){
        $brand_id=Brand::select('id')->where('brand_name',$request->brand)->value('id');
        $catgorys_id=CategoryBrand::select('brand_id')->where('catogry_id',$brand_id)->get();
        $catogerys=Category::select('category_name')->whereIn('id',$catgorys_id)->get();
        return $catogerys;
    }

}
