<?php


namespace App\Service\User;


use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class JobService
{
    public function index(){
        $Jobs = Job::with(["media_site_survey","media_design_needed"])
            ->where("user_id",Auth::id())
            ->orderBy("id","desc")->paginate(20);
        return Response::successResponse($Jobs,"jobs have been fetched success");
    }

    public function show($id){
        $Job = Job::with(["media_site_survey","media_design_needed"])
            ->where("user_id",Auth::id())->find($id);

        if (!$Job){
            return Response::errorResponse("not found job");
        }

        return Response::successResponse($Job,"data has been fetched success");
    }
}
