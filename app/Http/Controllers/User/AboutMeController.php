<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AboutMe\StoreAboutMeRequest;
use App\Service\User\AboutMeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AboutMeController extends Controller
{
    protected $service;

    public function __construct(AboutMeService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->showAboutMe();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAboutMeRequest $request)
    {
        return $this->service->store($request);
    }

    public function store_info_about_me(Request $request){
        $validator = Validator::make($request->all(),[
            "title" => "required|string",
            "sub_info" => "required|array|min:1",
            "sub_info.*.title" => "required|string",
            "sub_info.*.description" => "required|string",
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->store_info_about_me($request);
    }

    public function store_sub_info_about_me(Request $request){
        $validator = Validator::make($request->all(),[
            "info_id" => "required|exists:info_about_me_pages,id",
            "sub_info" => "required|array|min:1",
            "sub_info.*.title" => "required|string",
            "sub_info.*.description" => "required|string",
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->store_sub_info_about_me($request);
    }

    public function update_about_me(Request $request){
        return $this->service->update_about_me($request);
    }

    public function update_info_about_me($id,Request $request){
        $validator = Validator::make($request->all(),[
            "title" => "required|string"
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->update_info_about_me($id,$request);
    }

    public function update_sub_info_about_me($id,Request $request){
        $validator = Validator::make($request->all(),[
            "title" => "required|string",
            "description" => "required|string",
        ]);

        if ($validator->fails()){
            return Response::errorResponse($validator->errors());
        }

        return $this->service->update_sub_info_about_me($id,$request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_info_about_me($id){
        return $this->service->destroy_info_about_me($id);
    }

    public function destroy_sub_info_about_me($id){
        return $this->service->destroy_sub_info_about_me($id);
    }
}
