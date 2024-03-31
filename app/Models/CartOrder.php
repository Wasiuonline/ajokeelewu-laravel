<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id", "total", "delivery", "name", "email", "country", "address", "phone", "delivery_option", "additional_note", "payment_option", "date_time"
    ];
}
