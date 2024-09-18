<?php

namespace App\DTOs;

final class ServiceResponseDTO
{
    public function __construct(
        public readonly mixed $data,
        public readonly string $message,
        public readonly int $http_status_code,
        public readonly bool $error
    ){
    }
}
