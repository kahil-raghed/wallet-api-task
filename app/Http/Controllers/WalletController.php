<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wallet\DepositRequest;
use App\Http\Requests\Wallet\WithdrawalRequest;
use App\Http\Requests\Wallet\TransferRequest;

use App\Http\Resources\TransactionResource;
use App\Services\WalletService;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    function __construct(
        private WalletService $walletService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function deposit(DepositRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        $transaction = $this->walletService->depositFunds($user->id, $data['amount']);

        return new TransactionResource($transaction);
    }

    public function withdraw(WithdrawalRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        $transaction = $this->walletService->withdrawFunds($user->id, $data['amount']);

        return new TransactionResource($transaction);
    }

    public function transfer(TransferRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        $result = $this->walletService->transferFunds($user->id, $data['receiver_email'], $data['amount']);

        return new TransactionResource($result->senderTransaction);
    }
}
