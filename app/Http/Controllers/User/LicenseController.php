<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\License\StoreLicenseRequest;
use App\Http\Requests\User\License\UpdateLicenseRequest;
use App\Service\User\LicenseService;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    protected $service;

    public function __construct(LicenseService $service)
    {
        $this->service = $service;
    }

    public function show(){
        return $this->service->show_license();
    }

    public function store(StoreLicenseRequest $request){
        return $this->service->store($request);
    }

    public function update(UpdateLicenseRequest $request){
        return $this->service->update($request);
    }
}
