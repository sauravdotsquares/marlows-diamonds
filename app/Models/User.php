<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name','email','username', 'password','nicename','user_role','description','is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected $appends = ['customer_details'];

    // public function getCustomerDetailsAttribute(Type $var = null)
    // {
    //     # code...
    // }

    public function getCustomerAddressFunction()
    {
        return $this->hasOne(CustomerAddress::class);
    }
    public function getCustomerShippingAddressFunction()
    {
        return $this->hasOne(CustomerShippingAddress::class);
    }
}
