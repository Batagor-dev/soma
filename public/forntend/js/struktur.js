document.addEventListener("DOMContentLoaded", function () {
    const swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        speed: 800,

        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true, // lebih baik diaktifkan untuk UX
        },

        // 🔥 FIX UNTUK WINDOWS SCROLL
        mousewheel: {
            enabled: false, // MATIKAN mousewheel control
            releaseOnEdges: false,
        },
        simulateTouch: true,
        allowTouchMove: true,
        
        // Tambahkan ini untuk mencegah scroll halaman
        touchEventsTarget: 'container',
        touchRatio: 1,
        touchAngle: 45,
        grabCursor: true,
        
        // Optional: Tambahkan resistance dan thresholds
        resistanceRatio: 0,
        threshold: 10, // minimum jarak drag untuk trigger swipe

        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
        },

        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

        breakpoints: {
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            992: {
                slidesPerView: 4,
            },
        },

        watchOverflow: true,
        observer: true,
        observeParents: true,
        
        // Tambahkan event handler untuk mencegah scroll
        on: {
            touchStart: function (swiper, event) {
                // Mencegah default behavior saat menyentuh slider
                if (event.type === 'touchstart') {
                    event.stopPropagation();
                }
            },
        }
    });

    // Handler untuk resize
    window.addEventListener("resize", function () {
        if (swiper && !swiper.destroyed) {
            swiper.update();
            if (swiper.autoplay && swiper.autoplay.running) {
                swiper.autoplay.start();
            }
        }
    });

    // 🔥 EXTRA FIX: Tambahkan handler untuk mencegah wheel scroll pada swiper
    const swiperContainer = document.querySelector('.mySwiper');
    if (swiperContainer) {
        swiperContainer.addEventListener('wheel', function(e) {
            e.stopPropagation();
            // Jika benar-benar ingin mencegah semua wheel scroll di swiper
            // return false;
        }, { passive: false });
    }
});