@extends('layout.app')

@push('styles')

{{-- Slick Carousel CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">

<style>
    /* Tombol slider */
    .slick-prev::before,
    .slick-next::before {
        color: #333;
    }

    .slick-prev {
        left: -25px;
        z-index: 10;
    }

    .slick-next {
        right: -25px;
        z-index: 10;
    }

    /* Jarak antar card */
    #wrapper-slide .slick-slide {
        padding: 0 8px;
    }

    /* Supaya card memiliki tinggi yang sama */
    #wrapper-slide .card {
        height: 100%;
    }

    /* Slider tidak keluar container */
    #wrapper-slide {
        margin: 0 20px;
    }
</style>

@endpush

@section('content')

{{-- ================= CONTENT ================= --}}
<div class="container py-4">
    @if (@session('success'))
        <div class="alert alert-important alert-success alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M5 12l5 5l10 -10"></path>
                </svg>
                </div>
                <div>{{ Session::get('success') }}</div>
            </div>
            <a class="btn-close btn-close-white" data-bs-dismiss="alert"
                aria-label="close"></a>
        </div>
    @endif
    @if (Session::get('error'))
        <div class="alert alert-important alert-danger alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M5 1215 5110 -10"></path>
                    </svg>
                </div>
                <div>{{ Session :: get('error') }}</div>
            </div>
            <a class="btn-close btn-close-white" data-bs-dismiss="alert"
                 aria-label="close"></a>

        </div>
    @endif


    {{-- ================= BANNER ================= --}}
    <div
        id="carousel-sample"
        class="carousel slide rounded-3 overflow-hidden"
        data-bs-ride="carousel"
    >

        <div class="carousel-indicators">

            <button
                type="button"
                data-bs-target="#carousel-sample"
                data-bs-slide-to="0"
                class="active"
            ></button>

            <button
                type="button"
                data-bs-target="#carousel-sample"
                data-bs-slide-to="1"
            ></button>

            <button
                type="button"
                data-bs-target="#carousel-sample"
                data-bs-slide-to="2"
            ></button>

            <button
                type="button"
                data-bs-target="#carousel-sample"
                data-bs-slide-to="3"
            ></button>

            <button
                type="button"
                data-bs-target="#carousel-sample"
                data-bs-slide-to="4"
            ></button>

        </div>


        <div class="carousel-inner">

            <div class="carousel-item active">
                <img
                    class="d-block w-100"
                    alt=""
                    src="https://img.magnific.com/free-vector/hand-drawn-literature-twitter-header_23-2149721049.jpg?semt=ais_hybrid&w=740&q=80"
                >
            </div>

            <div class="carousel-item">
                <img
                    class="d-block w-100"
                    alt=""
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSQCG13QYeTEF9zM6kOh7vt8LR45eMqwkE9_fT1RUxkjg&s=10"
                >
            </div>

            <div class="carousel-item">
                <img
                    class="d-block w-100"
                    alt=""
                    src="https://img.magnific.com/free-vector/hand-drawn-literature-twitter-header_23-2149721049.jpg?semt=ais_hybrid&w=740&q=80"
                >
            </div>

            <div class="carousel-item">
                <img
                    class="d-block w-100"
                    alt=""
                    src="https://img.magnific.com/free-vector/hand-drawn-literature-twitter-header_23-2149721049.jpg?semt=ais_hybrid&w=740&q=80"
                >
            </div>

            <div class="carousel-item">
                <img
                    class="d-block w-100"
                    alt=""
                    src="https://img.magnific.com/free-vector/hand-drawn-literature-twitter-header_23-2149721049.jpg?semt=ais_hybrid&w=740&q=80"
                >
            </div>

        </div>


        <a
            class="carousel-control-prev"
            href="#carousel-sample"
            role="button"
            data-bs-slide="prev"
        >
            <span
                class="carousel-control-prev-icon"
                aria-hidden="true"
            ></span>

            <span class="visually-hidden">
                Previous
            </span>

        </a>


        <a
            class="carousel-control-next"
            href="#carousel-sample"
            role="button"
            data-bs-slide="next"
        >
            <span
                class="carousel-control-next-icon"
                aria-hidden="true"
            ></span>

            <span class="visually-hidden">
                Next
            </span>

        </a>



    {{-- ================= PAKET LANGGANAN ================= --}}
    <div class="mt-4">

        <div class="d-flex align-items-center gap-2">

            <span class="badge bg-yellow text-yellow-fg p-2">
                <i class="fa-solid fa-crown fs-3"></i>
            </span>

           <h2 class="mt-3 text-dark">Paket Langganan</h2>
        </div>

        <div class="row g-4 mt-2">

    @forelse ($subscriptions as $subscription)

        <div class="col-md-4">

            <div
                class="card h-100"
                style="background: linear-gradient(135deg, #ffffff 0%, {{ $subscription->color }} 100%);">

                <div class="card-body text-center text-dark">

                    <h2 style="font-weight: bold;">
                        {{ $subscription->name }}
                    </h2>

                    <p
                        class="text-secondary"
                        style="font-weight: bold; margin: 0;">
                        PACKAGE
                    </p>

                    <div>

                        Rp

                        <span
                            style="font-size: 2rem; font-weight: bold;"class="text-warning">
                            {{ number_format($subscription->price, 0, ',', '.') }}
                        </span>

                        <br>

                        <span
                            style="font-weight: bold; class="text-secondary">
                            {{$subscription->description}}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12">
            <div class="text-center text-secondary">
                Belum ada paket langganan.
            </div>
        </div>

    @endforelse

