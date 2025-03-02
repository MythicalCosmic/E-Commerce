<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends ApiController
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        return $this->successResponse($this->service->all());
    }

    public function show(User $user): JsonResponse
    {
        return $this->successResponse($this->service->show($user));
    }

    public function create(UserRequest $request): JsonResponse
    {
        return $this->successResponse($this->service->create($request->validated()));
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        return $this->successResponse($this->service->update($user, $request->validated()));
    }

    public function destroy(User $user): JsonResponse
    {
        return $this->successResponse($this->service->delete($user));
    }
}
