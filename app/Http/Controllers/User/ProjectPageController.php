<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Service\User\ProjectPageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProjectPageController extends Controller
{
    protected $service;
    public function __construct(ProjectPageService $service)
    {
        $this->service = $service;
    }

    public function show(){
        return $this->service->show();
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "description" => "required|string"
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->store($request);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            "description" => "required|string"
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->update($request);
    }
}
