<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageFact extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "home_page_id",
        "number",
        "title"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function media_icon(){
        return $this->morphOne(Media::class,"mediable");
    }
}
