@extends('layout.app')


@section('content')
    <h1>Create Book</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data"
        class="card w-75 d-block mx-auto">
        <div class="card-header">
            <h3 class="card-title">Tambah Buku</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-6">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="book_category_id" id="category_id" class="form-select">
                        <option disabled hidden selected>Select Category</option>
                        {{-- di bagian ini ada book $BookCategories di sesuaikan dengan nama variable yang ada di controller coba lu --}}
                        @foreach ($BookCategories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('book_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-6">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="row mb-3">
                    <div class="col-6">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" name="price" id="price" class="form-control"
                            value="{{ old('price') }}">
                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="publisher" class="form-label">Publisher</label>
                        <input type="text" name="publisher" id="publisher" class="form-control"
                            value="{{ old('publisher') }}">
                        @error('publisher')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="writer" class="form-label">Writer</label>
                        <input type="text" name="writer" id="writer" class="form-control"
                            value="{{ old('writer') }}">
                        @error('writer')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="language" class="form-label">Language</label>
                        <select name="language" id="language" class="form-select">
                            <option disabled hidden selected>Select Language</option>
                            <option value="english" {{ old('language') == 'english' ? 'selected' : '' }}>English</option>
                            <option value="indonesian" {{ old('language') == 'indonesian' ? 'selected' : '' }}>Indonesian
                            </option>
                            <option value="spanish" {{ old('language') == 'spanish' ? 'selected' : '' }}>Spanish</option>
                            <option value="arabic" {{ old('language') == 'arabic' ? 'selected' : '' }}>Arabic</option>
                        </select>
                        @error('language')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="release_date" class="form-label">Tanggal</label>
                                <input type="date" name="release_date" id="release_date" class="form-control">
                                @error('release_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="page_of_book" class="form-label">Jumlah Halaman</label>
                                <input type="number" name="page_of_book" id="page_of_book" class="form-control">
                                @error('page_of_book')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="cover" class="form-label">Sampul Buku</label>
                            <input type="file" name="cover" id="cover" class="form-control">
                            @error('cover')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <input type="hidden" name="description" id="description_input"
                                value="{{ old('description') }}">
                            <div id="editor" style="height: 200px;">{!! old('description') !!}</div>
                            @error('description')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary w-10">Simpan Buku</button>
                    </div>


                </div>
            </div>
    </form>
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
