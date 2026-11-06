<?php

namespace App\Http\Controllers;

use App\Exports\SubscriptionPackagesExport;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use App\Models\SubscriptionPackageBook;
use Illuminate\Support\Facades\Auth;
use App\Models\SubscriptionPackageUser;
use App\Models\Book;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$request->ajax jika ada permintaan dari ajax js, permintaan proses datatbels dipanggil maemlalu ajax js di bladenya
       if ($request->ajax()){
        $model = SubscriptionPackage::query();

         return DataTables::eloquent($model)
        //memberi nomor urut 123
        ->addIndexColumn()
        //menambah data selain yang ada di databese : mengubah data atau untuk btn aksi
        ->addColumn('action', function($data){
            $editUrl = route('admin.subscription.edit', $data->id);
            $deleteUrl = route('admin.subscription.destroy', $data->id);
            $books = route('admin.subscription.books', $data->id);

            $csrf = csrf_field();
            $method = method_field('DELETE');
            $btnEdit =  '<a href="'. $editUrl .'"class="btn btn-warning btn-sm">Edit</a>';
           $btnDelete = '<form action="' . $deleteUrl . '" method="post" class="d-inline" onsubmit="return confirm(\'Apakah anda yakin menghapus?\')">
                ' . $csrf . '
                ' . $method . '
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>';

            $btnBooks = '<a href="' . $books . '" class="btn btn-info btn-sm">Buku</a>';

return $btnEdit . $btnDelete . $btnBooks;
        })
         //menyimpan dari addcolumn yg ada di html didalamnya
        ->rawColumns(['action'])
        ->toJson();
       }

        return view('admin.subscription.index');
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

    public function detail(Request $request, $id)
{
    $subscriptionPackage = SubscriptionPackage::findOrFail($id);

    $bookIds = SubscriptionPackageBook::where(
        'subscription_package_id',
        $subscriptionPackage->id
    )->pluck('book_id');

    $query = $request->input('q', '');

    $books = Book::whereIn('id', $bookIds)
        ->when($query !== '', function ($builder) use ($query) {
            $builder->where('title', 'like', '%' . $query . '%');
        })
        ->with('bookCategory')
        ->paginate(8)
        ->withQueryString();

    return view('user.subscription-package.subscription', compact(
        'subscriptionPackage',
        'books',
        'query'
    ));
}
    public function indexUser()
{
    $packages = SubscriptionPackage::all();

    return view('subscription', compact('packages'));
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

    public function checkoutPage($id)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);

        return view('user.subscription-package.checkout', compact('subscriptionPackage'));
    }

    public function checkout($id)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($id);

        SubscriptionPackageUser::create([
             'subscription_package_id' => $subscriptionPackage->id,
            'user_id' => Auth::id(),
            // ambil id org yg login, mendeteksi siapa user yg belinya 30 hari dari sekarang, format tahun-bulan-tanggal
            'expired_date' => now()->addDays(30)->format('Y-m-d'),
        ]);
        return redirect()->route('home')->with('success', 'Pembayaran berhasil. Terima kasih telah berlangganan!');
    }

    public function export()
{
    return Excel::download(new SubscriptionPackagesExport, 'data-paket-langganan.xlsx');
}
}
