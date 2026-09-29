@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Kategori Buku</h2>
        <a href="{{ route('admin.subscription.create') }}" class="btn btn-primary">Tambah Kategori Buku</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
    <table id="subscription-table" class="table table-bordered table-responsive bg-white">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Paket Langganan</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Warna</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $("#subscription-table").DataTable({
            // menampilkan ikon loading
            processing:true,
            // menggunakan server side (data  diproses di controller)
            serverSide:true,
            // routing yg memproses databases
            ajax: "{{ route('admin.subscription.index') }}",
            // isi td dari table nya
          columns: [
    {
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        orderable: false,
        searchable: false
    },
    {
        data: 'name',
        name: 'name',
        orderable: true,
        searchable: true
    },
    {
        data: 'price',
        name: 'price',
        orderable: true,
        searchable: true
    },
    {
        data: 'description',
        name: 'description',
        orderable: true,
        searchable: true
    },
    {
        data: 'color',
        name: 'color',
        orderable: true,
        searchable: true
    },
    {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
    }
]
        })
    })
</script>
