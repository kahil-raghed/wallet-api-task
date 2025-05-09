<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    function __construct(
        private WalletService $walletService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function transactionHistory()
    {
        $user = Auth::user();
        $transactions = $this->walletService->getAllTransactions($user->id);

        return TransactionResource::collection($transactions);
    }

    public function showTransaction($id)
    {
        return new TransactionResource($this->walletService->showTransaction($id));
    }
}
