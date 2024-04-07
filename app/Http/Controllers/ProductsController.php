<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ProductsController extends Controller
{
    function index(){
        $current_products = Storage::disk('local')->get('products.josn');
        $products = json_encode([]);
        if($current_products){
            $products = $current_products;
        }
        $products = json_decode($products);
        return view('ct_view', compact('products'));
    }

    function save(Request $request){

        $current_products = Storage::disk('local')->get('products.josn');
        $new_products = [];
        if($current_products){
            $products = json_decode($current_products);
            foreach ($products as $key => $product) {
                $new_products[$key] = $product;
            }
        }
        
        if($request->has('product_id') && $request->product_id != ''){
            $jsonData = array(
                'product_name' => $request->product_name,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'created_at' => Carbon::parse($new_products[$request->product_id]->created_at)->format('Y-m-d h:i:s')
            );
            $new_products[$request->product_id] = $jsonData;
        }else{
            $jsonData = array(
                'product_name' => $request->product_name,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'created_at' => Carbon::now()->format('Y-m-d h:i:s')
            );
            $new_products[Carbon::now()->timestamp] = $jsonData;
        }
        Storage::disk('local')->put('products.josn', json_encode($new_products));
        return Storage::disk('local')->get('products.josn');
    }
}
