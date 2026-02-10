<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ settings()['title'] ?? config('app.name') }}</title>
    <meta name="author" content="{{ settings()['author'] ?? '' }}">
    <meta name="description" content="{{ settings()['description'] ?? '' }}">


    <!-- Favicon -->
    <link rel="icon" type="image/png"
      href="{{ settings()['favicon'] ? asset('storage/' . settings()['favicon']) : asset('images/no-image.png') }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('forntend/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('forntend/css/nav.css') }}">

    <!-- Animate.css untuk animasi dasar -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- AOS Library untuk Animasi pada Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


    <!-- Custom CSS -->
    @stack('styles')
</head>
<body>
    <!-- Header -->
    @include('layout.public.header')
    
    <!-- Main Content -->
    <main class="bg-light">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('layout.public.footer')
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('forntend/js/nav.js')}}"></script>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- GSAP (opsional untuk animasi kompleks) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <!-- Input mask untuk form -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>

    <script>
        // Inisialisasi AOS
        AOS.init({
            duration: 800, // durasi animasi
            offset: 100,   // offset trigger
            once: true     // animasi hanya sekali
        });

        // Inisialisasi Input Mask untuk telepon di form kontak
        document.addEventListener('DOMContentLoaded', function() {
            var phoneInput = document.getElementById('phoneInput'); // Anda perlu menambahkan ID di input
            if(phoneInput) {
                new Cleave('#phoneInput', {
                    numericOnly: true,
                    blocks: [4, 4, 8],
                    delimiter: ' '
                });
            }
        });
    </script>
    <!-- Custom Scripts -->
    @stack('scripts')
</body>
</html>