<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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

                ->rawColumns(['covering', 'action'])
                ->toJson();
        }
        return view('admin.books.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $BookCategories = BookCategory::all();
        return view('admin.books.create', compact('BookCategories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'cover' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048'
            ],
            'title' =>
            [
                'required',
            ],
            'writer' =>
            [
                'required',
            ],
            'publisher' =>
            [
                'required',
            ],
            'price' =>
            [
                'required',
                'numeric',
            ],
            'description' =>
            [
                'required',
                'string',
            ],
            'language' =>
            [
                'required',
            ],
            'book_category_id' =>
            [
                'required',
                'exists:book_categories,id',
            ],
            'release_date' =>
            [
                'required',
                'date',
            ],
            'page_of_book' =>
            [
                'required',
                'numeric',
            ],
        ]);


        // kalau input file cover ada file nya aka proses simpen file ke storage
        if ($request->file('cover')) {
            $cover = $request->file('cover');
            // bikin nama file dari waktu gambar di upload disambungkan "." ekstensi file : 1234.jp (contoh hasil nama file)
            $nameFile = time() . '.' . $cover->getClientOriginalExtension();
            // disk : menyimpan strorage (nanti diganti ke layanan cloud setealah di hosting)
            // putFiles : ('nama_folder', file_yang_disimpan, 'nama_file')
            Storage::disk('public')->putFileAs('book_covers', $cover, $nameFile);
            // ambil alamat gambar untuk disimpan di database, timpa data cover yang sudah divalidasi
            $validatedData['cover'] = Storage::url('book_covers/' . $nameFile);
        };


        //simpan data ke model book, data yang disimpan data data dari hasil validasi
        Book::create($validatedData);
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan');

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
    $book = Book::findOrFail($id);
    $BookCategories = BookCategory::all();

    return view('admin.books.edit', compact('book', 'BookCategories'));
}

public function update(Request $request, string $id)
{
    $book = Book::findOrFail($id);

    $validatedData = $request->validate([
        'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        'title' => ['required'],
        'writer' => ['required'],
        'publisher' => ['required'],
        'price' => ['required', 'numeric'],
        'description' => ['required', 'string'],
        'language' => ['required'],
        'book_category_id' => ['required', 'exists:book_categories,id'],
        'release_date' => ['required', 'date'],
        'page_of_book' => ['required', 'numeric'],
    ]);

    if ($request->hasFile('cover')) {
        $cover = $request->file('cover');
        $nameFile = time() . '.' . $cover->getClientOriginalExtension();

        Storage::disk('public')->putFileAs('book_covers', $cover, $nameFile);

        $validatedData['cover'] = Storage::url('book_covers/' . $nameFile);
    } else {
        unset($validatedData['cover']);
    }

    $book->update($validatedData);

    return redirect()->route('admin.books.index')
        ->with('success', 'Buku berhasil diperbarui');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus');
    }
}
