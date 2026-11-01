@extends('layout.app')


@section('content')
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between">
            <h2>Data buku yang akan dipilih untuk paket langganan</h2><b>{{ $subscriptionPackage->name }}</b></h2>
        </div>
        <div class="mt-3">
            <form action="{{ route('admin.subscription.books.store', $subscriptionPackage->id) }}" method="POST"
                id="addBookForm">
                @csrf
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-item-center">
                        <span class="fw-bold">Daftar Buku</span>
                        <button type="submit" id="btnSubmitBooks" class="btn btn-primary d-none">
                            <i class="fas fa-plus me-1"></i>Tambah Ke Paket Langganan(<span id="selectedCount">0</span>)
                        </button>
                    </div>
                    <div class="card-body">
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
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
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
                columns: [{
                        // yang dikirimkan ketika ngeceklis buku itu id nya karena yg diperlukan
                        // subscritionPackage_book table itu subscription_package_id dan book_id
                        data: 'id',
                        name: 'id',
                        searchable: false,
                        orderable: false,
                        // sama kaya editColumn di server side, ini untuk bikin checkbox di kolom pertama
                        render: function(data, type, row) {
                            if (row.checkAdded === 'Ya') {
                                return '';
                            }
                            return `<input type="checkbox" value="${row['id']}" name="book_ids[]" class="book-checkbox">`;
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

            // fungsi untuk mengecek status centang & toggle tombol submit
            function updateButtonVisibility() {
                const checkedCount = $('.book-checkbox:checked').length;
                $('#selectedCount').text(checkedCount);

                if (checkedCount > 0) {
                    $('#btnSubmitBooks').removeClass('d-none');
                } else {
                    $('#btnSubmitBooks').addClass('d-none');
                }
            }
            $('#data-buku tbody').on('change', '.book-checkbox', function() {
                updateButtonVisibility();
            });

            $('#data-buku').on('draw.dt', function() {
                updateButtonVisibility();
            });

        })
    </script>
@endpush
