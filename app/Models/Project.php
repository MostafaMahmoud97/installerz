<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "address",
        "type",
        "date"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function media_thumbnail(){
        return $this->morphOne(Media::class,"mediable")->where("title","Thumbnail");
    }

    public function media_gallery(){
        return $this->morphMany(Media::class,"mediable")->where("title","Gallery");
    }
}
