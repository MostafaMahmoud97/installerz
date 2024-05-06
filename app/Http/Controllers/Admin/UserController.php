<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Service\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request){
        return $this->service->index($request);
    }

    public function store(StoreUserRequest $request){
        return $this->service->store($request);
    }

    public function change_activation_status($id){
        return $this->service->change_activation_status($id);
    }

    public function change_publish_status($id){
        return $this->service->change_publish_status($id);
    }
}
