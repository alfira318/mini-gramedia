<?php

namespace App\Service\Midtrans;

use Midtrans\Snap;
use App\Models\Checkout;

class CreateSnapTokenService extends Midtrans
{

    public function __construct(protected Checkout $checkout)
    {
        parent::__construct();

    }

    public function getSnapToken()
    {
        // NamaModel::with  -> load() / loadiMissing() : mengambil relasi ketika
        // instansiasi modelnya tidak ada di lokasi yg sama
        $this->checkout->loadMissing(['checkoutBooks', 'checkoutBooks.book', 'user']);
        $params = [
            'transaction_details' => [
                'order_id' => $this->checkout->order_code,
                'gross_amount' => (int)$this->checkout->total_price,
            ],
            'item_details' => $this->checkout->checkoutBooks->map(fn ($row) =>
                [
                    // ambil relasi book dari checkoutBooks, lalu ambil fieldnya
                    'id' => $row->book->id,
                    'price' => (int)$row->price,
                    // harga yg diambil price dari checkoutBooks bukan dari books
                    // (price yg udah di sesuai in dari paket langganan / satuan)
                    'quantity' => 1,
                    'name' => $row->book->title,
                ]
            )->all(),
            'customer_details' => [
                'first_name' => $this->checkout->user->name,
                'email' => $this->checkout->user->email,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
