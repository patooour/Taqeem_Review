<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryBrand;
use App\Models\Image;
use App\Models\Product;
use App\Models\Review;
use App\Models\reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function getMainCategory(Request $request)
    {

        $categories = Category::all();

        $reviews = Review::all();
        $rands = $reviews->random(6);


        $browser_total_raw = Review::raw('count(*) as total');
        $tops = Review::select('product_id', $browser_total_raw)->where('stars', 5)->groupBy('product_id')->orderBy('total', 'DESC')->take(6)->get();
        $browser_total_raw = Review::raw('count(*) as total');
        $browser_total_raws = Review::raw('Round(avg(stars),1) as avgstars');
        $tops=Review::select('product_id',$browser_total_raw)->where('stars',5)->groupBy('product_id')->orderBy('total','DESC')->get();//->take(6)

        $product_id=[];
        $i=0;
        foreach ($tops as $pros_id){
            $product_id[$i]=$pros_id->product_id;
            $i++;
        }

        $stars=Review::select('product_id',$browser_total_raws)->whereIn('product_id',$product_id)->groupBy('product_id')->orderBy('avgstars','DESC')->take(6)->get();
        $starsa=Review::select($browser_total_raws)->whereIn('product_id',$product_id)->groupBy('product_id')->orderBy('avgstars','DESC')->take(6)->get();
        $product_ids=[];
        $i=0;
        // $starsss=round($stars->starss,2);
        foreach ($stars as $pros_id){
            $product_ids[$i]=$pros_id->product_id;
            $i++;
        }
        $TopProducts = Product::find($product_ids);








        return view('mainCategory',
           ['categories'=>$categories , 'reviews'=>$reviews ,'rands'=>$rands ,'TopProducts' => $TopProducts ]);
    }

    public function getBrands($id){
        $category = Category::find($id);
        $catId = $category->id;

        $products = Product::where('category_id','=',$catId)->skip(0)->take(6)->get();
        $productIds = Product::select('image_id')->where('category_id','=',$catId)->skip(0)->take(6)->get();
        $imgs = Image::select('path')->find($productIds);

       if ($category == null) {
            return redirect()->back();
        }
         $CatBrand = CategoryBrand::select('brand_id')->where('catogry_id' ,'=', $id)->get();
         $brands = Brand::whereIn('id',$CatBrand)->get();
         $brandIds = Brand::select('id')->whereIn('id',$CatBrand)->get();



        $imgPath=[];
        $i=0;
        foreach ($imgs as $img){
            $imgPath[$i] = $img->path;
                $i++;
        }


        return view('brands',
            ['category'=>$category ,
            'brands'=>$brands ,
            'brandIds'=>$brandIds,
            'products'=>$products,
            'imgPath'=>$imgPath,

            ]);
    }

    public function search(Request $request){
        if($request->ajax()){
            $data=Product::select('product_name','id')->where('product_name','Like','%'.$request->search.'%')
                ->skip(0)->take(3)->get();

            $output='';
            if(count($data)>0&&$request->search!=''){

                $output ='
                <table class="table" style=" margin-left: 100px;
                                             background-color: white;
                                            width: 66%;
                                            border-radius: 10px;
                                            overflow: hidden;" >

            <tbody>';

                foreach($data as $row){



                    $output .='
                    <tr>
                    <th  style="padding-bottom: 15px;" scope="row"><a style="       text-decoration: none;
                                                                                    color: #ff0000ab;"
                    href="/product/review/'.$row->id.'">
                    '.$row->product_name.'
                    </a>
                    </th>

                    </tr>
                    ';
                }



                $output .= '
             </tbody>
            </table>';
            }elseif ($request->search==''){
                $output='';
            }
            else{
                $output='';
            }
            return $output;

        }
    }
    public function gatpro(){
        $pro=Product::select()->get();
        return $pro;
    }
}
