<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\User\UpdateUserRequest;
use App\Service\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function show(){
        return $this->service->show();
    }

    public function update(UpdateUserRequest $request){
        return $this->service->update($request);
    }

    public function change_password(Request $request){
        $validator = Validator::make($request->all(),[
            "old_password" => "required|min:8",
            "new_password" => "required|min:8|confirmed",
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->change_password($request);
    }
}
