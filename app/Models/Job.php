<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "service",
        "company_name",
        "project_manager",
        "pm_phone",
        "pm_email",
        //------------------->
        "full_name",
        "address",
        "phone",
        "email",
        "is_hoa",
        "site_survey_needed",
        "design_needed",
        //--------------------->
        "installation_type",
        "num_of_feet_trenching",
        "roof_type",
        "roof_pitch",
        "bird_protected",
        "solar_lip",
        "number_of_panels",
        "panel_wattage",
        "system_size",
        "inverter_type",
        "main_survey_upgrade",
        "existing_amp",
        "de_rate",
        "new_amp",
        "is_battery",
        "number_battery",
        "is_ev_charger",
        "number_feet_from_service_panel",
        "notes"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function media_site_survey(){
        return $this->morphOne(Media::class,"mediable")->where("title","Site Survey");
    }

    public function media_design_needed(){
        return $this->morphOne(Media::class,"mediable")->where("title","Design Needed");
    }
}
