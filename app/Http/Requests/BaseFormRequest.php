<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    public function sendResponse(?array $data, string $message)
    {
        $response = [
            'status' => true,
            'statusCode' => 200,
            'data' => $data,
            'message' => $message,
        ];


        return response()->json($response);
    }

    public function sendError(string $error, ?array $errorMessages, int $code = 404)
    {
        $response = [
            'status' => false,
            'statusCode' => $code,
            'message' => $error,
            'data' => $errorMessages
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
