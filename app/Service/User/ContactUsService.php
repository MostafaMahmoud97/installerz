<?php


namespace App\Service\User;


use App\Models\ContactUs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ContactUsService
{
    public function index($request){
        $user_id = Auth::id();
        $ContactUs = ContactUs::where(function ($q) use ($request){
            $q->where("first_name","like","%".$request->search."%")
                ->orWhere("last_name","like","%".$request->search."%");
        })->where("user_id",$user_id)->orderBy("id","desc")->paginate(15);

        return Response::successResponse($ContactUs,"messages have been fetched success");
    }
}
