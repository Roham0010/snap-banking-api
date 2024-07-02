<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Transaction Model
 *
 * @property int $id
 * @property int $source_card_id
 * @property int $destination_card_id
 * @property float $amount
 *
 * @property-read Collection|Card $sourceCard {@see Transaction::sourceCard()}
 * @property-read Collection|Card $destinationCard {@see Transaction::destinationCard()}
 * @property-read Collection|TransactionFee $transactionFee {@see Transaction::transactionFee()}
 *
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @package App\Models
 */
class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'source_card_id',
        'destination_card_id',
        'amount',
    ];

    /**
     * Get the transaction's source card.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sourceCard()
    {
        return $this->belongsTo(Card::class, 'source_card_id');
    }

    /**
     * Get the transaction's destination card.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destinationCard()
    {
        return $this->belongsTo(Card::class, 'destination_card_id');
    }

    /**
     * Get the transaction fee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transactionFee()
    {
        return $this->hasOne(TransactionFee::class);
    }
}
