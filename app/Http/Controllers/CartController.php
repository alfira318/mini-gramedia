<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubscriptionPackageUser;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(Cart::all());
        $userId = Auth::id();
        $carts = Cart::with('book', 'subscriptionPackage')->where('user_id', $userId)->get();

        // paket langganan aktif milik pengguna
        $activePackageIds = SubscriptionPackageUser::where('user_id', $userId)
        ->whereDate('expired_date', '>', today())
        ->pluck('subscription_package_id');

        // paket di keranjang yg belum dibeli pengguna
        $packageUserNotBought = $carts
        ->whereNotNull('subscription_id')
        ->pluck('subscription_id')
        ->unique()
        ->diff($activePackageIds)
        ->values();

        // menambahkan attribute baru ke data $cart
        $carts->each(function ($cart) use ($packageUserNotBought) {
            $cart->display_price = $cart->subscriptionPackage ? $cart->subscriptionPackage->price : $cart->book->price;

            $cart->needs_package = $packageUserNotBought->contains($cart->subscription_id);
        });

        $totalPrice = $carts->sum('display_price');

        return view('user.carts.index', compact('carts', 'totalPrice'));
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
        // debugging: lihat data sebelum diproses, sama ky console.log di js
        // dd($request->all());
        $request->validate([
            // memastikan pilihan harga udah di klik dulu
            'purchase_option' => 'required',
        ]);

        if($request->action === 'add_to_cart') {
        //    menentukan isi field subscrtiption_package_id
        $packageId = $request->purchase_option === 'none' ? null : $request->purchase_option;
        // updateOrCreate: jika pengguna ini udah pernah masukin buku ini (user_id dan book_id yg dijadikan acuan cari data di databasenya),
        // maka update pilihan pembayarannya (subscrtiption_package_id). Kalau belum ada, maka buat data baru
        // updateOrCreate(['cari data berdasarkan apa], ['update field apa saja'])
        Cart::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'book_id' => $request->book_id,
            ],
            [
                'subscription_id' => $packageId,
            ]);
            return redirect()->route('carts')->with('success', 'Buku berhasil ditambahkan ke keranjang');
        } else {
            // proses ke checkout langsung
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        cart::where('id', $id)->where('user_id', Auth::id())->delete();
        return redirect()->route('carts')->with('success', 'Buku berhasil dihapus dari keranjang');
    }
}
