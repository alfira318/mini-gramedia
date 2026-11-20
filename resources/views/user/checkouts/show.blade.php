@extends('layout.app')

@section('content')
 <div class="container my-5">
    <div class="card mx-auto mt-5" style="max-width: 420px;">
        <div class="card-body">
            <h3 class="text-center">{{ $checkout->order_code }}</h3>
            <p class="text-secondary text-center">{{ \Carbon\Carbon::parse($checkout->created_at)->format('d F Y') }}</p>

            <hr>

            @foreach ($checkout->checkoutBooks as $item)
                <div class="d-flex justify-content-between mt-2">
                    <p>{{ $item->book?->title ?? 'Item checkout' }}</p>
                    <p>Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                </div>
            @endforeach

            <hr>
            <div class="d-flex justify-content-between">
                <h3>Total</h3>
                <h3>Rp {{ number_format($checkout->total_price, 0, ',', '.') }}</h3>
            </div>

            @if ($checkout->status === "pending")
                <button class="btn btn-primary" id="pay-button">Pay Now</button>
            @else
                <p class="alert alert-info">Payment sudah dilakukan</p>
            @endif
            <a href="{{ route('checkouts.struk', $checkout->id) }}" class="btn btn-secondary btn-block">Unduh (.PDF)</a>
        </div>
    </div>
 </div>
 @endsection

 @push('scripts')
    @if ($snapToken)
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            const payButton = document.querySelector('#pay-button');
            const paymentFeedback = document.querySelector('#payment-feedback');

            const showPaymentFeedback = (message, type = 'info') => {
                paymentFeedback.textContent = message;
                paymentFeedback.className = `alert alert-${type} mt-3`;
            };

            if (payButton) {
                payButton.addEventListener('click', function(event) {
                    event.preventDefault();

                    if (!window.snap) {
                        showPaymentFeedback('Layanan pembayaran gagal dimuat. Muat ulang halaman dan coba lagi.', 'danger');
                        return;
                    }

                    window.snap.pay(@json($snapToken), {
                        onSuccess: function(result) {
                           window.location.reload();
                        },
                        onPending: function() {
                            showPaymentFeedback('Selesaikan pembayaran melalui metode yang dipilih, termasuk memindai QR jika memilih QRIS.');
                        },
                        onError: function() {
                            showPaymentFeedback('Pembayaran gagal diproses. Silakan coba lagi atau pilih metode pembayaran lain.', 'danger');
                        }
                    });
                });
            }
        </script>
    @endif
 @endpush
