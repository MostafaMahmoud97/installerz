<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutMePage extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "first_title",
        "second_title",
        "description"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function media_cover(){
        return $this->morphOne(Media::class,"mediable");
    }

    public function InfoAboutMe(){
        return $this->hasMany(InfoAboutMePage::class,"about_me_id","id");
    }
}
