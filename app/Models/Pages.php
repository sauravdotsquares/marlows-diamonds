<?php

namespace App\Models;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pages extends Authenticatable
{
    use Notifiable;
	// use HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','subtitle','slug','short_description', 'description', 'status', 'template', 'image', 'meta_title', 'meta_description','meta_keyword', 'deleted_at','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
        // 'password', 'remember_token',
    // ];
}
