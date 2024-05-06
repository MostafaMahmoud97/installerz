<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "title",
        "license_number",
        "description"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function media_workers_comp (){
        return $this->morphOne(Media::class,"mediable")->where("title","Workers Comp");
    }

    public function media_liability_insurance (){
        return $this->morphOne(Media::class,"mediable")->where("title","Liability Insurance");
    }
}
