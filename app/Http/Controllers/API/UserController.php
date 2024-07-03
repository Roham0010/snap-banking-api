<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;

class UserController extends Controller
{

    /**
     * First gets the top users with the
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function topUsers()
    {
        $tenMinutesAgo = now()->subMinutes(10);
        $timeFilterCallback = function ($query) use ($tenMinutesAgo) {
            $query->where('transactions.created_at', '>=', $tenMinutesAgo);
        };

        // Get top three users with most transactions
        $topUsers = User::whereHas('sourceTransactions', $timeFilterCallback)
            ->orWhereHas('destinationTransactions', $timeFilterCallback)
            ->withCount([
                'sourceTransactions as st_count' => $timeFilterCallback,
                'destinationTransactions as dt_count' => $timeFilterCallback
            ])
            ->orderByRaw('st_count + dt_count desc')
            ->take(3)
            ->get();

        // Get top three users last 10 transactions
        $topUsers = $topUsers->map(function ($user) {
            $userCardIds = Account::where('user_id', $user->id)->get()->pluck('cards.*.id')->flatten();

            $user->transactions = Transaction::whereIn('source_card_id', $userCardIds)
                ->orWhereIn('destination_card_id', $userCardIds)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            return $user;
        });

        return response()->json(['top_users' => $topUsers]);
    }
}
