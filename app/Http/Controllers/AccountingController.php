<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Income;
use App\Models\incomeDetail;
use App\Models\Discount;
use App\Models\User;
use Auth;
use Validator;

class AccountingController extends Controller
{
    public function expenseIndex(Request $request)
    {
        if(request()->ajax()){
           if(!empty($request->from_date)){
               if(Auth::user()->key != null){
                   $id = Auth::user()->key;
               }else{
                $id = Auth::user()->id;
               }
            $user = User::find($id);
            $data = $user->expenses()->whereBetween('created_at', array($request->from_date, $request->to_date));
           }else{
            if(Auth::user()->key != null){
                $id = Auth::user()->key;
            }else{
             $id = Auth::user()->id;
            }
            $user = User::find($id);
            $data = $user->expenses;
            
           }
           return datatables()->of($data)
                    ->editColumn('created_at', function ($data)
                    {
                        return date('Y-m-d', strtotime($data->created_at));
                    })
                    ->make(true);
        }
        return view('accounting.exp-index');
    }  

    public function incomeIndex(Request $request){
        if(request()->ajax()){
            if(!empty($request->from_date)){
            if(Auth::user()->key != null){
                $id = Auth::user()->key;
            }else{
                $id = Auth::user()->id;
            }
             $user = User::find($id);
             $data = $user->incomes()->whereBetween('created_at', array($request->from_date, $request->to_date));
            }else{
            if(Auth::user()->key != null){
                $id = Auth::user()->key;
            }else{
            $id = Auth::user()->id;
            }
             $user = User::find($id);
             $data = $user->incomes;
             
            }
            return datatables()->of($data)
                     ->editColumn('created_at', function ($data)
                     {
                         return date('Y-m-d', strtotime($data->created_at));
                     })
                     ->addColumn('action', function($data){
                        $button = '<button type="button" data-target=".bd-example-modal-lg" data-toggle="modal" name="show" id="'.$data->id.'" class="edit btn btn-primary btn-sm">DETAILS</button>';
                        return $button;
                     })
                     ->rawColumns(['action'])
                     ->make(true);
         }
       return view('accounting.inc-index');
    }




    public function createExp(Request $request)
    {    
        if(Auth::user()->key != null){
            $userId = Auth::user()->key;
        }else{
            $userId = Auth::user()->id;
        }
        $rules = array(
            'expense_title' => 'required|string|max:255',
            'expense_cost' => 'required|integer',
            'expense_details' => 'required|string|max:255',
            'created_at' => 'required|date',
        );
        $error  = Validator::make($request->all(), $rules);
            if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'expense_title' => $request->expense_title,
            'expense_cost' => $request->expense_cost,
            'expense_details' => $request->expense_details,
            'created_at' => $request->created_at,
            'user_id' => $userId
        );
        Expense::create($form_data);
        return response()->json(['success' => 'Expense Added successfully.']);

    }  
    
    public function cartCheckout(Request $request){
            if(Auth::user()->key != null){
                $id = Auth::user()->key;
            }else{
            $id = Auth::user()->id;
            }
            $user = User::find($id);
            
            $income = Income::create([
                'income_title' => 'Selling Products',
                'income_amount' => $request->amount,
                'user_id' => $id,
            ]);
            $data = $request->discount; 
            if($data == null){
                $data = '0%';
            }else{
                $data = $data * 100 .'%';
            }
            $cart = $request->user()->cart()->get();
            foreach($cart as $item){
                $income->details()->create([
                'unitcost' => $item->selling_price,
                'quantity' => $item->pivot->quantity,
                'discount' => $data,
                'product_name' => $item->item_name,
                'total' => $item->pivot->quantity * $item->selling_price,
                'product_id' => $item->id,
                ]);
                $item->quantity = $item->quantity - $item->pivot->quantity;
                $item->save();
                $request->user()->cart()->detach();
            }
            return response()->json(['success' =>'DONE']);

    }

    public function incomeDetail(Request $request){
        if(request()->ajax()) {
            $id = $request->id;
            $dd = (int)$id;
            $data = incomeDetail::where('income_id', $dd)->get();
        }
        echo json_encode($data);
    }

    public function discount(Request $request){
        if(Auth::user()->key != null){
            $id = Auth::user()->key;
        }else{
         $id = Auth::user()->id;
        }
        $user = User::find($id);
        $data = $user->discounts;
        return view('accounting.disc-index')->with('data', $data);
    }

    public function discountDestroy($id){
        $data = Discount::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'Deleted successfully.']);
    }

    public function discountAdd(Request $request){
        if(Auth::user()->key != null){
            $userId = Auth::user()->key;
        }else{
            $userId = Auth::user()->id;
        }
        if(Request()->ajax()){
            $rules = array(
                'discount_name' => 'required|string|max:255',
                'amount' => 'required|integer',
            );
            $error  = Validator::make($request->all(), $rules);
            if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
            $data = array(
                'discount_name' => $request->discount_name,
                'amount' => $request->amount,
                'user_id' => $userId,
            );
            Discount::create($data);
            return response()->json(['success' => 'CREATED']);

        }

    }

}
