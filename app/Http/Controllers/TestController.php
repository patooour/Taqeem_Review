<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class TestController extends Controller
{


    public function search(Request $request){
        if($request->ajax()){
            $data=Product::select('product_name')->where('product_name','Like','%'.$request->search.'%')->get();
            $output='';
            if(count($data)>0&&$request->search!=''){
                $output ='
            <table class="table">

            <tbody>';

                foreach($data as $row){
                    $output .='
                    <tr>
                    <th scope="row">'.$row->product_name.'</th>
                        <td>uu</td>
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
                $output='no result';
            }
            return $output;

        }
    }
}
