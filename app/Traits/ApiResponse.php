<?php

namespace App\Traits;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait ApiResponse
{
    public function sendOk($status = 'OK', $code = 200): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => $status,
            'data' => 'Success'
        ], $code);
    }

    public function sendData($data, $status = 'OK', $code = 200): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => $status,
            'data' => $data
        ], $code);
    }

    public function sendCreated($data, $status = 'Success', $code = 201): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => $status,
            'data' => $data
        ], $code);
    }

    public function sendUpdated($data, $status = 'Updated', $code = 200): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => $status,
            'data' => $data
        ], $code);
    }

    public function sendDeleted($data, $status = 'Deleted', $code = 200): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => $status,
            'data' => $data
        ], $code);
    }

    public function sendError($message, $status = 'Error', $code = 400): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => $status,
            'data' => $message
        ], $code);
    }

    public function sendUnauth($status = 'Unauthorized', $code = Response::HTTP_UNAUTHORIZED): JsonResponse
    {
        return response()->json([
            'code' => $code, 
            'status' => $status, 
            'data' => 'Please Login'
        ], $code);
    }

    public function sendNotFound($status = 'Not Found', $code = 404): JsonResponse
    {
        return response()->json([
            'code' => $code, 
            'status' => $status, 
            'data' => "Entity Not Found"
        ], $code);
    }

    public function sendForbidden($message, $status = 'Forbidden', $code = 403): JsonResponse
    {
        return response()->json([
            'code' => $code, 
            'status' => $status, 
            'data' => $message
        ], $code);
    }

    public function sendBadCred($status = 'Bad Cred', $code = 400): JsonResponse
    {
        return response()->json([
            'code' => $code, 
            'status' => $status, 
            'data' => 'Login Failed'
        ], $code);
    }

    public function handleException(Exception $e): JsonResponse
    {
        Log::error($e);

        if ($e instanceof HttpException) {
            $code = $e->getStatusCode();
            if (!$message = $e->getMessage())
                $message = Response::$statusTexts[$code];

            return $this->sendError($message, 'Error', $code);
        }

        if ($e instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($e->getModel()));

            return $this->sendError("{$model} not found", 'Error', Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof AuthorizationException) {
            return $this->sendError($e->getMessage(), Response::HTTP_FORBIDDEN);
        }

        if ($e instanceof AuthenticationException) {
            return $this->sendError($e->getMessage(), 'Error', Response::HTTP_UNAUTHORIZED);
        }

        if ($e instanceof ValidationException) {
            $errors = $e->validator->errors()->getMessages();

            return $this->sendError($errors, 'Error', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (env('APP_DEBUG')) {
            return $this->sendError($e->getMessage(), 'Error', 500);
        }

        return $this->sendError('Unexpected error. Try again later.', 'Error', 500);
    }
}
