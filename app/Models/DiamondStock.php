<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiamondStock extends Model
{
    use HasFactory;

    public $timestamps = false;
    //BaseModelOne.php
    protected $connection = 'mysqlOne';

    protected $table = "asbivgyrdiamondstock";

}
