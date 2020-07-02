<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   

        return view('home');
    }

    public function admin(Request $request){
        
        $user = User::where('id' ,'!=', '3')->get();
        if(Request()->ajax()){
            return datatables()->of($user)
                        ->addColumn('action', function($user){
                            $button = '<button type="button" name="access" id="'.$user->id.'" class="access-btn btn btn-primary btn-sm">ENTER</button>';
                            return $button;
                        })
                        ->rawColumns(['action'])
                        ->editColumn('created_at', function ($user)
                     {
                         return date('Y-m-d', strtotime($user->created_at));
                     })
                        ->make(true);
        }
        return view('admin.index');
    }

    public function adminView(Request $request){
        $id = $request->id;
        $user = Auth::user();
        $user->assignRole('branch');
        $user->key = $id;
        $user->save();
        return response()->json(['sucess' => 'good']);
    }

    public function adminBack(){
        $user = Auth::user();
        $user->removeRole('branch');
        $user->key = null;
        $user->save();
        return view('admin.index');
    }

    public function newBranch(Request $request){

        $rules = array(
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        );
        $error  = Validator::make($request->all(), $rules);
        if($error->fails())
    {
        return response()->json(['errors' => $error->errors()->all()]);
    }

    $form_data = array(
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    );
        $user = User::create($form_data);
        $user->assignRole('branch');
    return response()->json(['success' => 'Product Added successfully.']);

    }

}
