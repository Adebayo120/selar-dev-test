<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Constants\Transaction\TransactionStatus;

class Transaction extends Model
{
    public $table = 'subscription_transactions';

    /**
     * scopePaid
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePaid( Builder $query )
    {
        return $query->where( 'status', TransactionStatus::PAID );
    }
}
