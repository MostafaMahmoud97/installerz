<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guest\ContactUs\SendMessageRequest;
use App\Service\Guest\ContactUsService;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    protected $service;

    public function __construct(ContactUsService $service)
    {
        $this->service = $service;
    }

    public function SendMessage(SendMessageRequest $request){
        return $this->service->SendMessage($request);
    }
}
