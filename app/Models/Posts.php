<?php

namespace App\Models;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Posts extends Authenticatable
{
    use Notifiable;
	// use HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'subtitle', 'slug', 'categories', 'faq_title', 'faq_category', 'short_description', 'description', 'status', 'image', 'meta_title', 'meta_description', 'meta_keyword', 'deleted_at', 'created_at','updated_at'
    ];

	protected $appends = ['cat_details','cat_name'];

	public function getCatDetailsAttribute()
    {
        $ids = explode(',',$this->categories);
		// print_r($ids);
		// die;
        $user = PostCategory::whereIn('id',$ids)->pluck('name')->toArray();
        return implode(',',$user);
    }
	public function getCatNameAttribute()
    {
        $ids = explode(',',$this->categories);
        return PostCategory::where('id',$ids[0])->select('name','slug')->first();
    }

}
