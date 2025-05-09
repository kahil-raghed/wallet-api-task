<?php

namespace App\Exceptions;

use App\Enums\ErrorCode;
use Exception;

class InsufficientFundsException extends ApplicationException
{
    public function __construct(string $message = "You don't have enough funds to make this transaction")
    {
        parent::__construct(ErrorCode::INSUFFICIENT_FUNDS, $message);
    }
}
