<?php

namespace App\Http\Services;

use App\Http\Requests\RegisterRequest;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Database\Eloquent\Model;

class RegisterService
{
    private UserRepositoryContract $userRepository;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request): ?Model
    {
        return $this->userRepository->create($request->validated());
    }
}
