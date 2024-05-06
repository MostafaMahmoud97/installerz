<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->enum("service",["Install and BOS only", "Permit" , "Project Management","All services"]);
            $table->string("company_name");
            $table->string("project_manager");
            $table->string("pm_phone");
            $table->string("pm_email");
            //------------------------------------->
            $table->string("full_name");
            $table->longText("address");
            $table->string("phone");
            $table->string("email");
            $table->boolean("is_hoa");
            $table->boolean("site_survey_needed");
            $table->boolean("design_needed");
            //--------------------------------------------->
            $table->enum("installation_type",["ground mount","roof top"]);
            $table->double("num_of_feet_trenching")->default(0)->nullable();
            $table->enum("roof_type",["shingle","espanshe"])->nullable();
            $table->double("roof_pitch")->default(0)->nullable();
            $table->boolean("bird_protected")->default(0)->nullable();
            $table->boolean("solar_lip")->default(0)->nullable();
            $table->integer("number_of_panels")->default(0)->nullable();
            $table->double("panel_wattage")->default(0)->nullable();
            $table->double("system_size")->default(0)->nullable();
            $table->string("inverter_type")->default("")->nullable();
            $table->boolean("main_survey_upgrade")->default(0)->nullable();
            $table->string("existing_amp")->default("")->nullable();
            $table->boolean("de_rate")->default(0)->nullable();
            $table->string("new_amp")->default("")->nullable();
            $table->boolean("is_battery")->default(0)->nullable();
            $table->integer("number_battery")->default(0)->nullable();
            $table->boolean("is_ev_charger")->default(0)->nullable();
            $table->double("number_feet_from_service_panel")->default(0)->nullable();
            $table->longText("notes")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
