<?php


namespace App\Service\Admin;


use App\Models\PublishRequest;
use Illuminate\Support\Facades\Response;

class PublishRequestService
{
    public function index($request){
        $Request = PublishRequest::with("user");

        if($request->status != "all"){
            $Request = $Request->where("status",$request->status);
        }

        $Request = $Request->paginate(15);
        return Response::successResponse($Request,"requests have been fetched success");
    }

    public function changeRequestStatus($id,$request){
        $Request = PublishRequest::where("status","pending")->find($id);
        if (!$Request){
            return Response::errorRequest("not found pending request");
        }

        $Request->update($request->all());

        if($request->status == "accept"){
            $user = $Request->User;
            $user->is_publish = 1;
            $user->save();
        }

        return Response::successResponse([],"status has been changed success");
    }
}
