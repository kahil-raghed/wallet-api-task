<?php

namespace App\Exceptions;

use App\Enums\ErrorCode;
use Exception;

class ApplicationException extends Exception
{
    public function __construct(
        ErrorCode $errorCode,
        string|null $message,
    ) {
        $this->code = $errorCode->value;
        $this->codeName = $errorCode->name;
        $this->message = $message;
    }

    protected string $codeName;

    protected $httpStatus = 400;

    public function getCodeName(): string
    {
        return $this->codeName;
    }

    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }
}
