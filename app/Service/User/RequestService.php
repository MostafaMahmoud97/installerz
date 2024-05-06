<?php


namespace App\Service\User;


use App\Models\PublishRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RequestService
{
    public function index(){
        $Requests = PublishRequest::where("user_id",Auth::id())->paginate(10);

        return Response::successResponse($Requests,"requests have been fetched success");
    }

    public function sendPublishRequest(){
        $Request = PublishRequest::where(["user_id"=>Auth::id(),"status" => "pending"])->first();
        if ($Request){
            return Response::errorResponse("You have already sent a request");
        }


        $Request = PublishRequest::create([
            "user_id" => Auth::id()
        ]);

        return Response::successResponse($Request,"request has been sent successfully");
    }
}
