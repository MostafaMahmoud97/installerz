<?php


namespace App\Service\User;


use App\Models\ProjectPage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ProjectPageService
{
    public function show(){
        $user_id = Auth::id();
        $User = User::with("ProjectPage")->find($user_id);

        return Response::successResponse($User->ProjectPage,"data has been fetched success");
    }

    public function store($request){
        $user_id = Auth::id();
        $ProjectPage = ProjectPage::where("user_id",$user_id)->first();
        if ($ProjectPage){
            return Response::errorResponse("you can't add new project page data, please update data");
        }

        $ProjectPage = ProjectPage::create([
            "user_id" => $user_id,
            "description" => $request->description
        ]);
        return Response::successResponse("data has been created success");
    }

    public function update($request){
        $user_id = Auth::id();
        $ProjectPage = ProjectPage::where("user_id",$user_id)->first();
        if (!$ProjectPage){
            return Response::errorResponse("not found project page data for update");
        }

        $ProjectPage->update($request->all());
        return Response::successResponse([],"data has been updated success");
    }
}