</div>

</div>


    {{-- ================= BUKU BARU DIRILIS ================= --}}
    <div class="mt-5">

        <div class="d-flex align-items-center gap-2 mb-4">

            <h2 class="m-0 text-dark fw-bold">
                Buku Baru Dirilis
            </h2>

        </div>


        {{-- INI CONTAINER SLIDER --}}
        <div id="wrapper-slide">


            {{-- CARD 1 --}}
            <div>
                <div class="card">

                    <img
                        class="d-block mx-auto w-75 mt-3"
                        alt=""
                        src="https://bukukita.com/babacms/displaybuku/117296_f.jpg"
                    >

                    <div class="card-body">

                        <div class="d-flex gap-2">

                            <span class="badge">
                                <i class="fa-solid fa-mobile"></i>
                                PDF
                            </span>

                            <span class="badge">
                                3+
                            </span>

                        </div>

                        <h5 class="mt-2">
                            <span
                                style="font-size: 0.8rem;"
                                class="text-secondary"
                            >
                                Tere Liye
                            </span>
                        </h5>

                        <h5 style="font-size:1rem;">
                            Card with Title
                        </h5>

                        <h4
                            style="font-size: 1.2rem; font-weight: bold;"
                        >
                            Rp 49.000
                        </h4>

                    </div>

                </div>
            </div>


            {{-- CARD 2 --}}
            <div>
                <div class="card">

                    <img
                        class="d-block mx-auto w-75 mt-3"
                        alt=""
                        src="https://bukukita.com/babacms/displaybuku/117296_f.jpg"
                    >

                    <div class="card-body">

                        <div class="d-flex gap-2">

                            <span class="badge">
                                <i class="fa-solid fa-mobile"></i>
                                PDF
                            </span>

                            <span class="badge">
                                3+
                            </span>

                        </div>

                        <h5 class="mt-2">
                            <span
                                style="font-size: 0.8rem;"
                                class="text-secondary"
                            >
                                Tere Liye
                            </span>
                        </h5>

                        <h5 style="font-size:1rem;">
                            Card with Title
                        </h5>

                        <h4
                            style="font-size: 1.2rem; font-weight: bold;"
                        >
                            Rp 49.000
                        </h4>

                    </div>

                </div>
            </div>


            {{-- CARD 3 --}}
            <div>
                <div class="card">

                    <img
                        class="d-block mx-auto w-75 mt-3"
                        alt=""
                        src="https://bukukita.com/babacms/displaybuku/117296_f.jpg"
                    >

                    <div class="card-body">

                        <div class="d-flex gap-2">

                            <span class="badge">
                                <i class="fa-solid fa-mobile"></i>
                                PDF
                            </span>

                            <span class="badge">
                                3+
                            </span>

                        </div>

                        <h5 class="mt-2">
                            <span
                                style="font-size: 0.8rem;"
                                class="text-secondary"
                            >
                                Tere Liye
                            </span>
                        </h5>

                        <h5 style="font-size:1rem;">
                            Card with Title
                        </h5>

                        <h4
                            style="font-size: 1.2rem; font-weight: bold;"
                        >
                            Rp 49.000
                        </h4>

                    </div>

                </div>
            </div>


            {{-- CARD 4 --}}
            <div>
                <div class="card">

                    <img
                        class="d-block mx-auto w-75 mt-3"
                        alt=""
                        src="https://bukukita.com/babacms/displaybuku/117296_f.jpg"
                    >

                    <div class="card-body">

                        <div class="d-flex gap-2">

                            <span class="badge">
                                <i class="fa-solid fa-mobile"></i>
                                PDF
                            </span>

                            <span class="badge">
                                3+
                            </span>

                        </div>

                        <h5 class="mt-2">
                            <span
                                style="font-size: 0.8rem;"
                                class="text-secondary"
                            >
                                Tere Liye
                            </span>
                        </h5>

                        <h5 style="font-size:1rem;">
                            Card with Title
                        </h5>

                        <h4
                            style="font-size: 1.2rem; font-weight: bold;"
                        >
                            Rp 49.000
                        </h4>

                    </div>

                </div>
            </div>


            {{-- CARD 5 --}}
            <div>
                <div class="card">

                    <img
                        class="d-block mx-auto w-75 mt-3"
                        alt=""
                        src="https://bukukita.com/babacms/displaybuku/117296_f.jpg"
                    >

                    <div class="card-body">

                        <div class="d-flex gap-2">

                            <span class="badge">
                                <i class="fa-solid fa-mobile"></i>
                                PDF
                            </span>

                            <span class="badge">
                                3+
                            </span>

                        </div>

                        <h5 class="mt-2">
                            <span
                                style="font-size: 0.8rem;"
                                class="text-secondary"
                            >
                                Tere Liye
                            </span>
                        </h5>

                        <h5 style="font-size:1rem;">
                            Card with Title
                        </h5>

                        <h4
                            style="font-size: 1.2rem; font-weight: bold;"
                        >
                            Rp 49.000
                        </h4>

                    </div>

                </div>
            </div>


            {{-- CARD 6 --}}
            <div>
                <div class="card">

                    <img
                        class="d-block mx-auto w-75 mt-3"
                        alt=""
                        src="https://bukukita.com/babacms/displaybuku/117296_f.jpg"
                    >

                    <div class="card-body">

                        <div class="d-flex gap-2">

                            <span class="badge">
                                <i class="fa-solid fa-mobile"></i>
                                PDF
                            </span>

                            <span class="badge">
                                3+
                            </span>

                        </div>

                        <h5 class="mt-2">
                            <span
                                style="font-size: 0.8rem;"
                                class="text-secondary"
                            >
                                Tere Liye
                            </span>
                        </h5>

                        <h5 style="font-size:1rem;">
                            Card with Title
                        </h5>

                        <h4
                            style="font-size: 1.2rem; font-weight: bold;"
                        >
                            Rp 49.000
                        </h4>

                    </div>

                </div>
            </div>


            {{-- CARD 7 --}}
            <div>
                <div class="card">

                    <img
                        class="d-block mx-auto w-75 mt-3"
                        alt=""
                        src="https://bukukita.com/babacms/displaybuku/117296_f.jpg"
                    >

                    <div class="card-body">

                        <div class="d-flex gap-2">

                            <span class="badge">
                                <i class="fa-solid fa-mobile"></i>
                                PDF
                            </span>

                            <span class="badge">
                                3+
                            </span>

                        </div>

                        <h5 class="mt-2">
                            <span
                                style="font-size: 0.8rem;"
                                class="text-secondary"
                            >
                                Fedliansyah
                            </span>
                        </h5>

                        <h5 style="font-size:1rem;">
                            Card with Title
                        </h5>

                        <h4
                            style="font-size: 1.2rem; font-weight: bold;"
                        >
                            Rp 49.000
                        </h4>

                    </div>

                </div>
            </div>


        </div>
        {{-- END SLIDER --}}

    </div>

