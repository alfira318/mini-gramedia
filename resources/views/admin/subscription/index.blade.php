@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Paket Langganan</h2>

            <a href="{{ route('admin.subscription.create') }}" class="btn btn-primary">
                Tambah Paket Langganan
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-responsive bg-white">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th>Warna</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($subscriptions as $subscription)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $subscription->name }}</td>

                                <td>
                                    Rp {{ number_format($subscription->price, 0, ',', '.') }}
                                </td>

                                <td>{{ $subscription->description }}</td>

                                <td>
                                    <div
                                        style="
                                            width: 40px;
                                            height: 30px;
                                            background-color: {{ $subscription->color }};
                                            border: 1px solid #ccc;
                                            border-radius: 5px;
                                        "
                                    ></div>
                                </td>

                                <td>
                                    <a
                                        href="{{ route('admin.subscription.edit', $subscription->id) }}"
                                        class="btn btn-sm btn-warning"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.subscription.destroy', $subscription->id) }}"
                                        method="POST"
                                        class="d-inline"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus paket ini?')"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
