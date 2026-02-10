@extends('layout.public.main')

    @section('content')
    <section class="py-5">
        <div class="container">

        <!-- Judul -->
        <div class="text-center mb-4">
            <h2 class="fw-bold">All Gallery</h2>
            <p class="text-muted">Dokumentasi kegiatan dan momen kebersamaan</p>

            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4 mt-3">
                ← Kembali
            </a>
        </div>


                <!-- Grid -->
                <div class="row g-4">
                    @forelse ($galery as $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="gallery-card h-100">
                                <div class="gallery-image">
                                    <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->title }}">

                                    <div class="gallery-overlay">
                                        <h5 class="mb-1">{{ $item->title }}</h5>
                                        <p class="small mb-0">
                                            {{ \Carbon\Carbon::parse($item->time)->translatedFormat('d F Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">Belum ada galeri</p>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $galery->links() }}
                </div>

            </div>
        </section>

        @push('styles')
            <link rel="stylesheet" href="{{ asset('forntend/css/galery.css') }}">
        @endpush

    @endsection
