<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'user_type',
        'stripe_customer_id',
        'stripe_subscription_id',
        'status',
        'start_date',
        'end_date',
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
