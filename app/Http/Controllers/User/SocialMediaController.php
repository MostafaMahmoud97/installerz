<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Service\User\SocialMediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class SocialMediaController extends Controller
{
    protected $service;

    public function __construct(SocialMediaService $service)
    {
        $this->service = $service;
    }

    public function get_media_icons(){
        return $this->service->get_media_icons();
    }

    public function index(){
        return $this->service->index();
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "link" => "required",
            "social_id" => "required|integer|exists:social_media,id"
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->store($request);
    }

    public function update($id,Request $request){
        $validator = Validator::make($request->all(),[
            "link" => "required",
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->update($id,$request);
    }

    public function destroy($id){
        return $this->service->destroy($id);
    }
}
