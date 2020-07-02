<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function name(){
        return $this->name;
    }
    
    public function products(){
        return $this->hasMany(Product::class);
    }

    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    public function incomes(){
        return $this->hasMany(Income::class);
    }
    
    public function discounts(){
        return $this->hasMany(Discount::class);
    }

    public function cart(){
        return $this->belongsToMany(Product::class, 'user_cart', 'user_id')->withPivot('quantity');
    }

    public function customers(){
        return $this->hasMany(Customer::class);
    }

    

}
