<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return $this->errorResponse('Creation Failed', 422, $validator->errors());
        }

        return $this->successResponse($this->service->create($request->validated()));
    }


    public function update(UserRequest $request, User $user): JsonResponse
    {
        return $this->successResponse($this->service->update($user, $request->validated()));
    }

    public function destroy(User $user): JsonResponse
    {
        return $this->service->delete($user);
    }
}
