<?php

namespace App\Services;

use App\Models\Account;
use App\Models\AtmCash;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Exception;

class WithdrawService
{
    public function withdraw($accountId, $amount, $requestId = null)
    {

        return DB::transaction(function () use ($accountId, $amount) {

            $account = Account::lockForUpdate()->find($accountId);

            if (!$account) {
                throw new Exception('Account not found');
            }

            if ($account->balance < $amount) {
                throw new Exception('Insufficient balance');
            }

            $cashes = AtmCash::where('currency', $account->currency)
                ->where('count', '>', 0)
                ->orderByDesc('denomination')
                ->get();

            $remaining = $amount;

            $result = [];

            foreach ($cashes as $cash) {

                $needed = intdiv($remaining, $cash->denomination);

                $take = min($needed, $cash->count);

                if ($take > 0) {

                    $result[$cash->denomination] = $take;

                    $remaining -= $take * $cash->denomination;
                }
            }

            if ($remaining > 0) {
                throw new Exception('ATM cannot dispense this amount');
            }

            foreach ($result as $denomination => $count) {

                $cash = AtmCash::lockForUpdate()
                    ->where('currency', $account->currency)
                    ->where('denomination', $denomination)
                    ->first();

                $cash->count -= $count;

                $cash->save();
            }

            $account->balance -= $amount;

            $account->save();

            Transaction::create([
                 'account_id' => $account->id,
                 'amount' => $amount,
                 'currency' => $account->currency,
                 'banknotes' => json_encode($result),
                 'request_id' => $requestId
             ]);


            return [

                'success' => true,
                'message' => 'Withdraw successful',
                'banknotes' => $result,
                'remaining_balance' => $account->balance

            ];
        });
    }
}
