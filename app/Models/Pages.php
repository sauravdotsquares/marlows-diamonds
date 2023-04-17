<?php

namespace App\Models;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pages extends Authenticatable
{
    use Notifiable;
    
    protected $fillable = [
        'title','subtitle','slug','deposit','short_description', 'description', 'status', 'template', 'image', 'meta_title', 'meta_description','meta_keyword', 'is_deleted','deleted_at','created_at','updated_at'
    ];
}
