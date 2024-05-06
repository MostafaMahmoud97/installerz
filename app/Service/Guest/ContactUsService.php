<?php


namespace App\Service\Guest;


use App\Models\ContactUs;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class ContactUsService
{
    public function SendMessage($request){
        $user = User::find($request->user_id);
        if($user->is_publish != 1){
            return Response::errorResponse("You can't send message now");
        }

        $ContactUs = ContactUs::create($request->all());
        return Response::successResponse($ContactUs,"message has been sent");
    }
}
