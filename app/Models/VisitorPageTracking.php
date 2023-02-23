<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorPageTracking extends Model
{
    use HasFactory;

    protected $table = "visitor_page_tracking";
    protected $fillable = [
        "page_url",
        "user_agent",
        "browser",
        "browser_version",
        "platform",
        "country",
        "country_code",
        "continent",
        "continent_code",
        "ip_address"
    ];

}
