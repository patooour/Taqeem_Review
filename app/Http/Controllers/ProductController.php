<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function getProduct($id){

        $products = Product::where(	'brand_id' , '=' ,$id)->get();

        $brand = Brand::select('brand_name')->find($id);
        if ($brand == null) {
            return redirect()->back();
        }


        return view('products' , ['brand'=>$brand, 'products'=>$products]);

    }

    public function getProductReview($id){

        $product = Product::find($id);
        if ($product == null) {
            return redirect()->back();
        }

        $id = $product->image_id;
        $img = \App\Models\Image::find($id);
        $reviews = Review::where('product_id',$id)->orderBy('review_id','DESC')->get();

        $product_id= Product::select('id')->where('product_name',$product->product_name)->value('id');


        $browser_total_raw = Review::raw('count(*) as total');
        $present=[];
        $stars= Review::select('stars')->where('product_id',$product_id)->get()->count();

        for($i=1;$i<=4;$i++){
            if($stars==0){
                $present[$i-1]=0;
            }else{
                $stars_1_to_4=Review::select('stars',$browser_total_raw)
                    ->where('product_id',$product_id)->whereBetween('stars',[$i,$i+0.5])
                    ->groupBy('stars')->get()->sum('total');
                $present_of_stars_1_to_4=round((($stars_1_to_4/$stars)*100),2);
                $present[$i-1]=$present_of_stars_1_to_4;
            }}
        if($stars==0){
            $present[4]=0;
        }else {
            $stars_5 = Review::select('stars', $browser_total_raw)
                ->where('product_id', $product_id)->where('stars', 5)->
                groupBy('stars')->get()->sum('total');
            $present_of_stars5 = round((($stars_5 / $stars) * 100), 2);
            $present[4] = $present_of_stars5;
        }




        return view('review' , ['product'=>$product , 'img'=>$img , 'reviews'=>$reviews , 'present'=>$present]);
    }
    public function addReview(Request $request){



        $rules = [
            'Review' => 'required',
            'star' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator->errors()->all());
        }



        $newReview = new Review();
        $newReview->Review = $request->get('Review');
        $newReview->stars = $request->get('star');
        $newReview->product_id = $request->get('id');
        $newReview->Date = now();
        $newReview->save();




        return redirect()->back()
            ->with(['success'=>'Review add success']);
        }







}
