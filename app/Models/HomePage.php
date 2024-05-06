<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "first_title",
        "second_title",
        "third_title",
        "info_title",
        "info_description",
        "benefits_title",
        "benefits_description"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function media_cover(){
        return $this->morphOne(Media::class,"mediable")->where("title","Cover");
    }

    public function media_info_cover(){
        return $this->morphOne(Media::class,"mediable")->where("title","InfoCover");
    }

    public function media_benefits_cover(){
        return $this->morphOne(Media::class,"mediable")->where("title","BenefitsCover");
    }

    public function StandOutSection(){
        return $this->hasMany(HomePageStandOut::class,"home_page_id","id");
    }

    public function FactsSection(){
        return $this->hasMany(HomePageFact::class,"home_page_id","id");
    }

    public function EcologicalSection(){
        return $this->hasMany(HomePageEcologicalWay::class,"home_page_id","id");
    }
}
