<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RegisterResource;
use App\Http\Services\RegisterService;

class RegisterController extends Controller
{
    private RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function store(RegisterRequest $request)
    {
        $user = $this->registerService->register($request);
        if ($user) {
            return RegisterResource::make($user)
                ->response()
                ->setStatusCode(201);
        }
        return response(['error' => 'creation error'])->setStatusCode(400);
    }
}
