<?php

namespace App\Exports;

use App\Models\SubscriptionPackage;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SubscriptionPackagesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    private $no = 0;

    public function collection(): Collection
    {
        return SubscriptionPackage::withCount([
            'subscriptionPackageBooks',
            'subscriptionPackageUser as active_customers_count' => function ($query) {
                $query->whereDate('expired_date', '>=', now()->toDateString());
            },
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Nama Paket Langganan',
            'Harga',
            'Jumlah Buku',
            'Pelanggan Aktif',
        ];
    }

    public function map($package): array
    {
        return [
            ++$this->no,
            $package->name,
            'Rp ' . number_format($package->price, 0, ',', '.'),
            $package->subscription_package_books_count,
            $package->active_customers_count,
        ];
    }

    public function styles(Worksheet $sheet): array
{
    $totalRows = $this->collection()->count() + 1;

    return [
        1 => [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'D9D9D9',
                ],
            ],
        ],

        "A1:E{$totalRows}" => [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => [
                        'rgb' => '000000',
                    ],
                ],
            ],
        ],
    ];
}
}
