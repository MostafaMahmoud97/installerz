<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "name",
        "position",
        "description"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function media_cover(){
        return $this->morphOne(Media::class,"mediable");
    }
}
