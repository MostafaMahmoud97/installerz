<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSocialMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "social_media_id",
        "link"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
