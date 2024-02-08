<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponder
{
    public function successResponse($data = null, $message = 'Success', $code = Response::HTTP_OK)
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data,
        ], $code)->header('Content-Type', 'application/json');
    }

    public function errorResponse($data = null, $message = null, $code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'status' => $code,
            'message' => $message ?? 'Error',
            'data' => $data,
        ], $code)->header('Content-Type', 'application/json');
    }
}
