<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_name',
        'slogan',
        'email',
        'password',
        "phone",
        "mail",
        "address",
        "subdomain",
        "is_active",
        "is_publish"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $url = "http://localhost:8000/api/auth/callback-reset-password?token=".$token.'&email='.$this->email;
        $name = $this->company_name;
        $this->notify(new ResetPasswordNotification($url,$name));
    }

    public function media(){
        return $this->morphOne(Media::class,"mediable");
    }

    public function UserSocialMedia(){
        return $this->belongsToMany(SocialMedia::class,"user_social_media","user_id","social_media_id","id","id")->with("media")->withPivot("link");
    }

    public function HomePage(){
        return $this->hasOne(HomePage::class,"user_id","id");
    }

    public function OurTeams(){
        return $this->hasMany(OurTeam::class,"user_id","id");
    }

    public function AboutMePage(){
        return $this->hasOne(AboutMePage::class,"user_id","id");
    }

    public function LicensePage(){
        return $this->hasOne(License::class,"user_id","id");
    }

    public function ContactUs(){
        return $this->hasMany(ContactUs::class,"user_id","id");
    }

    public function ProjectPage(){
        return $this->hasOne(ProjectPage::class,"user_id","id");
    }

    public function Projects(){
        return $this->hasMany(Project::class,"user_id","id");
    }

    public function Jobs(){
        return $this->hasMany(Job::class,"user_id","id");
    }

}
