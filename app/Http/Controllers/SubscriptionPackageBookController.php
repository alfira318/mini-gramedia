<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPackage;
use App\Models\Book;
use App\Models\SubscriptionPackageBook;
use Yajra\DataTables\Facades\DataTables;


class SubscriptionPackageBookController extends Controller
{
    public function show($subscriptionPackageId, Request $request)
    {
        $subscriptionPackage = SubscriptionPackage::findOrFail($subscriptionPackageId);
        // semua data buku untuk dipilih mana yg akan ditautkan ke paket langganan
                 if ($request->ajax()) {
            $model = Book::query();


            return DataTables::eloquent($model)
                ->addIndexColumn()
                //asset mengambil file yang ada di folder public
                ->addColumn(
                    'covering',
                    function ($row) {
                        return '<img src="' . asset($row->cover) . '" width="50" height="50" class="d-block mx-auto" alt="cover">';
                    }
                )

                ->editColumn('price', function ($row) {
                    return 'Rp. ' . number_format($row->price, 0, ',', '.');
                })


                ->editColumn('book_category_id', function ($row) {
                    return $row->bookCategory->name;
                })

                ->addColumn('checkAdded', function ($row) use ($subscriptionPackage) {
                    $subscriptionPackageBook = $subscriptionPackage->subscriptionPackageBooks()->pluck('book_id')->toArray();
                    return in_array($row->id, $subscriptionPackageBook) ? 'Ya' : 'Tidak';
                })

                ->rawColumns(['covering', 'checkAdded'])
                ->toJson();
        }
        return view('admin.subscription.books', compact('subscriptionPackage'));
    }

    public function store(Request $request, $id) {
        $bookIds = $request->book_ids;
        foreach ($bookIds as $bookId) {
            SubscriptionPackageBook::create([
                'subscription_package_id' => $id,
                'book_id' => $bookId,
            ]);
        }
        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke paket langganan');
    }
}
