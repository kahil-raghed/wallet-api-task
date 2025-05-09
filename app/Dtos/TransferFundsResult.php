<?php

namespace App\Dtos;

use App\Models\Transaction;

class TransferFundsResult
{
    function __construct(
        public Transaction $senderTransaction,
        public Transaction $receiverTransaction
    ) {}
}
