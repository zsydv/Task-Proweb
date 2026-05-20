<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WithdrawService;
use App\Models\AuditLog;
use App\Models\Transaction;

class ATMController extends Controller
{
    private $withdrawService;

    public function __construct(WithdrawService $withdrawService) {
        $this->withdrawService = $withdrawService;
    }

    public function withdraw(Request $request) {
        try {
            $request->validate(
                [
                    'account_id' => 'required|integer',
                    'amount' => 'required|numeric|min:1'
                ]
            );

            $requestId = $request->header('X-Request-Id');

            if ($requestId) {

                $exists = Transaction::where('request_id', $requestId)->exists();

                if ($exists) {

                    return response()->json([
                         'message' => 'Duplicate request'
                     ], 400);
                }
            }

            $result = $this->withdrawService->withdraw(
                $request->account_id,
                $request->amount,
                $requestId
            );

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => $e->getMessage()
                ], 400
            );
        }
    }

    public function deleteTransaction($id) {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(
                [
                    'message' => 'Transaction not found'
                ], 404
            );
        }

        $transaction->delete();

        AuditLog::create(
            [
                'action' => 'delete_transaction',
                'description' => 'Deleted transaction id: ' . $id
            ]
        );

        return response()->json(
            [
                'message' => 'Transaction deleted'
            ]
        );
    }

}
