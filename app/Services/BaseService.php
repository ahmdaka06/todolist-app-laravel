<?php

namespace App\Services;

class BaseService
{
    public function success(mixed $data, string $message): array
    {
        return [
            'status' => true,
            'code' => 200,
            'data' => $data,
            'message' => $message,
        ];
    }

    public function error(string $error, int $code = 404, $data = null): array
    {
        return [
            'status' => false,
            'code' => $code,
            'message' => $error,
            'data' => $data
        ];
    }
}