</div>

<div class="mt-4">
    <div class="d-flex align-items-center gap-2 mb-4">
        <h2 class="mt-3 text-dark" style="font-weight: bold">Buku Gratis</h2>
    </div>

    <div class="row">
<div class="col-4">
    <div class="card d-flex flex-column">
        <div class="row row-0 flex-fill">
            <div class="col-md-3">
                <a href="#">
                    <img
                        src="https://template.canva.com/EAGENUU6PyM/1/0/501w-xxACqV7AsPA.jpg"
                        class="w-100 h-100 object-cover"
                        alt="Card side image"
                    />
                </a>
            </div>

            <div class="col">
                <div class="card-body h-full d-flex flex-column">
                    <h3 class="card-title">
                        <div class="badge">
                            <i class="fa-solid fa-mobile"></i>PDF
                        </div>
                    </h3>

                    <div class="text-secondary">
                        Penulis
                        <br>
                        <span class="text-dark">Judul Buku</span>
                    </div>

                    <div class="d-flex align-items-center pt-4 mt-auto">
                        <h3>
                            <span class="text-decoration-line-through text-secondary">
                                Rp 50.000
                            </span>
                            <span class="text-dark">Rp 0</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="card d-flex flex-column">
        <div class="row row-0 flex-fill">
            <div class="col-md-3">
                <a href="#">
                    <img
                        src="https://template.canva.com/EAGENUU6PyM/1/0/501w-xxACqV7AsPA.jpg"
                        class="w-100 h-100 object-cover"
                        alt="Card side image"
                    />
                </a>
            </div>

            <div class="col">
                <div class="card-body h-full d-flex flex-column">
                    <h3 class="card-title">
                        <div class="badge">
                            <i class="fa-solid fa-mobile"></i>PDF
                        </div>
                    </h3>

                    <div class="text-secondary">
                        Penulis
                        <br>
                        <span class="text-dark">Judul Buku</span>
                    </div>

                    <div class="d-flex align-items-center pt-4 mt-auto">
                        <h3>
                            <span class="text-decoration-line-through text-secondary">
                                Rp 50.000
                            </span>
                            <span class="text-dark">Rp 0</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="card d-flex flex-column">
        <div class="row row-0 flex-fill">
            <div class="col-md-3">
                <a href="#">
                    <img
                        src="https://template.canva.com/EAGENUU6PyM/1/0/501w-xxACqV7AsPA.jpg"
                        class="w-100 h-100 object-cover"
                        alt="Card side image"
                    />
                </a>
            </div>

            <div class="col">
                <div class="card-body h-full d-flex flex-column">
                    <h3 class="card-title">
                        <div class="badge">
                            <i class="fa-solid fa-mobile"></i>PDF
                        </div>
                    </h3>

                    <div class="text-secondary">
                        Penulis
                        <br>
                        <span class="text-dark">Judul Buku</span>
                    </div>

                    <div class="d-flex align-items-center pt-4 mt-auto">
                        <h3>
                            <span class="text-decoration-line-through text-secondary">
                                Rp 50.000
                            </span>
                            <span class="text-dark">Rp 0</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="card d-flex flex-column">
        <div class="row row-0 flex-fill">
            <div class="col-md-3">
                <a href="#">
                    <img
                        src="https://template.canva.com/EAGENUU6PyM/1/0/501w-xxACqV7AsPA.jpg"
                        class="w-100 h-100 object-cover"
                        alt="Card side image"
                    />
                </a>
            </div>

            <div class="col">
                <div class="card-body h-full d-flex flex-column">
                    <h3 class="card-title">
                        <div class="badge">
                            <i class="fa-solid fa-mobile"></i>PDF
                        </div>
                    </h3>

                    <div class="text-secondary">
                        Penulis
                        <br>
                        <span class="text-dark">Judul Buku</span>
                    </div>

                    <div class="d-flex align-items-center pt-4 mt-auto">
                        <h3>
                            <span class="text-decoration-line-through text-secondary">
                                Rp 50.000
                            </span>
                            <span class="text-dark">Rp 0</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="card d-flex flex-column">
        <div class="row row-0 flex-fill">
            <div class="col-md-3">
                <a href="#">
                    <img
                        src="https://template.canva.com/EAGENUU6PyM/1/0/501w-xxACqV7AsPA.jpg"
                        class="w-100 h-100 object-cover"
                        alt="Card side image"
                    />
                </a>
            </div>

            <div class="col">
                <div class="card-body h-full d-flex flex-column">
                    <h3 class="card-title">
                        <div class="badge">
                            <i class="fa-solid fa-mobile"></i>PDF
                        </div>
                    </h3>

                    <div class="text-secondary">
                        Penulis
                        <br>
                        <span class="text-dark">Judul Buku</span>
                    </div>

                    <div class="d-flex align-items-center pt-4 mt-auto">
                        <h3>
                            <span class="text-decoration-line-through text-secondary">
                                Rp 50.000
                            </span>
                            <span class="text-dark">Rp 0</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-4">
    <div class="card d-flex flex-column">
        <div class="row row-0 flex-fill">
            <div class="col-md-3">
                <a href="#">
                    <img
                        src="https://template.canva.com/EAGENUU6PyM/1/0/501w-xxACqV7AsPA.jpg"
                        class="w-100 h-100 object-cover"
                        alt="Card side image"
                    />
                </a>
            </div>

            <div class="col">
                <div class="card-body h-full d-flex flex-column">
                    <h3 class="card-title">
                        <div class="badge">
                            <i class="fa-solid fa-mobile"></i>PDF
                        </div>
                    </h3>

                    <div class="text-secondary">
                        Penulis
                        <br>
                        <span class="text-dark">Judul Buku</span>
                    </div>

                    <div class="d-flex align-items-center pt-4 mt-auto">
                        <h3>
                            <span class="text-decoration-line-through text-secondary">
                                Rp 50.000
                            </span>
                            <span class="text-dark">Rp 0</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
    </div>


@endsection

@push('scripts')

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- Slick Carousel JS --}}
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


<script>

    $(document).ready(function () {

        $('#wrapper-slide').slick({

            dots: true,

            infinite: false,

            speed: 300,

            slidesToShow: 4,

            slidesToScroll: 4,

            arrows: true,

            responsive: [

                {
                    breakpoint: 1024,

                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },

                {
                    breakpoint: 768,

                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },

                {
                    breakpoint: 480,

                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }

            ]

        });

    });

</script>

@endpush
