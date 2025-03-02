<?php


namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    protected function jsonResponse(mixed $data, int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $status);
    }

    protected function successResponse(array $data, int $code = Response::HTTP_OK): JsonResponse
    {
        $thedata = ['ok' => true] + $data;

        return $this->jsonResponse($thedata, $code);
    }

    protected function errorResponse($message, $status, $errors = []): JsonResponse
    {
        $response = ['error' => $message, 'ok' => false];
        if (!empty($errors)) {
            $response = array_merge($response, $errors);
        }
        return response()->json($response, $status);
    }
}
