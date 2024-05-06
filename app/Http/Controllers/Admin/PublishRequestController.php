<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\PublishRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class PublishRequestController extends Controller
{
    protected $service;

    public function __construct(PublishRequestService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request){
        return $this->service->index($request);
    }

    public function changeRequestStatus($id,Request $request){
        $validator = Validator::make($request->all(),[
            "status" => "required|in:accept,reject",
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->changeRequestStatus($id,$request);
    }
}
