<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guest\Job\SubmitJobRequest;
use App\Service\Guest\JobService;
use Illuminate\Http\Request;

class JobControllrt extends Controller
{
    protected $service;

    public function __construct(JobService $service)
    {
        $this->service = $service;
    }

    public function submit_job(SubmitJobRequest $request){
        return $this->service->submit_job($request);
    }
}
