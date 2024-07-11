<?php

namespace App\Modules\Base\Traits;

trait ApiErrorResponse
{
    protected function errorResponse($detail, $code, $meta = [], $outerMeta = []): array
    {
        return [
            'errors' => [
                'title' => $this->getTitle($code),
                'status' => $code,
                'detail' => $detail,
                'meta' => $meta
            ],
            'meta' => $outerMeta,
        ];
    }

    public function getTitle(int $code): string
    {
        return match ($code) {
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            422 => 'Unprocessable Entity',
            500 => 'Internal Server Error',
            default => 'Something went wrong',
        };
    }
}
