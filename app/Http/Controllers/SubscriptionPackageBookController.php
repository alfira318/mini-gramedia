<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPackage;
use App\Models\Book;
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



                ->editColumn('action', function($row){
                    $btnDetail = '<button type="button" class="btn btn-info w-100 mb-2"
                    data-cover="' . asset($row->cover) . '"
                    data-title="' . e($row->title) . '"
                     data-writer="' . e($row->writer) . '"
                    data-publisher="' . e($row->publisher) . '"
                    data-price="' . e('Rp. ' . number_format($row->price, 0, ',', '.')) . '"
                    data-description="' . e($row->description) . '"
                    data-language="' . e($row->language) . '"
                    data-category="' . e($row->bookCategory->name) . '"
                    data-release_date="' . e(date('d-m-Y', strtotime($row->release_date))) . '"
                    data-page_of_book="' . e($row->page_of_book) . '">Detail</button>';


                    $btnEdit = '<a href="' . route('admin.books.edit', $row->id) . '"
                    class="btn btn-primary w-100 mb-2">edit buku </a>';

                    $btnDelete =
                    '<form action="' . route('admin.books.destroy', $row->id) . '" method="POST" class="d-block w-100 m-0" onsubmit="return confirm(\'Apakah kamu yakin ingin menghapus buku ini?\')">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger w-100">hapus buku</button>
                    </form>';

                    return '<div class="d-flex flex-column">' . $btnDetail . $btnEdit . $btnDelete . '</div>';
                })
                ->rawColumns(['covering'])
                ->toJson();
        }
        return view('admin.subscription.books', compact('subscriptionPackage'));
    }
}
