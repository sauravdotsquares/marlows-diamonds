<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveCategoryUrl extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'activecategoryurls';

    use HasFactory;

	protected $fillable = ['name','url','category_id','status'];
}
