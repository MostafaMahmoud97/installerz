<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Service\User\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            "email" => "required|email",
            "password" => "required"
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->login($request);
    }

    public function forgot_password(Request $request){
        $Validator = Validator::make($request->all(),[
            'email' => 'required|email'
        ]);

        if($Validator->fails()){
            return Response::errorResponse($Validator->errors());
        }

        return  $this->service->forgot_password($request);
    }

    public function callback_reset_password(Request $request){
        $Validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'token' => 'required',
        ]);

        if($Validator->fails()){
            return Response::errorResponse($Validator->errors());
        }

        $this->service->callback_reset($request);
    }

    public function reset_password(Request $request){
        return $this->service->reset_password($request);
    }
}
