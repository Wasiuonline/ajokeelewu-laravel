<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;
    protected $fillable = [
        "order_id", "user_id", "txnref", "amount", "payment_means", "resp", "description", "confirmed", "date_time"
    ];
}
