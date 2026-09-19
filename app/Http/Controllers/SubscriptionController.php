<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $subscriptions = SubscriptionPackage::all();

        return view('admin.subscription.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
          return view('admin.subscription.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validateData = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'price' => ['required', 'numeric'],
        'description' => ['required', 'string'],
        'color' => ['required', 'string'],
    ]);

    SubscriptionPackage::create($validateData);

    return redirect()->route('admin.subscription.index')
        ->with('success', 'Paket langganan berhasil ditambahkan');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // findOrFail: mencari data berdasarkan id, jika tidak ditemukan akan menampilkan error 404
        // atau bisa gunakan find() utk mencari data berdasarkan id, jika tidak ditemukan akan
        // mengambil null
        $subscriptions = SubscriptionPackage::findOrFail($id);
        return view('admin.subscription.edit', compact('subscriptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
           $subscriptions = SubscriptionPackage::findOrFail($id);

        $validateData = $request->validate([
             'name' => ['required', 'string', 'max:255'],
        ]);

        $subscriptions->update($validateData);
        // update digynakan pd model utk mengambil data, namun penggunaannya harus setelah proses
        // pencarian data yg akan di ubahnya

        return redirect()->route('admin.subscription.index')->with('success', 'Kategori buku telah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $subscriptions = SubscriptionPackage::findOrFail($id);

        $subscriptions->delete();
        return redirect()->route('admin.subscription.index')->with('success', 'kategori buku telah berhasil dihapus');
    }
}
