{{-- Index --}}
@extends('layout.public.main')

@section('content')
    <!-- Page Loader -->
    <div id="page-loader">
        <div class="spinner"></div>
    </div>

    <!-- Hero Section -->
    <section class="mb-5 p-2 p-md-4 bg-light" id="hero">
        @if(isset($banners) && count($banners) > 0)
        @php $banner = $banners->first(); @endphp

        <div class="position-relative overflow-hidden rounded-4 rounded-md-5 min-vh-50 min-vh-md-75 hero-container" 
            style="z-index: 1;"> <!-- TAMBAHKAN INI -->

            <img src="{{ asset('storage/' . $banner->photo) }}"
                class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover hero-image"
                data-aos="zoom-out" data-aos-duration="1500"
                style="z-index: 1;"> <!-- TAMBAHKAN INI -->

            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-25" 
                style="z-index: 2;"></div> <!-- TAMBAHKAN INI -->

            <div class="position-relative h-100" style="z-index: 3;"> <!-- TAMBAHKAN INI -->
                <div class="container h-100 d-flex align-items-center p-4">
                    <div class="text-white col-lg-6 pt-3 pt-md-5 hero-content">

                        <span class="badge rounded-pill bg-light bg-opacity-25 text-white 
                                    px-2 px-md-3 py-1 py-md-2 mb-2 mb-md-3 animate__animated animate__fadeIn">
                            KOLEKSI BARU 2024
                        </span>

                        <!-- JUDUL -->
                        <h1 class="fw-bold mb-1 fs-4 fs-md-3 fs-lg-1 lh-sm hero-title"
                            data-aos="fade-up" data-aos-delay="300">
                            Taklukan Samudera
                        </h1>

                        <!-- SUB JUDUL -->
                        <h2 class="fw-light fst-italic mb-2 fs-5 fs-md-4 fs-lg-2 lh-sm hero-subtitle"
                            data-aos="fade-up" data-aos-delay="500">
                            Bersama Kami
                        </h2>

                        <!-- DESKRIPSI -->
                        <p class="mb-3 mb-md-4 small lh-sm hero-description"
                            data-aos="fade-up" data-aos-delay="700">
                            APRI adalah rumah bagi para pemancing yang menjadikan laut sebagai guru, 
                            kesabaran sebagai senjata, dan kebersamaan sebagai hasil tangkapan terbaik.
                        </p>

                        <!-- BUTTON -->
                        <div class="d-flex gap-2 gap-md-3 flex-wrap hero-buttons"
                            data-aos="fade-up" data-aos-delay="900">
                            <a href="#" class="btn btn-primary btn-sm btn-md-lg rounded-pill px-3 px-md-4 animate__animated animate__pulse animate__infinite animate__slower">
                                <i class="bi bi-person-plus me-2"></i>
                                Daftar Sekarang
                            </a>

                            <a href="#gallery" class="btn btn-outline-light btn-sm btn-md-lg rounded-pill px-3 px-md-4 scroll-to-section">
                                <i class="bi bi-images me-2"></i>
                                Lihat Kegiatan Kami
                            </a>
                        </div>

                    </div>

                </div>
            </div>

        </div>
        @endif
    </section>

    <!-- About Section -->
    <section class="bg-light py-5" id="profil">
        <div class="container">
            <div class="row align-items-start">

                <!-- Kolom kiri: Konten -->
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right" data-aos-delay="100">
                    <div class="mb-4">
                        <h6 class="text-primary fw-bold text-uppercase mb-2">
                            Tentang Kami
                        </h6>
                        <h2 class="display-5 fw-bold text-dark mb-0 about-title">
                            {{ $profil->judul ?? '-' }}
                        </h2>
                    </div>

                    <p class="lead text-muted mb-5 about-description">
                        {{ $profil->deskripsi ?? '-' }}
                    </p>

                    <!-- POIN -->
                    <div class="mb-4">
                        @if(is_array($profil?->poin) && count($profil->poin) > 0)
                            @foreach($profil->poin as $item)
                                <div class="d-flex align-items-start mb-4 about-point" 
                                     data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 + 200 }}">
                                    <div class="flex-shrink-0 me-4">
                                        <div class="bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-circle p-3 d-flex align-items-center justify-content-center icon-wrapper"
                                            style="width: 70px; height: 70px;">
                                            <i class="bi {{ $item['icon'] }} text-primary fs-3 icon"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 text-start">
                                        <h4 class="fw-bold text-dark mb-2 point-title">
                                            {{ $item['judul'] }}
                                        </h4>
                                        <p class="text-muted mb-0 point-description">
                                            {{ $item['deskripsi'] }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Kolom kanan: Gambar -->
                <div class="col-lg-6 position-relative" data-aos="fade-left" data-aos-delay="100">
                    <div class="position-relative rounded-4 overflow-hidden border border-light shadow-lg about-image-container">
                        @if (!empty($profil?->photo))
                            <img
                                class="img-fluid w-100 about-image"
                                style="height: 600px; object-fit: cover;"
                                src="{{ asset('storage/' . $profil->photo) }}"
                                alt="Foto Profil"
                            >
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-secondary text-white about-placeholder"
                                style="height: 600px;">
                                <span class="fs-5">Tidak ada photo</span>
                            </div>
                        @endif
                    </div>

                    <!-- Efek dekoratif -->
                    <div class="position-absolute top-0 end-0 translate-middle-y bg-primary bg-opacity-10 rounded-circle about-decoration"
                        style="width: 200px; height: 200px; filter: blur(50px); z-index: -1;">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Struktur Organisasi -->
    <section class="bg-light py-5" id="struktur">
        <div class="container">
            <div class="row mb-5 text-start w-75">
                <div class="mb-4" data-aos="fade-up">
                    <h6 class="text-primary fw-bold text-uppercase mb-2">
                        Struktur Organisasi 
                    </h6>
                    <h4 class="display-6 fw-bold text-dark mb-0 struktur-title">
                        Tim kepengurusan komunitas pemancing yang berdedikasi 
                    </h4>
                </div>
            </div>

            <div class="position-relative px-4">
                <div class="swiper mySwiper" data-aos="zoom-in" data-aos-delay="200">
                    <div class="swiper-wrapper">

                        @forelse ($struktur as $item)
                            <div class="swiper-slide">
                                <div class="card member-card border-0 overflow-hidden position-relative h-100 struktur-card" 
                                     style="aspect-ratio: 3/4;"
                                     data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                    <div class="position-relative w-100 h-100 member-image-container">
                                        <img
                                            src="{{ $item->photo 
                                                ? asset('storage/uploads/stuktural/' . $item->photo) 
                                                : asset('images/default-user.jpg') }}"
                                            class="position-absolute top-0 start-0 w-100 h-100 member-image"
                                            style="object-fit: cover;"
                                            alt="{{ $item->name }}"
                                        >

                                        <div class="card-img-overlay d-flex flex-column justify-content-end p-4 text-white member-overlay"
                                            style="background: linear-gradient(to top, rgba(0,0,0,0.85), rgba(0,0,0,0.3), transparent);">

                                            <div class="mb-2">
                                                <span class="badge bg-primary bg-opacity-75 px-3 py-2 member-badge">
                                                    {{ $item->jabatan ?? 'Jabatan belum diisi' }}
                                                </span>
                                            </div>

                                            <h4 class="fw-bold mb-1 member-name">
                                                {{ $item->name ?? 'Nama belum diisi' }}
                                            </h4>

                                            <p class="mb-0 opacity-75 member-unit">
                                                {{ $item->unit ?? 'Unit belum diisi' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <div class="text-center w-100 py-5" data-aos="fade-up">
                                    <h5 class="text-muted">😶‍🌫️ Struktur organisasi belum diisi</h5>
                                    <p class="text-muted small">Silakan tambahkan data kepengurusan terlebih dahulu</p>
                                </div>
                            </div>
                        @endforelse

                    </div>

                    <div class="swiper-pagination mt-4"></div>
                    
                    <!-- Navigation buttons -->
                    <div class="swiper-button-next struktur-next"></div>
                    <div class="swiper-button-prev struktur-prev"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="bg-light py-5" id="gallery">
        <div class="container">
            <!-- Judul -->
            <div class="row mb-5 text-start w-75">
                <div class="mb-4" data-aos="fade-up">
                    <h6 class="text-primary fw-bold text-uppercase mb-2">
                        Gallery
                    </h6>
                    <h4 class="display-6 fw-bold text-dark mb-0 gallery-title">
                        Dokumentasi kegiatan dan momen kebersamaan
                    </h4>
                </div>
            </div>

            <!-- Grid Gallery -->
            <div class="row g-4 gallery-grid">
                @forelse ($galery as $item)
                    <div class="col-12 col-md-6 col-lg-4 gallery-item" 
                         data-aos="fade-up" 
                         data-aos-delay="{{ $loop->index * 100 }}"
                         data-gallery-item="{{ $item->id }}">
                        <div class="gallery-card h-100">
                            <div class="gallery-image">
                                <img 
                                    src="{{ asset('storage/' . $item->photo) }}" 
                                    alt="{{ $item->title }}"
                                    class="gallery-img"
                                    loading="lazy"
                                >

                                <div class="gallery-overlay">
                                    <h5 class="fw-semibold mb-1 gallery-item-title">
                                        {{ $item->title }}
                                    </h5>
                                    <p class="small mb-0 gallery-item-date">
                                        {{ \Carbon\Carbon::parse($item->time)->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                                
                                <!-- Zoom icon -->
                                <div class="gallery-zoom">
                                    <i class="bi bi-zoom-in"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center" data-aos="fade-up">
                        <p class="text-muted">Belum ada galeri ditampilkan</p>
                    </div>
                @endforelse
            </div>

            {{-- VIEW ALL DI LUAR GRID --}}
            @if ($totalGalery > 6)
                <div class="row mt-5" data-aos="fade-up" data-aos-delay="300">
                    <div class="col-12 col-md-6 col-lg-4 mx-auto">
                        <a href="{{ url('/home/galery') }}"
                        class="btn btn-outline-dark w-100 py-3 gallery-view-all">
                            <span>View All Gallery</span>
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </section>

    <!-- Events Section -->
    <section class="py-5 bg-light" id="events">
        <div class="container">

            <!-- Heading -->
            <div class="row mb-5 text-start w-75">
                <div class="mb-4" data-aos="fade-up">
                    <h6 class="text-primary fw-bold text-uppercase mb-2">
                        Event Mendatang
                    </h6>
                    <h4 class="display-6 fw-bold text-dark mb-0 events-title">
                    Siapkan diri Anda untuk acara seru bersama kami
                    </h4>
                </div>
            </div>

            <!-- Event Cards -->
            <div class="row g-4 events-grid">

                @forelse ($kegiatans as $event)
                    <div class="col-12 col-md-6 col-lg-4 event-item" 
                        data-aos="zoom-in" 
                        data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="event-card h-100">

                            <!-- Image -->
                            <div class="event-image position-relative">
                                <img
                                    src="{{ asset('storage/' . $event->photo) }}"
                                    alt="{{ $event->title }}"
                                    class="event-img"
                                    loading="lazy"
                                >

                                <!-- Date Badge -->
                                @if(!empty($event->waktu))
                                    <div class="event-date text-center">
                                        <span class="month">
                                            {{ \Carbon\Carbon::parse($event->waktu)->translatedFormat('M') }}
                                        </span>
                                        <span class="day">
                                            {{ \Carbon\Carbon::parse($event->waktu)->format('d') }}
                                        </span>
                                    </div>
                                @endif
                                
                                <!-- Overlay effect -->
                                <div class="event-overlay"></div>
                            </div>

                            <!-- Content -->
                            <div class="p-4 event-content">
                                <p class="text-muted small mb-2 event-meta">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ $event->waktu
                                        ? \Carbon\Carbon::parse($event->waktu)->translatedFormat('d F Y')
                                        : 'Tanggal belum ditentukan' }}
                                </p>

                                <h5 class="fw-bold mb-2 event-title">
                                    {{ $event->title }}
                                </h5>

                                <p class="text-muted small mb-4 event-description">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($event->deskripsi), 90) }}
                                </p>

                                <!-- Button Modal -->
                                <button
                                    class="btn btn-outline-primary w-100 rounded-pill event-detail-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#eventModal{{ $event->id }}">
                                    <span>Lihat Detail</span>
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- Modal Detail Event -->
                    <div class="modal fade event-modal" id="eventModal{{ $event->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content rounded-4 overflow-hidden">

                                <div class="modal-body p-0">
                                    <img
                                        src="{{ asset('storage/' . $event->photo) }}"
                                        class="img-fluid w-100 modal-event-image"
                                        alt="{{ $event->title }}"
                                    >
                                </div>

                                <div class="modal-body p-4 modal-event-content">
                                    <h4 class="fw-bold mb-2 modal-event-title">
                                        {{ $event->title }}
                                    </h4>

                                    @if($event->waktu)
                                        <p class="text-muted small mb-3 modal-event-date">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            {{ \Carbon\Carbon::parse($event->waktu)->translatedFormat('d F Y, H:i') }}
                                        </p>
                                    @endif

                                    <div class="text-muted lh-lg modal-event-description">
                                        {!! nl2br(e($event->deskripsi)) !!}
                                    </div>

                                    <!-- Tombol Tutup Full Width -->
                                    <div class="mt-4">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary w-100 rounded-pill py-3"
                                            data-bs-dismiss="modal">
                                            <i class="bi bi-x-lg me-2"></i>
                                            Tutup
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12 text-center" data-aos="fade-up">
                        <p class="text-muted">Belum ada event yang dijadwalkan</p>
                    </div>
                @endforelse

            </div>

        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 position-relative overflow-hidden" id="cta">
        <div class="container">

            <div class="row align-items-center gy-4">

                <!-- Left Content -->
                <div class="col-lg-7 text-white" data-aos="fade-right" data-aos-delay="100">
                    <span class="badge bg-light bg-opacity-25 mb-3 px-3 py-2 rounded-pill cta-badge">
                        Bergabung Bersama Kami
                    </span>

                    <h2 class="fw-bold display-6 mb-3 cta-title">
                        Siap Menjadi Bagian dari Komunitas Kami?
                    </h2>

                    <p class="lead opacity-75 mb-4 cta-description">
                        Daftarkan diri Anda sekarang dan jadilah bagian dari
                        komunitas yang menjunjung persaudaraan, edukasi,
                        dan kecintaan terhadap alam.
                    </p>

                    <div class="d-flex flex-wrap gap-3 cta-buttons" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('register') }}"
                        class="btn btn-light btn-lg rounded-pill px-4 cta-join-btn animate__animated animate__pulse animate__infinite animate__slower">
                            <i class="bi bi-person-plus me-2"></i>
                            Daftar Sekarang
                        </a>

                        <a href="https://wa.me/628123456789"
                        target="_blank"
                        class="btn btn-outline-light btn-lg rounded-pill px-4 cta-contact-btn">
                            <i class="bi bi-whatsapp me-2"></i>
                            Hubungi Kami
                        </a>
                    </div>
                </div>

                <!-- Right Decorative -->
                <div class="col-lg-5 d-none d-lg-block" data-aos="fade-left" data-aos-delay="200">
                    <div class="cta-card text-white p-4 rounded-4 shadow-lg">
                        <h5 class="fw-bold mb-3 cta-card-title">Kenapa Harus Bergabung?</h5>
                        <ul class="list-unstyled mb-0 cta-benefits">
                            <li class="mb-2 cta-benefit-item" data-aos="fade-left" data-aos-delay="300">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Jaringan pemancing seluruh Indonesia
                            </li>
                            <li class="mb-2 cta-benefit-item" data-aos="fade-left" data-aos-delay="350">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Event & workshop rutin
                            </li>
                            <li class="mb-2 cta-benefit-item" data-aos="fade-left" data-aos-delay="400">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Edukasi & konservasi alam
                            </li>
                            <li class="cta-benefit-item" data-aos="fade-left" data-aos-delay="450">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Solidaritas & persaudaraan
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>

        <!-- Decorative Blur -->
        <div class="cta-blur"></div>
        
        <!-- Floating elements -->
        <div class="cta-floating cta-floating-1" data-aos="fade-down" data-aos-delay="500"></div>
        <div class="cta-floating cta-floating-2" data-aos="fade-up" data-aos-delay="600"></div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-white position-relative overflow-hidden">
        <!-- Decorative Background -->
        <div class="contact-bg-shape contact-bg-shape-1"></div>
        <div class="contact-bg-shape contact-bg-shape-2"></div>

        <div class="container position-relative">

            <!-- Section Heading -->
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                    <span class="text-primary fw-bold text-uppercase mb-2 d-inline-block">
                        Hubungi Kami
                    </span>
                    <h2 class="display-5 fw-bold text-dark mb-3">
                        Hubungi <span class="text-primary">Tim APRI</span> untuk Informasi Lebih Lanjut
                    </h2>
                    <p class="lead text-muted mb-0">
                        Kami siap membantu Anda dengan pertanyaan seputar keanggotaan, event, dan informasi mancing lainnya.
                        Respons cepat dari tim profesional kami.
                    </p>
                </div>
            </div>

            <div class="row g-5">

                <!-- LEFT : Contact Info -->
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                    <div class="contact-info-card p-4 p-lg-5 rounded-4 shadow-sm border">

                        <h4 class="fw-bold mb-4 text-dark">
                            <i class="bi bi-chat-dots me-2 text-primary"></i>Hubungi Tim APRI
                        </h4>

                        <!-- WhatsApp Button -->
                        <div class="mb-5">
                            <a href="https://wa.me/6281234567890"
                            target="_blank"
                            id="whatsappBtn"
                            class="btn btn-success btn-lg w-100 rounded-3 py-3 d-flex align-items-center justify-content-center hover-lift">

                                <i class="bi bi-whatsapp fs-3 me-3"></i>
                                <div class="text-start">
                                    <div class="fw-bold fs-5">Chat via WhatsApp</div>
                                    <div class="small opacity-75">Respon cepat dalam 5 menit</div>
                                </div>
                                <i class="bi bi-arrow-right ms-auto fs-5"></i>
                            </a>
                            <div class="form-text mt-2 text-center">Klik untuk langsung terhubung dengan admin APRI</div>
                        </div>

                        <!-- Contact Detail -->
                        <div class="mb-4">
                            <h5 class="fw-semibold mb-3 border-bottom pb-2">Informasi Kontak</h5>

                            <!-- WhatsApp -->
                            <div class="d-flex align-items-start mb-3 p-3 contact-item">
                                <div class="contact-icon bg-success bg-opacity-10 text-success rounded-3 p-2 me-3">
                                    <i class="bi bi-whatsapp fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">WhatsApp Admin</div>
                                    <a href="https://wa.me/6281234567890" target="_blank" class="text-decoration-none">
                                        +62 812 3456 7890
                                    </a>
                                    <div class="form-text">Pertanyaan seputar keanggotaan dan event</div>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="d-flex align-items-start mb-3 p-3 contact-item">
                                <div class="contact-icon bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3">
                                    <i class="bi bi-telephone fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">Telepon Kantor</div>
                                    <a href="tel:+622134567890" class="text-decoration-none">(021) 3456 7890</a>
                                    <div class="form-text">Senin-Jumat, 08:00-17:00 WIB</div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="d-flex align-items-start mb-3 p-3 contact-item">
                                <div class="contact-icon bg-danger bg-opacity-10 text-danger rounded-3 p-2 me-3">
                                    <i class="bi bi-envelope fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">Email Resmi</div>
                                    <a href="mailto:info@apri-mancing.or.id" class="text-decoration-none">
                                        info@apri-mancing.or.id
                                    </a>
                                    <div class="form-text">Untuk pertanyaan formal dan kerjasama</div>
                                </div>
                            </div>

                            <!-- Email Event -->
                            <div class="d-flex align-items-start p-3 contact-item">
                                <div class="contact-icon bg-warning bg-opacity-10 text-warning rounded-3 p-2 me-3">
                                    <i class="bi bi-calendar-event fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">Email Event</div>
                                    <a href="mailto:event@apri-mancing.or.id" class="text-decoration-none">
                                        event@apri-mancing.or.id
                                    </a>
                                    <div class="form-text">Pendaftaran dan informasi event mancing</div>
                                </div>
                            </div>
                        </div>

                        <!-- Office Hours -->
                        <div class="p-3 rounded-3 bg-light border">
                            <h6 class="fw-semibold mb-2">
                                <i class="bi bi-clock me-2 text-primary"></i>Jam Operasional
                            </h6>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Senin - Jumat</span>
                                <span class="fw-semibold text-primary">08:00 - 20:00 WIB</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Sabtu - Minggu</span>
                                <span class="fw-semibold text-primary">07:00 - 22:00 WIB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT : FAQ & Social -->
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="p-4 p-lg-5 rounded-4 shadow-sm border">

                        <h4 class="fw-bold mb-4 text-dark">
                            <i class="bi bi-question-circle me-2 text-primary"></i>Pertanyaan Umum (FAQ)
                        </h4>

                        <!-- FAQ -->
                        <div class="accordion" id="contactFAQ">

                            <!-- FAQ Item 1 -->
                            <div class="accordion-item border mb-3 rounded-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed rounded-3 fw-semibold"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#faq1"
                                            aria-expanded="false">
                                        <i class="bi bi-person-plus me-3 text-primary"></i>
                                        Bagaimana cara bergabung dengan APRI?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <p>Untuk bergabung dengan APRI, ikuti langkah berikut:</p>
                                        <ol class="mb-0">
                                            <li>Kirim WhatsApp ke nomor admin: <strong>+62 812 3456 7890</strong></li>
                                            <li>Format pesan: <code>DAFTAR APRI#Nama Lengkap#Kota Domisili</code></li>
                                            <li>Admin akan mengirim formulir pendaftaran digital</li>
                                            <li>Lengkapi data dan lakukan pembayaran iuran pertama</li>
                                            <li>Anda akan diundang ke grup WhatsApp resmi APRI</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ Item 2 -->
                            <div class="accordion-item border mb-3 rounded-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed rounded-3 fw-semibold"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#faq2"
                                            aria-expanded="false">
                                        <i class="bi bi-calendar-week me-3 text-primary"></i>
                                        Bagaimana mendapatkan info event terbaru?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <p>Informasi event APRI dapat diakses melalui:</p>
                                        <ul class="mb-0">
                                            <li><strong>Grup WhatsApp Resmi:</strong> Update harian untuk anggota</li>
                                            <li><strong>Instagram APRI:</strong> @apri.mancing (jadwal event bulanan)</li>
                                            <li><strong>Website APRI:</strong> Bagian Event & Tournament</li>
                                            <li><strong>Email Newsletter:</strong> Daftar di website untuk update reguler</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ Item 3 -->
                            <div class="accordion-item border mb-3 rounded-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed rounded-3 fw-semibold"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#faq3"
                                            aria-expanded="false">
                                        <i class="bi bi-geo-alt me-3 text-primary"></i>
                                        Apakah APRI punya rekomendasi spot mancing?
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <p>Ya, APRI memiliki database lengkap spot mancing seluruh Indonesia:</p>
                                        <ul class="mb-0">
                                            <li><strong>Spot Air Tawar:</strong> Waduk, sungai, dan danau</li>
                                            <li><strong>Spot Air Laut:</strong> Pantai, dermaga, dan trip laut</li>
                                            <li><strong>Spot Kolam Pemancingan:</strong> Rekomendasi terbaik</li>
                                            <li><strong>Update Kondisi:</strong> Informasi real-time dari anggota</li>
                                        </ul>
                                        <p class="mt-2 mb-0">Akses database melalui grup anggota atau minta rekomendasi ke admin.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ Item 4 -->
                            <div class="accordion-item border rounded-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed rounded-3 fw-semibold"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#faq4"
                                            aria-expanded="false">
                                        <i class="bi bi-shield-check me-3 text-primary"></i>
                                        Apa keuntungan menjadi anggota APRI?
                                    </button>
                                </h2>
                                <div id="faq4" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <p>Keuntungan sebagai anggota APRI:</p>
                                        <ul class="mb-0">
                                            <li>Diskon khusus di mitra kolam pemancingan</li>
                                            <li>Prioritas pendaftaran event dan tournament</li>
                                            <li>Akses grup eksklusif dengan pemancing profesional</li>
                                            <li>Workshop dan pelatihan teknik mancing gratis</li>
                                            <li>Asuransi kecelakaan saat mengikuti event APRI</li>
                                            <li>Sertifikat keanggotaan resmi</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="mt-5 pt-4 border-top">
                            <h6 class="fw-semibold mb-3">
                                <i class="bi bi-hash me-2 text-primary"></i>Media Sosial APRI
                            </h6>
                            <div class="d-flex gap-3 social-icons">
                                <a href="#" class="social-icon facebook" title="Facebook APRI">
                                    <i class="bi bi-facebook"></i>
                                    <span class="social-text">Facebook</span>
                                </a>
                                <a href="#" class="social-icon instagram" title="Instagram APRI">
                                    <i class="bi bi-instagram"></i>
                                    <span class="social-text">Instagram</span>
                                </a>
                                <a href="#" class="social-icon youtube" title="YouTube APRI">
                                    <i class="bi bi-youtube"></i>
                                    <span class="social-text">YouTube</span>
                                </a>
                                <a href="#" class="social-icon tiktok" title="TikTok APRI">
                                    <i class="bi bi-tiktok"></i>
                                    <span class="social-text">TikTok</span>
                                </a>
                                <a href="#" class="social-icon telegram" title="Telegram APRI">
                                    <i class="bi bi-telegram"></i>
                                    <span class="social-text">Telegram</span>
                                </a>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="mt-4">
                            <h6 class="fw-semibold mb-3">
                                <i class="bi bi-building me-2 text-primary"></i>Kantor Pusat APRI
                            </h6>
                            <div class="p-3 bg-light rounded-3 border">
                                <div class="d-flex">
                                    <i class="bi bi-geo-alt-fill text-primary me-3 fs-5"></i>
                                    <div>
                                        <div class="fw-semibold">APRI Headquarters</div>
                                        <div class="mb-2">Jl. Mancing Bahagia No.123, Kebayoran Baru, Jakarta Selatan 12120</div>
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-map me-1"></i> Lihat di Google Maps
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating WhatsApp (Mobile) -->
        <div class="d-lg-none position-fixed bottom-0 end-0 m-3 z-3">
            <a href="https://wa.me/6281234567890"
            id="floatingWhatsApp"
            class="btn btn-success rounded-pill shadow-lg px-3 py-2 d-flex align-items-center hover-lift">
                <div class="whatsapp-pulse"></div>
                <i class="bi bi-whatsapp fs-5"></i>
                <span class="ms-2 fw-semibold">Chat APRI</span>
            </a>
        </div>
    </section>


    <!-- Back to Top Button -->
    <button class="btn btn-primary back-to-top m-2" id="backToTop">
        <i class="bi bi-chevron-up"></i>
    </button>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('forntend/css/struktur.css')}}">
        <link rel="stylesheet" href="{{asset('forntend/css/galery.css')}}">
        <link rel="stylesheet" href="{{asset('forntend/css/kegiatan.css')}}">
        <link rel="stylesheet" href="{{asset('forntend/css/cta.css')}}">
        <link rel="stylesheet" href="{{asset('forntend/css/custom-animations.css')}}">
        <link rel="stylesheet" href="{{asset('forntend/css/contact.css')}}">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>
        <script src="{{asset('forntend/js/struktur.js')}}"></script>
        <script src="{{asset('forntend/js/contact.js')}}"></script>
        <script src="{{asset('forntend/js/custom-interactions.js')}}"></script>
        
        <script>
            // Inisialisasi AOS
            AOS.init({
                duration: 800,
                offset: 100,
                once: true,
                mirror: false
            });

            // Input mask untuk nomor telepon
            document.addEventListener('DOMContentLoaded', function() {
                var phoneInput = document.getElementById('contactPhone');
                if(phoneInput) {
                    new Cleave('#contactPhone', {
                        numericOnly: true,
                        blocks: [4, 4, 8],
                        delimiter: ' '
                    });
                }

                // Form submission dengan feedback
                const contactForm = document.getElementById('contactForm');
                if(contactForm) {
                    contactForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        const submitBtn = contactForm.querySelector('.contact-submit-btn');
                        const submitText = submitBtn.querySelector('.submit-text');
                        const spinner = submitBtn.querySelector('.spinner-border');
                        const successMsg = document.getElementById('contactSuccess');
                        
                        // Show loading state
                        submitText.classList.add('d-none');
                        spinner.classList.remove('d-none');
                        submitBtn.disabled = true;
                        
                        // Simulate API call
                        setTimeout(() => {
                            // Hide loading state
                            submitText.classList.remove('d-none');
                            spinner.classList.add('d-none');
                            submitBtn.disabled = false;
                            
                            // Show success message
                            successMsg.classList.remove('d-none');
                            
                            // Reset form
                            contactForm.reset();
                            
                            // Hide success message after 5 seconds
                            setTimeout(() => {
                                successMsg.classList.add('d-none');
                            }, 5000);
                        }, 1500);
                    });
                }

                // Back to top button
                const backToTop = document.getElementById('backToTop');
                if(backToTop) {
                    window.addEventListener('scroll', function() {
                        if (window.scrollY > 300) {
                            backToTop.classList.add('show');
                        } else {
                            backToTop.classList.remove('show');
                        }
                    });
                    
                    backToTop.addEventListener('click', function() {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    });
                }

                // Smooth scroll for anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        const href = this.getAttribute('href');
                        if(href === '#') return;
                        
                        e.preventDefault();
                        const target = document.querySelector(href);
                        if(target) {
                            window.scrollTo({
                                top: target.offsetTop - 80,
                                behavior: 'smooth'
                            });
                        }
                    });
                });

                // Initialize GSAP animations
                gsap.registerPlugin(ScrollTrigger);
                
                // Parallax effect for hero section
                const heroImage = document.querySelector('.hero-image');
                if(heroImage) {
                    gsap.to(heroImage, {
                        yPercent: 20,
                        ease: "none",
                        scrollTrigger: {
                            trigger: "#hero",
                            start: "top top",
                            end: "bottom top",
                            scrub: true
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection