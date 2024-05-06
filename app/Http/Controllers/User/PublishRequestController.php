<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Service\User\RequestService;
use Illuminate\Http\Request;

class PublishRequestController extends Controller
{
    protected $service;

    public function __construct(RequestService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return $this->service->index();
    }

    public function sendPublishRequest(){
        return $this->service->sendPublishRequest();
    }
}
