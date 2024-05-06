<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Service\User\JobService;
use Illuminate\Http\Request;

class JobController extends Controller
{
    protected $service;

    public function __construct(JobService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return $this->service->index();
    }

    public function show($id){
        return $this->service->show($id);
    }
}
