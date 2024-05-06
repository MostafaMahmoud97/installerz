<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\HomePage\StoreHomePageRequest;
use App\Http\Requests\User\HomePage\UpdateeHomePageRequest;
use App\Service\User\HomePageService;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    protected $service;

    public function __construct(HomePageService $service)
    {
        $this->service = $service;
    }

    public function showHomePage(){
        return $this->service->showHomePage();
    }

    public function store(StoreHomePageRequest $request){
        return $this->service->store($request);
    }

    public function update(UpdateeHomePageRequest $request){
        return $this->service->update($request);
    }


}
