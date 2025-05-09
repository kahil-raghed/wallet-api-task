<?php

namespace App\Enums;

enum TransactionStatus: int
{
    case PENDING = 1;
    case COMPLETED = 2;
    case DECLINED = 3;
    case FAILED = 4;
    case CANCELLED = 5;
}
