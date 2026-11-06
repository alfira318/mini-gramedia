<?php

namespace App\Exports;

use App\Models\BookCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookCategoriesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return BookCategory::withCount('books')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kategori',
            'Jumlah Buku'
        ];
    }

    private $no = 0;

    public function map($bookCategory): array
    {
        return [
            ++$this->no,
            $bookCategory->name,
            $bookCategory->books_count
        ];
    }
}
