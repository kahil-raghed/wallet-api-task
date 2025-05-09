<?php


namespace App\Services;

use App\Dtos\TransferFundsResult;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Exceptions\InsufficientFundsException;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class WalletService
{

    public function getAllTransactions($userId): Collection
    {
        return Transaction::query()->where('user_id', $userId)->orderByDesc('created_at')->get();
    }

    public function showTransaction($transactionId): Transaction
    {
        return Transaction::query()->whereKey($transactionId)->firstOrFail();
    }

    public function depositFunds($userId, float $amount): Transaction
    {
        DB::beginTransaction();

        $user = User::query()->whereKey($userId)->lockForUpdate()->firstOrFail();

        $user->balance += $amount;
        $user->save();

        $transaction = new Transaction([
            'user_id' => $userId,
            'type' => TransactionType::DEPOSIT,
            'status' => TransactionStatus::COMPLETED,
            'amount' => $amount,
        ]);

        $transaction->save();

        DB::commit();

        return $transaction;
    }

    public function withdrawFunds($userId, float $amount): Transaction
    {
        DB::beginTransaction();

        $user = User::query()->whereKey($userId)->lockForUpdate()->firstOrFail();

        $user->balance -= $amount;
        if ($user->balance < 0) {
            throw new InsufficientFundsException();
        }
        $user->save();

        $transaction = new Transaction([
            'user_id' => $user->id,
            'type' => TransactionType::WITHDRAWAL,
            'status' => TransactionStatus::COMPLETED,
            'amount' => -$amount,
        ]);

        $transaction->save();

        DB::commit();

        return $transaction;
    }


    public function transferFunds($senderId, string $receiverEmail, float $amount): TransferFundsResult
    {
        DB::beginTransaction();

        $sender = User::query()->whereKey($senderId)->lockForUpdate()->firstOrFail();
        $receiver = User::query()->where('email', $receiverEmail)->lockForUpdate()->firstOrFail();

        $sender->balance -= $amount;
        if ($sender->balance < 0) {
            throw new InsufficientFundsException();
        }
        $sender->save();

        $receiver->balance += $amount;
        $receiver->save();

        $senderTransaction = new Transaction([
            'user_id' => $sender->id,
            'type' => TransactionType::TRANSFER,
            'status' => TransactionStatus::COMPLETED,
            'amount' => -$amount,
            'other_email' => $receiver->email,
        ]);

        $receiverTransaction = new Transaction([
            'user_id' => $receiver->id,
            'type' => TransactionType::RECEIVE_TRANSFER,
            'status' => TransactionStatus::COMPLETED,
            'amount' => $amount,
            'other_email' => $sender->email,
        ]);

        $senderTransaction->save();
        $receiverTransaction->save();

        DB::commit();

        $results = new TransferFundsResult($senderTransaction, $receiverTransaction);

        return $results;
    }
}
