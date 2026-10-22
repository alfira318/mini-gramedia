@extends('layout.app')
@section('content')
    <div class="container mt-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data"
            class="card w-75 d-block mx-auto">
            @csrf
            @method('PUT')
            <div class="card-header">
                <h3 class="card-title">Edit Buku</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="book_category_id" id="category_id" class="form-select">
                            <option disabled hidden>Select Category</option>
                            @foreach ($BookCategories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('book_category_id', $book->book_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('book_category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ old('title', $book->title) }}">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col-6">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" name="price" id="price" class="form-control"
                            value="{{ old('price', $book->price) }}">
                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="publisher" class="form-label">Publisher</label>
                        <input type="text" name="publisher" id="publisher" class="form-control"
                            value="{{ old('publisher', $book->publisher) }}">
                        @error('publisher')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="writer" class="form-label">Writer</label>
                        <input type="text" name="writer" id="writer" class="form-control"
                            value="{{ old('writer', $book->writer) }}">
                        @error('writer')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="language" class="form-label">Language</label>
                        <select name="language" id="language" class="form-select">
                            <option disabled hidden>Select Language</option>
                            <option value="english" {{ old('language', $book->language) == 'english' ? 'selected' : '' }}>
                                English</option>
                            <option value="indonesian"
                                {{ old('language', $book->language) == 'indonesian' ? 'selected' : '' }}>Indonesian
                            </option>
                            <option value="spanish" {{ old('language', $book->language) == 'spanish' ? 'selected' : '' }}>
                                Spanish</option>
                            <option value="arabic" {{ old('language', $book->language) == 'arabic' ? 'selected' : '' }}>
                                Arabic</option>
                        </select>
                        @error('language')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col-6">
                        <label for="release_date" class="form-label">Tanggal Rilis</label>
                        <input type="date" name="release_date" id="release_date" class="form-control"
                            value="{{ old('release_date', $book->release_date) }}">
                        @error('release_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="page_of_book" class="form-label">Jumlah Halaman</label>
                        <input type="number" name="page_of_book" id="page_of_book" class="form-control"
                            value="{{ old('page_of_book', $book->page_of_book) }}">
                        @error('page_of_book')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="cover" class="form-label">Sampul Buku (Kosongkan jika tidak diubah)</label>
                        <input type="file" name="cover" id="cover" class="form-control">
                        @if ($book->cover)
                            <div class="mt-2">
                                <img src="{{ asset($book->cover) }}" alt="cover" width="100">
                            </div>
                        @endif
                        @error('cover')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <input type="hidden" name="description" id="description_input"
                            value="{{ old('description', $book->description) }}">
                        <div id="editor" style="height: 200px;">{!! old('description', $book->description) !!}</div>
                        @error('description')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="mt-3">
                    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary w-10">Kembali</a>
                    <button type="submit" class="btn btn-primary w-10">Update Buku</button>
                </div>
            </div>
        </form>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const quill = new Quill('#editor', {
                theme: 'snow'
            });
            const descriptionInput = document.querySelector('#description_input');


            // Update the hidden input every time the text changes
            quill.on('text-change', function() {
                if (quill.getText().trim().length === 0) {
                    descriptionInput.value = '';
                } else {
                    descriptionInput.value = quill.root.innerHTML;
                }
            });

            document.querySelector('form').addEventListener('submit', function() {
                descriptionInput.value = quill.getText().trim().length === 0 ? '' : quill.root.innerHTML;
            });
        });
    </script>
@endpush
