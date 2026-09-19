@extends('layout.app')
@section('content')
    <div class="card mt-5 w-50 mx-auto">
        <div class="card-header">
            <h1>Edit Kategori Buku</h1>
        </div>

        <div class="card-body">
            <form action="{{ route("admin.subscription.update", $subscriptions->id) }}" method="POST"
            @csrf
            {{-- override method  : mengganti method="POST" menjadi PUT sesuai dengan HTTP method yg ada di route nya --}}
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                {{-- old('name', $subscription->name) : jika ada error validasi, tampilkan nilai sebelumnya pd inputan ini,
                jika tidak ada, tampilkan nilai dari $subscription->name --}}
                <input type="text" name="name" id="name"
                class="form-control @error('name') is-invalid
                @enderror"
                value="{{ old('name', $subscriptions->name) }}" required>

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
