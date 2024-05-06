<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "title"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function media(){
        return $this->morphOne(Media::class,"mediable");
    }
}
