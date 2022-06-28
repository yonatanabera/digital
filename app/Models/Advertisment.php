<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisment extends Model
{
    use HasFactory;

    protected $table = "advertisments";

    protected $fillable = [
        'company_name',
        'ad_type',
        'priority',
        'photo',
        'caption',
        'web_link',
        'email_link',
        'phone_link',
        'upload_date',
        'down_date',
        'is_active'
    ];

    const IS_INACTIVE = 0;
    const IS_ACTIVE = 1;

    const AD_TYPE_HOMEPAGE = 0;
    const AD_TYPE_LISTING = 1;
}
