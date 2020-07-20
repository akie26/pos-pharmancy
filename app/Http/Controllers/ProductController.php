<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Auth;
use Validator;
use DB;
use App\Http\Resources\ProductResources;

class ProductController extends Controller
{
    public function index(Request $request)
    {   
        if(request()->wantsJson()){
            if(Auth::user()->key != null){
                $id = Auth::user()->key;
            }else{
                $id = Auth::user()->id;
            }
            $user = User::find($id);
            $products = $user->products;
            return ProductResources::collection($products);
        }

        return view('products.index');
    }

    public function productlist(Request $request){

        
      if(request()->ajax()){
            if(Auth::user()->key != null){
                $id = Auth::user()->key;
            }else{
                $id = Auth::user()->id;
            }

        $user = User::find($id);
        $product = $user->products;
        return datatables()->of($product)
        ->addColumn('action', function($product){
            $button = '<button type="button" data-target=".bd-example-modal-lg-edit" data-toggle="modal" name="edit" id="'.$product->id.'" class="edit-btn btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>';
            $button .= '&nbsp;<button type="button" name="delete" id="'.$product->id.'" 
            class="delete-btn btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
            return $button;
        })
        ->rawColumns(['action'])
        ->make(true);

      }
    }

    public function editprod(Request $request){
        if(request()->ajax()){
            $id = $request->id;
            $data = Product::findOrFail($id);
        }

        echo json_encode($data);
    }

    public function storeprod(Request $request){

        if(Auth::user()->key != null){
            $userId = Auth::user()->key;
        }else{
            $userId = Auth::user()->id;
        }

        if(request()->ajax()){
            $rules = array(
                'item_name' => 'required|string|max:255',
                'brand' => 'required|string|max:255',
                'size' => 'required|string|max:255',
                'detail' => 'string|max:255',
                'selling_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'original_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'quantity' => 'required|integer',
                'barcode' => 'required|integer',
    
            );
            $error  = Validator::make($request->all(), $rules);
            if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
                $form_data = array(
                    'item_name' => $request->item_name,
                    'brand' => $request->brand,
                    'size' => $request->size,
                    'detail' => $request->detail,
                    'barcode' => $request->barcode,
                    'original_price' => $request->original_price,
                    'selling_price' => $request->selling_price,
                    'quantity' => $request->quantity,
                    'user_id' => $userId,
                );
                Product::create($form_data);
                return response()->json(['success' => 'Product Added successfully.']);



        }
    }


    public function updateprod(Request $request, Product $product){

        $rules = array(
            'item_name' => 'required|string|max:255',
                'brand' => 'required|string|max:255',
                'size' => 'required|string|max:255',
                'selling_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'original_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'quantity' => 'required|integer',
                'barcode' => 'required|integer',

        );
        $error  = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
                'item_name' => $request->item_name,
                'brand' => $request->brand,
                'size' => $request->size,
                'detail' => $request->detail,
                'barcode' => $request->barcode,
                'original_price' => $request->original_price,
                'selling_price' => $request->selling_price,
                'quantity' => $request->quantity,
        );
        Product::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'updated']);

            
    }

    public function destroyprod($id){
        $data = Product::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'Product Deleted successfully.']);
    }
   
}
