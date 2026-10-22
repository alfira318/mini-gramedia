@extends('layout.app')


@section('content')
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <h2>Data buku yang akan dipilih untuk paket langganan</h2><b>{{ $subscriptionPackage->name }}</b></h2>
            <form action="{{ route('admin.subscription.books.store', $subscriptionPackage->id) }}" id="addBookForm">
                @csrf
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Daftar Buku</span>
                    <input type="hidden" name="book_ids" id="bookIdsInput" value="">
                    <button type="submit" id="btnSubmitBook" class="btn btn-primary d-none"
                    <i class="fas fa-plus me-1"></i> Tambah ke Paket Langganan (<span id="selectedCount">0</span>)
                </button>
                </div>
              </div>
            </form>

        </div>
        <table class="table table-bordered mt-3" id="data-buku">
            <thead>
                <tr>
                    {{-- untuk checkbox --}}
                    <th></th>
                    <th>#</th>
                    <th>Sampul buku</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Harga</th>
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
                ajax: "{{ route('admin.subscription.books', $subscriptionPackage->id) }}",
                columns: [
                    {
                        // yang dikirimkan ketika ngeceklis buku itu id nya karena yg diperlukan
                        // subscritionPackage_book table itu subscription_package_id dan book_id
                        data: 'id',
                        name: 'id',
                        searchable: false,
                        orderable: false,
                        // sama kaya editColumn di server side, ini untuk bikin checkbox di kolom pertama
                        render: function(data) {
                            // (data) isinya dari dta:id
                            // nama pake [] karena yg diceklis bisa lebih dari satu, jadi nanti di controller bakal dapat array book_id
                            return '<input type="checkbox" value="$(data)" name="book_id[]" class="book-checkbox">';
                            // class books-checkbox ditambahkan untuk mendeteksi jumlah checkboc yg diceklis nantinya
                        }
                    },
                    {
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

                ]
            });

        });
    </script>
@endpush
