@extends('layout.app')


@section('content')
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Daftar Buku</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.books.export') }}" class="btn btn-success mb-3">Export Data</a>
                <a href="{{ route('admin.books.create') }}" class="btn btn-primary mb-3">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Buku
                </a>
            </div>
        </div>
        <table class="table table-bordered mt-3" id="data-buku">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Sampul buku</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>


    <div class="modal modal-blur fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Buku</h5><button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="" id="data-cover" class="img-fluid rounded" alt="cover">
                        </div>

                        <div class="col-md-8">

                            <h3 class="text-primary mb-1" id="data-title"></h3>
                            <span class="badge mb-4" id="data-category"></span>


                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="text-muted small">Harga</div>
                                    <div id="data-price" class="text-success fw-bold"></div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="text-muted small">Penulis</div>
                                    <div id="data-writer" class="fw-bold"></div>
                                </div>

                                <div class="col-6 mb-3">
                                    <div class="text-muted small">Penerbit</div>
                                    <div id="data-publisher" class="fw-bold"></div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="text-muted small">Bahasa</div>
                                    <div id="data-language" class="fw-bold"></div>
                                </div>

                                <div class="col-6 mb-3">
                                    <div class="text-muted small">Tanggal Rilis</div>
                                    <div id="data-release-date" class="fw-bold"></div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="text-muted small">Jumlah Halaman</div>
                                    <div id="data-page-of-book" class="fw-bold"></div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="text-muted small">deskripsi</div>
                                    <div id="data-description" class="fw-bold"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#data-buku').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.books.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'covering',
                        name: 'covering',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    //data : dari nama field/addcolumn/editcolumn di controller
                    //name : bookcategory.name : untuk search/sort carinya dari relasi bookcategory, field name
                    {
                        data: 'book_category_id',
                        name: 'bookCategory.name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            //proses menampilkan data di modal detail
            $('#data-buku').on('click', '.btn-info', function() {
                const btn = $(this);
                //ambil data atrribute data-tittle="" yg di kirim di datatable controller
                let title = btn.data('title');
                let category = btn.data('category');
                let price = btn.data('price');
                let publisher = btn.data('publisher');
                let releaseDate = btn.data('release_date');
                let writer = btn.data('writer');
                let pageOfBook = btn.data('page_of_book');
                let language = btn.data('language');


                //simpan data ke span yang di kosongkan
                $('#data-title').text(title);
                $('#data-category').text(category);
                $('#data-price').text(price);
                $('#data-publisher').text(publisher);
                $('#data-release-date').text(releaseDate);
                $('#data-writer').text(writer);
                $('#data-page-of-book').text(pageOfBook);
                $('#data-language').text(language);


                // isi src gambar di modal dengan data cover yang di kirim dari datatable controller
                let cover = btn.data('cover');
                $('#data-cover').attr('src', cover);
                // ada kesalahan dalam tampilan yang seharus nya tampilan di model itu seperti ini
                    //bintang (warna biru)
                     //kategori buku
//gambar
                     //Harga                         penulis
                    //(harganya warna hijau)         (penulis)

                    //penerbit                       bahasa
                    //(penerbitnya)                 //(bahasanya)


                    //tanggal liris                 jumlah halaman
                    //(tanggal lirisnya)            //(jumlah halamannya)


                //panggil modal dimunculkan
                $('#modal-detail').modal('show');
            });
        });
    </script>
@endpush
