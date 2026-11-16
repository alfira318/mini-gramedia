@extends('layout.app')

@section('content')
    <div class="container my-4">
        <h2 class="fw-bold mb-4">Keranjang Belanja</h2>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">Tutup</button>
            </div>
        @endif
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border rounded-3 p-3 mb-3 shadow-sm">
                    <div class="form-check d-flex align-items-center">
                        <label class="form-check-label fw-medium" for="check-all">
                            <span id="cart-count">{{ $carts->count() }}</span>
                            Buku Terpilih
                        </label>
                    </div>
                </div>

                {{-- list yg dimasukkan ke keranjang --}}
                @forelse ($carts as $cart )
                    <div class="card border rounded-3 p-3 mb-3 shadow-sm position-relative">
                        <div class="d-flex align-items-center">
                            {{-- checkbox item --}}
                        <div class="form-check me-3">
                            <input class="form-check-input item-checkbox" type="checkbox" name="selected_carts[]"
                            value="{{ $cart->id }}" checked>
                        </div>

                        {{-- gambar buku --}}
                        <div class="flex-shrink-0 me-3">
                            <img src="{{ $cart->book->cover ?? '' }}" alt="{{ $cart->book->title ?? 'Tanpa Buku' }}" class="rounded"
                            style="width: 70px; height: 100px; object-fit: cover;">
                        </div>

                        <div class="flex-grow-1">
                            <div class="text-muted small">
                                {{ $cart->book->writer ?? 'Penulis Tidak di ketahui' }}
                            </div>
                            <h4 class="fw-bold mb-0 text-dark">
                                {{ $cart->book->title ?? 'Judul Buku' }}
                            </h4>
                        </div>

                        @php
                            $price = $cart->subscriptionPackage ? $cart->subscriptionPackage->price
                            : $cart->book->price;
                        @endphp

                        <div class="text-end d-flex flex-column align-items-end justify-content-between style-price-container"
                        style="height: 100px">

                        <div>
                            <h4 class="fw-bold mb-0">Rp {{ number_format($price, 0, ',', '.') }}</h4>
                            <div class="small">
                                @if ($cart->subscriptionPackage)
                                    <span class="badge bg-green text-green-fg">
                                        {{ $cart->subscriptionPackage->name }}
                                    </span>
                                @else
                                    <span class="badge bg-azure text-azure-fg">
                                        Medium
                                    </span>
                                @endif
                            </div>
                        </div>

                        <form action="{{ route('carts.destroy', $cart->id) }}" method="POST"
                            onsubmit="return confirm('Hapus item ini dari keranjang?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" title="Hapus">
                                Hapus
                            </button>
                        </form>
                      </div>
                     </div>
                    </div>

                @empty
                    <div class="card p-5 text-center text-muted border rounded-3">
                        <p class="mb-0">Keranjang Anda kosong.</p>
                    </div>
                @endforelse
            </div>

        <div class="col-lg-4">
            <div class="card border rounded-4 p-4 shadow-sm position-sticky" style="top: 20px">
                <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                <div class="d-flex justify-content-between mb-3 text-muted">
                    <span>Total Belanja (<span id="total-selected-count">0</span> Buku)
                </span>
                <span class="text-dark fw-medium" id="total-selected-text">Rp 0</span>
        </div>
        <hr class="my-3">
        <div class="d-flex justify-content-between mb-3 text-muted">
            <span>Total Belanja</span>
            <h3 class="text-dark" id="discount-text">Rp 0</h3>
        </div>

        <form method="GET" id="form-checkout">
            <div id="checkout-inputs"></div>
            <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-pill fw-semibold" id="btn-checkout">
                Checkout
            </button>
        </form>
    </div>
     </div>
@endsection
