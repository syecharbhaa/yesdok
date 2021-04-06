<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function list(Request $r){
        $products = Product::all();

        if($r->user()->role->name == 'Staff'){
            $products = Product::where('status', 'approved')->get();
        }

        $res['status'] = 'success';
        $res['data'] = ['products' => $products];

        return response($res, 200);
    }

    public function input(Request $r){
        $name = $r->input('name');
        $price = $r->input('price');

        if(!isset($name)){
            $res['status'] = 'fail';
            $res['data'] = ['name' => 'Name is required'];
            $code = 403;
        }

        if(!isset($price)){
            $res['status'] = 'fail';
            $res['data'] = ['price' => 'Price is required'];
            $code = 403;
        }

        if($name && $price){
            $product = new Product();
            $product->name = $name;
            $product->price = $price;
            $product->save();

            $res['status'] = 'success';
            $res['data'] = ['product' => $product];
            $code = 201;
        }

        return response($res, $code);
    }

    public function detail($id = null){
        $product = Product::where('id', $id)->first();

        $res['status'] = 'success';
        $res['data'] = ['product' => $product];

        return response($res, 200);
    }

    public function review(Request $r, $id){
        $status = $r->input('status');
        $reason = $r->input('status_description');

        if(!isset($status)){
            $res['status'] = 'fail';
            $res['data'] = ['status' => 'Status is required (approved/rejected)'];
            $code = 403;
        }
        else{
            $product = Product::where('id', $id)->first();
            $product->update(['status' => $status, 'status_description' => $reason]);

            $res['status'] = 'success';
            $res['data'] = ['product' => $product];
            $code = 201;
        }

        return response($res, $code);
    }

    public function resubmit(Request $r, $id){
        $name = $r->input('name');
        $price = $r->input('price');

        if(!isset($name)){
            $res['status'] = 'fail';
            $res['data'] = ['name' => 'Name is required'];
            $code = 403;
        }

        if(!isset($price)){
            $res['status'] = 'fail';
            $res['data'] = ['price' => 'Price is required'];
            $code = 403;
        }

        $product = Product::where('id', $id)->first();

        if($product->status == 'approved'){
            $res['status'] = 'fail';
            $res['data'] = ['status' => 'Product has been approved'];
            $code = 403;
        }

        if($name && $price && $product->status != 'approved'){
            $product->update(['name' => $name, 'price' => $price]);

            $res['status'] = 'success';
            $res['data'] = ['product' => $product];
            $code = 201;
        }

        return response($res, $code);
    }
}
