<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable('user_id', 'book_id', 'subscription_id')]
class Cart extends Model
{
    public function user():belongsTo
    {
        return $this->belongsTo(User::class);
    }
     public function book():belongsTo
    {
        return $this->belongsTo(Book::class);
    }
    public function subscriptionPackage():belongsTo
    {
        return $this->belongsTo(SubscriptionPackage::class);
    }
}
