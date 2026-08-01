<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CVTemplateResource;
use App\Interfaces\CVTemplateServiceInterface;

class CVTemplateController extends Controller
{
    protected CVTemplateServiceInterface $service;

    public function __construct(
        CVTemplateServiceInterface $service
    )
    {
        $this->service=$service;
    }

    public function index()
    {
        return CVTemplateResource::collection(
            $this->service->getAll()
        );
    }

    public function show(int $id)
    {
        return new CVTemplateResource(
            $this->service->findById($id)
        );
    }
}