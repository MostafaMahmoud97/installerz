<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\SocialMediaService;
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

    public function index(){
        return $this->service->index();
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "title" => "required|unique:social_media,title",
            "logo" => "required|mimes:jpg,png,jpeg,svg,webp"
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->store($request);
    }

    public function show($id){
        return $this->service->show($id);
    }

    public function update($id,Request $request){
        $validator = Validator::make($request->all(),[
            "title" => "required|unique:social_media,title,".$id,
            "logo" => "nullable|mimes:jpg,png,jpeg,svg,webp"
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
