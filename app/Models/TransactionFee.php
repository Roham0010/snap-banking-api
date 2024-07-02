<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionFee Model
 *
 * @property int $id
 * @property int $transaction_id
 * @property float $fee_amount
 *
 * @property-read Collection|Transaction $transaction {@see TransactionFee::transaction()}
 *
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @package App\Models
 */
class TransactionFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 'fee_amount',
    ];

    /**
     * Get the transaction related to this transaction fee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
