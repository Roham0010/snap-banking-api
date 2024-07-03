<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Card;
use App\Models\Transaction;
use App\Notifications\SMSNotification;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Perform a money transfer between two cards.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cardTransfer(TransactionRequest $request)
    {
        if ($request->source_card_number === $request->destination_card_number) {
            return response()->json([
                'error' => 'Source card should not be the same as the destication card.',
                'error_key' => 'same_card',
            ], 400);
        }

        $sourceCard = Card::where('card_number', $request->source_card_number)->first();
        $destinationCard = Card::where('card_number', $request->destination_card_number)->first();

        if (!$sourceCard || !$destinationCard) {
            return response()->json([
                'error' => 'Invalid card number(s).',
                'error_key' => 'card_not_exist',
            ], 400);
        }

        // Check if source card has sufficient balance
        if ($sourceCard->account->balance < ($request->amount + config('bankingapi.transaction_fee'))) {
            return response()->json([
                'error' => 'Balance is not sufficient.',
                'error_key' => 'insufficient_balance'
            ], 400);
        }

        return $this->doCardTransferTransaction($request, $sourceCard, $destinationCard);
    }

    /**
     * Does the transaction between two given cards.
     *
     * @param TransactionRequest $request
     * @param Card $sourceCard
     * @param Card $destinationCard
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    private function doCardTransferTransaction(TransactionRequest $request, Card $sourceCard, Card $destinationCard)
    {
        DB::beginTransaction();

        try {
            // Deduct amount from source account
            $sourceCard->account->balance -= ($request->amount + config('bankingapi.transaction_fee'));
            $sourceCard->account->save();

            // Add amount to destination account
            $destinationCard->account->balance += $request->amount;
            $destinationCard->account->save();

            // Record the transaction
            $transaction = new Transaction();
            $transaction->source_card_id = $sourceCard->id;
            $transaction->destination_card_id = $destinationCard->id;
            $transaction->amount = $request->amount;
            $transaction->save();

            // Transaction fee already set in the model with default value of 500
            $transaction->transactionFee()->create([
                "fee_amount" => config('bankingapi.transaction_fee') // Can also be a env var if changes a lot
            ]);

            $this->sendSMSNotification($sourceCard, $destinationCard);

            DB::commit();

            return response()->json(['message' => 'Transaction successful.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Transaction failed. ' . $e->getMessage()], 500);
        }
    }

    private function sendSMSNotification(Card $sourceCard, Card $destinationCard)
    {
        $sourceCard->account->user->notify(new SMSNotification(config('sms_messages.transaction.debit')));
        $destinationCard->account->user->notify(new SMSNotification(config('sms_messages.transaction.credit')));
    }
}
