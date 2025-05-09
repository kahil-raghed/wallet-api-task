<?php

namespace App\Enums;

enum TransactionType: int
{
    case DEPOSIT = 1;
    case WITHDRAWAL = 2;
    case TRANSFER = 3;
    case RECEIVE_TRANSFER = 4;
}
