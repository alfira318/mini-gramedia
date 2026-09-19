<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

//nama nama field yang akan diisi oleh pengguna / sistem, bukan defaul dari database
//id dan timstamps : diisi default oleh sistem database, jadi tidak didaftarkan disini
#[Fillable(['cover', 'title', 'price', 'description', 'language', 'publisher', 'writer', 'release_date', 'page_of_book', 'book_category_id'])]

class Book extends Model
{
    public function bookCategory(): BelongsTo {
        return $this->belongsTo(BookCategory::class);
    }

    public function checkoutBooks(): HasMany {
        return $this->hasMany(CheckoutBook::class);
    }

    public function subscriptionPackageBooks(): HasMany {
        return $this->hasMany(SubscriptionPackageBook::class);
    }
}
