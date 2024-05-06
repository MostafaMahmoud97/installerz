<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Service\User\ContactUsService;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    protected $service;

    public function __construct(ContactUsService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request){
        return $this->service->index($request);
    }
}
