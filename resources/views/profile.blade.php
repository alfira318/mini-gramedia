
@extends('layout.app')

@section('content')
<div class="container-xl py-4">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="avatar avatar-lg bg-primary text-white">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>

                        <div class="overflow-hidden">
                            <h3 class="mb-1 text-truncate">{{ $user->name }}</h3>
                        </div>
                    </div>

                    <div class="text-secondary small mb-2">
                        {{ $user->email }}
                    </div>

                    <hr>

                    <h3 class="text-primary mb-4">Profil Summary</h3>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-secondary">Koleksi Buku</span>
                        <span class="badge bg-primary text-white">
                            {{ $bookCount }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-secondary">Langganan Aktif</span>
                        <span class="badge bg-success text-white">
                            {{ $packages->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h2 class="mb-1">Transaksi</h2>
                    <div class="text-secondary">
                        Riwayat langganan dan pembelian buku kamu
                    </div>
                </div>

                <select id="transactionType" class="form-select" style="width: 210px">
                    <option value="subscription">Paket Langganan</option>
                    <option value="book">Buku</option>
                </select>
            </div>

            <div id="subscriptionTransactions">
                @forelse ($packages as $item)
                    <div class="card mb-3">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                                <div class="text-secondary small">
                                    {{ $item->created_at?->format('d M Y, H:i') ?? '-' }}
                                </div>

                                <span class="badge bg-success text-white">
                                    Aktif
                                </span>
                            </div>

                            <hr>

                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                                <div>
                                    <h3 class="mb-2">
                                        {{ $item->subscriptionPackage->name ?? 'Paket Langganan' }}
                                    </h3>

                                    <span class="badge bg-danger text-white">
                                        Berlaku sampai
                                        {{ \Carbon\Carbon::parse($item->expired_date)->format('d M Y') }}
                                    </span>
                                </div>

                                <div class="text-end">
                                    <div class="text-secondary small mb-1">
                                        Harga Paket
                                    </div>
                                    <div class="h3 mb-0">
                                        Rp {{ number_format($item->subscriptionPackage->price ?? 0, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="mb-3">
                                <i class="ti ti-calendar-off" style="font-size: 40px"></i>
                            </div>
                            <h3>Belum Ada Langganan Aktif</h3>
                            <p class="text-secondary mb-0">
                                Paket langganan aktif kamu akan muncul di sini.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div id="bookTransactions" style="display: none">
                @forelse ($checkouts as $checkout)
                    <div class="card mb-3">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                                <div class="text-secondary small">
                                    {{ $checkout->created_at?->format('d M Y, H:i') ?? '-' }}
                                </div>

                                <span class="badge bg-secondary text-white">
                                    {{ ucfirst($checkout->status ?? 'Diproses') }}
                                </span>
                            </div>

                            <hr>

                            @forelse ($checkout->checkoutBooks as $checkoutBook)
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    @if ($checkoutBook->book && $checkoutBook->book->cover)
                                        <img
                                            src="{{ asset($checkoutBook->book->cover) }}"
                                            alt="Cover buku"
                                            class="rounded"
                                            style="width: 60px; height: 80px; object-fit: cover"
                                        >
                                    @else
                                        <div class="bg-secondary-lt rounded d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 80px">
                                            <i class="ti ti-book" style="font-size: 25px"></i>
                                        </div>
                                    @endif

                                    <div class="flex-fill">
                                        <h3 class="mb-1">
                                            {{ $checkoutBook->book->title ?? 'Buku tidak tersedia' }}
                                        </h3>

                                        <div class="text-secondary small">
                                            Jumlah: {{ $checkoutBook->total_book }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-secondary">Tidak ada detail buku pada transaksi ini.</p>
                            @endforelse

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-secondary small">
                                    {{ $checkout->payment_method ?? 'Metode pembayaran tidak tersedia' }}
                                </div>

                                <div class="text-end">
                                    <div class="text-secondary small mb-1">
                                        Total Pembayaran
                                    </div>
                                    <div class="h3 mb-0">
                                        Rp {{ number_format($checkout->total_price ?? 0, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <div class="mb-3">
                                <i class="ti ti-shopping-cart-off" style="font-size: 40px"></i>
                            </div>
                            <h3>Belum Ada Transaksi Buku</h3>
                            <p class="text-secondary mb-0">
                                Riwayat pembelian buku kamu akan muncul di sini.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const transactionType = document.getElementById('transactionType');
        const subscriptionTransactions = document.getElementById('subscriptionTransactions');
        const bookTransactions = document.getElementById('bookTransactions');

        transactionType.addEventListener('change', function () {
            subscriptionTransactions.style.display =
                this.value === 'subscription' ? 'block' : 'none';

            bookTransactions.style.display =
                this.value === 'book' ? 'block' : 'none';
        });
    });
</script>
@endsection
```
