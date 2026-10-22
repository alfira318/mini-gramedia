@extends('layout.app')

@section('content')
<div class="container-xl py-4">
    <h2 class="mb-4">Kategori: {{ $category->name }}</h2>

    <form action="{{ route('category.show', $category->id) }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-6">
            <input
                type="text"
                name="q"
                class="form-control"
                placeholder="Cari judul atau penulis..."
                value="{{ request('q') }}"
            >
        </div>

        <div class="col-md-4">
            <select name="sort" class="form-select">
                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Buku terbaru</option>
                <option value="cheapest" {{ request('sort') == 'cheapest' ? 'selected' : '' }}>Harga termurah</option>
                <option value="expensive" {{ request('sort') == 'expensive' ? 'selected' : '' }}>Harga termahal</option>
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Cari</button>
        </div>
    </form>

    <div class="row g-3">
        @forelse ($books as $book)
            <div class="col-6 col-md-3">
                <div class="card h-100">
                    @if ($book->cover)
                        <img
                            src="{{ asset($book->cover) }}"
                            class="card-img-top"
                            alt="{{ $book->title }}"
                            style="height: 220px; object-fit: cover;"
                        >
                    @endif

                    <div class="card-body">
                        <h3 class="h4">{{ $book->title }}</h3>
                        <p>{{ $book->writer }}</p>
                        <p>Rp{{ number_format($book->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p>Belum ada buku dalam kategori ini.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $books->links() }}
    </div>
</div>
@endsection
