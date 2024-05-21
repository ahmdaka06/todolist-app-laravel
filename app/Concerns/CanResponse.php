<?php

namespace App\Concerns;

trait CanResponse
{
    public function sendResponse(mixed $data, string $message)
    {
        $response = [
            'status' => true,
            'statusCode' => 200,
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($response);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'status' => false,
            'statusCode' => $code,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
