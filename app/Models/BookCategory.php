<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name'])]
class BookCategory extends Model
{
    public function books(): HasMany
    {
        //nama jarak menggunakan e/es karena bookcategories berperan sebagai many pada relasi
        //one to many milik kategori buku
        return $this->hasMany(Book::class);
    }
}
