<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Card Model
 *
 * @property int $id
 * @property int $account_id
 * @property string $card_number
 *
 * @property-read Collection|Account $account {@see Card::account()}
 * @property-read Collection|Transaction[] $sourceTransactions {@see Card::sourceTransactions()}
 * @property-read Collection|Transaction[] $destinationTransactions {@see Card::destinationTransactions()}
 *
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @package App\Models
 */
class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id', 'card_number',
    ];

    /**
     * Get the account of the card.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the source card transactions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sourceTransactions()
    {
        return $this->hasMany(Transaction::class, 'source_card_id');
    }

    /**
     * Get the destination card transactions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function destinationTransactions()
    {
        return $this->hasMany(Transaction::class, 'destination_card_id');
    }
}
