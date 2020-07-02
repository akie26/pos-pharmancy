<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\User;
use Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {   
        if(Auth::user()->key != null){
            $id = Auth::user()->key;
        }else{
            $id = Auth::user()->id;
        }
        if(request()->wantsJson()){
            $user = User::find($id);
            return response(
                $user->customers()->get()
            );
        }
    }

    public function discount(Request $request)
    {
        if(request()->wantsJson())
        {
            if(Auth::user()->key != null){
                $id = Auth::user()->key;
            }else{
                $id = Auth::user()->id;
            }
            $user = User::find(6);
            return response(
                $user->discounts()->get()
            ); 
        }
    }

}
