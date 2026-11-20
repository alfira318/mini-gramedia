<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Checkout;
use App\Models\CheckoutBook;
use App\Service\Midtrans\CreateSnapTokenService;
use App\Service\Midtrans\CallbackService;
use Barryvdh\DomPDF\Facade\Pdf;


class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.3
     *
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'selected_carts' => ['required', 'array', 'min:1'],
            'selected_carts.*' => ['required', 'exists:carts,id']
        ]);

        $cartItems = Cart::whereIn('id', $request->selected_carts)
            ->with(['book', 'subscriptionPackage'])
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Data keranjang kosong!');
        }

        $prices = $cartItems->mapWithKeys(fn ($row) => [
            $row->id => $row->subscription_id === null ? $row->book->price : $row->subscriptionPackage->price
        ]);

        $totalPrice = $prices->sum();

        // mulai proses transaksi database
        DB::beginTransaction();
        try {
        // 1. buat data checkout
        $checkout = Checkout::create([
            'user_id' => Auth::id(),
            'payment_method' => 'Midtrans',
            'total_price' => $totalPrice,
            'status' => 'pending',
            'order_code' => 'ORD-' . now()->format('ymd') . '.' . strtolower(Str::random(4)),
            'total_book_price' => $totalPrice,
            'total_book' => $cartItems->count(),
        ]);
        // 2. bikin data checkout books sesuai dengan jumlah buku yan dpilih di keranjang
        foreach ($cartItems as $cart) {
            CheckoutBook::create([
                'checkout_id' => $checkout->id,
                'book_id' => $cart->book_id,
                'subscription_package_id' => $cart->subscription_id,
                // cart dari $prices yg diatas, cari harga sesuai id item yg di loop, isi prices
                // [1 => 9000, 2 => 10000, 3 => 15000] dst. kalau di loop ini id nya 2 maka ambil harga dari prices[2] = 10000
                'price' => $prices[$cart->id],
            ]);
        }
        // 3. hapus data cart yg sudah di checkout
        $cartIds = $cartItems->pluck('id');
        Cart::whereIn('id', $cartIds)->where('user_id', Auth::id())->delete();

        // simpan/ sahkan semua perubahan jika tidak ada error
        DB::commit();
    } catch (\Throwable $th) {
            // jika ada error, rollback semua perubahan
            DB::rollBack();
        report($th);
        // dd($th); -> kalau ada error langsung tampilkan errornya di browser
        return redirect()->back()->with('error', 'Terjadi kesalahan saat checkout. Silakan coba lagi.');

        }
            return redirect()->route('checkouts.show', $checkout->id);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $checkout = Checkout::where('user_id', Auth::id())->findOrFail($id);
        $snapToken = $checkout->snap_token;

        if (is_null($snapToken)) {
            $midtrans = new CreateSnapTokenService($checkout);
            $snapToken = $midtrans->getSnapToken();
            $checkout->snap_token = $snapToken;
            $checkout->save();
        }

        return view('user.checkouts.show', compact('checkout', 'snapToken'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function receive()
    {
        $callback = new CallbackService;

        if ($callback->isSignatureKeyVerified()) {
            $checkout = $callback->getCheckout();

            if ($callback->isSuccess()) {
                Checkout::where('id', $checkout->id)->update([
                    'status' => 'paid',
                    'paid_date' => now(),
                    'payment_method' => $callback->getPaymentType()
                ]);
            }

            if ($callback->isExpire()) {
                Checkout::where('id', $checkout->id)->update([
                    'status' => 'expired',
                ]);
            }

            if ($callback->isCancelled()) {
                Checkout::where('id', $checkout->id)->update([
                    'status' => 'cancelled',
                ]);
            }

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notification successfully processed',
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key not verified',
                ], 403);
        }
    }

    public function struk(string $id)
    {
        $checkout = Checkout::where('user_id', Auth::id())
            ->with(['checkoutBooks', 'checkoutBooks.book'])
            ->findOrFail($id);
        $pdf = Pdf::loadView('user.checkouts.pdf', compact('checkout'));

        return $pdf->download($checkout['order_code'] . '.pdf');
    }
}
