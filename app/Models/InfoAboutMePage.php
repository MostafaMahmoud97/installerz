<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoAboutMePage extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "about_me_id",
        "title"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function SubInfo(){
        return $this->hasMany(SubInfoAboutMePage::class,"info_about_me_id","id");
    }
}
