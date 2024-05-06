<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageStandOut extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "home_page_id",
        "title",
        "description"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function media_cover(){
        return $this->morphOne(Media::class,"mediable")->where("title","Cover");
    }

    public function media_icon(){
        return $this->morphOne(Media::class,"mediable")->where("title","Icon");
    }
}
