<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use Auth;
use App\Models\User;

class CartController extends Controller
{
    public function index(Request $request){
        
        if($request->wantsJson()){
            return response(
                $request->user()->cart()->get()
            );
        }
        return view('cart.index');

    }

    public function store(Request $request)
    {
        $request->validate([
            'drug_name' => 'required|exists:products,drug_name',
        ]);
        $drug_name = $request->drug_name;
        $cart = $request->user()->cart()->where('drug_name', $drug_name)->first();
        if($cart){
            $cart->pivot->quantity = $cart->pivot->quantity + 1;
            $cart->pivot->save();
        }else{
            $product = Product::where('drug_name', $drug_name)->first();
            $request->user()->cart()->attach($product->id, ['quantity' => 1]);
            return response('', 204);
        }

    }

    public function ChangeQty(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $cart = $request->user()->cart()->where('id', $request->product_id)->first();

        if($cart) {
            $cart->pivot->quantity = $request->quantity;
            $cart->pivot->save();
        }

        return response([
            'success' => true
        ]);
    }

    public function remove(Request $request){
        $request->validate([
            'product_id' => 'required|integer|exists:products,id'
        ]);
        $request->user()->cart()->detach($request->product_id);
        return response('', 204);
    }

    public function destroy(Request $request)
    {
        $request->user()->cart()->detach($request->product_id);
        return response('', 204);
    }

}
