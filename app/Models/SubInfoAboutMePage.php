<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubInfoAboutMePage extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "info_about_me_id",
        "title",
        "description"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
