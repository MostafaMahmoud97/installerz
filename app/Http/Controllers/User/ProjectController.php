<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Project\StoreProjectRequest;
use App\Http\Requests\User\Project\UpdateProjectRequest;
use App\Service\User\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    protected $service;

    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request){
        return $this->service->index($request);
    }

    public function store(StoreProjectRequest $request){
        return $this->service->store($request);
    }

    public function store_gallery(Request $request){

        $validator = Validator::make($request->all(),[
            "gallery" => "required|mimes:jpg,png,jpeg,svg,webp"
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->store_gallery($request);
    }

    public function show($id){
        return $this->service->show($id);
    }

    public function update($id,UpdateProjectRequest $request){
        return $this->service->update($id,$request);
    }

    public function destroy($id){
        return $this->service->destroy($id);
    }

    public function destroy_gallery(Request $request){
        return $this->service->destroy_gallery($request);
    }
}
