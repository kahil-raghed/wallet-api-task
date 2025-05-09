<?php

namespace App\Services;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{

    function __construct(private WalletService $walletService) {}

    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($id): User
    {
        return User::findOrFail($id);
    }

    public function createUser($data): User
    {
        DB::beginTransaction();
        $balance = $data['balance'] ?? 0;

        $user = new User($data);
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->balance = $balance;
        $user->save();

        if ($balance > 0) {
            $user->transactions()->create([
                'type' => TransactionType::DEPOSIT,
                'status' => TransactionStatus::COMPLETED,
                'amount' => $balance,
                'notes' => 'Initial balance',
            ]);
        }

        DB::commit();

        return $user;
    }
}
