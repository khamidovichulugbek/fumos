<?php

namespace App\Services;

use App\DTOs\ServiceResponseDTO;

final class ResponseService
{
    public function successfulServiceResponse(
        mixed $data = [],
        string $message = '',
        int $httpStatusCode = 200
    ):ServiceResponseDTO {
        return new ServiceResponseDTO(
            data: $data,
            message: $message,
            http_status_code: $httpStatusCode,
            error: false
        );
    }

    public function failedServiceResponse(
        mixed $data = [],
        string $message = '',
        int $httpStatusCode = 400
    ): ServiceResponseDTO {
        return new ServiceResponseDTO(
            data: $data,
            message: $message,
            http_status_code: $httpStatusCode,
            error: true
        );
    }
}
