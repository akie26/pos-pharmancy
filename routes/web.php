<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$admin = User::role('admin')->get();
if($admin){
    Auth::routes([
        'register' => false,
    ]);
}else{
    Auth::routes();
}


Route::get('/', function () {
    if(Auth::check()){
        if(auth()->user()->hasRole('admin')){
            return view('admin.index');
        }else{
            return veiw('home');
        }
    }else{
        return view('auth.login');
    }
});


Route::group(['middleware' => ['auth', 'role:admin' ]], function(){
    Route::GET('/admin', 'HomeController@admin')->name('admin.index');
    Route::GET('/admin-view', 'HomeController@adminView');
    Route::GET('/admin/back', 'HomeController@adminBack')->name('admin.back');
    Route::POST('/admin-branch', 'HomeController@newBranch');
});

Route::group(['middleware' => ['auth', 'role:branch']], function(){
    Route::GET('/home', 'HomeController@index')->name('home');
    Route::GET('/products', 'ProductController@index')->name('products.index');
    Route::GET('/product-list', 'ProductController@productlist');
    Route::GET('/edit-prod', 'ProductController@editprod');
    Route::POST('/update-prod', 'ProductController@updateprod')->name('products.update');
    Route::POST('/add-prod', 'ProductController@storeprod')->name('products.store');
    Route::GET('/destroy-prod/{id}', 'ProductController@destroyprod')->name('products.dest');
    Route::GET('/expense', 'AccountingController@expenseIndex')->name('expense.index');
    Route::GET('/income', 'AccountingController@incomeIndex')->name('income.index');
    Route::POST('/expense-addnew', 'AccountingController@createExp')->name('expense.add-exp');
    Route::GET('/cart', 'CartController@index')->name('cart.index');
    Route::DELETE('/cart/delete', 'CartController@remove');
    Route::DELETE('/cart/empty', 'CartController@destroy');
    Route::POST('/cart', 'CartController@store');
    Route::POST('/cart/change-qty', 'CartController@ChangeQty');
    Route::POST('/cart/checkout', 'AccountingController@cartCheckout');
    Route::GET('/customers', 'CustomerController@index');
    Route::GET('/discount-cart', 'CustomerController@discount');
    Route::GET('/income/detail', 'AccountingController@incomeDetail')->name('income.detail');
    Route::GET('/discounts', 'AccountingController@discount')->name('discounts.index');
    Route::GET('/destroy-discount/{id}', 'AccountingController@discountDestroy');
    Route::POST('/discount/add', 'AccountingController@discountAdd')->name('discount.add');
});


