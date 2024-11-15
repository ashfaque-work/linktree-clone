<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'url_slug',
        'list',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
