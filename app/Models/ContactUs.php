<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "first_name",
        "last_name",
        "description",
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
