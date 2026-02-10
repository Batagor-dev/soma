document.addEventListener("DOMContentLoaded", function () {
    // === SWIPER HANYA SATU KALI ===
    const swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        speed: 800,

        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: false,
        },

        // Fix scroll Windows
        mousewheel: false,
        simulateTouch: true,
        touchStartPreventDefault: false,

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
    });

    // === NAVBAR SCROLL EFFECT ===
    window.addEventListener("scroll", function () {
        const navbar = document.querySelector(".navbar");
        if (window.scrollY > 100) {
            navbar.classList.add("navbar-scrolled");
        } else {
            navbar.classList.remove("navbar-scrolled");
        }
    });

    // === PAGE LOADER ===
    document.body.classList.add("loading");

    window.addEventListener("load", function () {
        const loader = document.getElementById("page-loader");
        if (loader) {
            setTimeout(() => {
                loader.style.opacity = "0";
                document.body.classList.remove("loading");
                setTimeout(() => {
                    loader.style.display = "none";
                }, 300);
            }, 300);
        }
    });

    // === GSAP ANIMATIONS ===
    // Pastikan GSAP sudah terload
    if (typeof gsap !== 'undefined') {
        // Animasi teks di Hero
        gsap.from("#hero h1", { 
            duration: 1, 
            y: 50, 
            opacity: 0, 
            delay: 0.5,
            clearProps: "transform" 
        });
        
        gsap.from("#hero .lead", { 
            duration: 1, 
            y: 30, 
            opacity: 0, 
            delay: 0.8 
        });
        
        gsap.from("#hero .btn", {
            duration: 1,
            y: 20,
            opacity: 0,
            delay: 1,
            stagger: 0.2,
        });
    }

    // === FIX RESIZE UNTUK SWIPER ===
    window.addEventListener("resize", function () {
        if (swiper && !swiper.destroyed) {
            swiper.update();
            if (swiper.autoplay && swiper.autoplay.running) {
                swiper.autoplay.start();
            }
        }
    });
});

// === HAPUS KODE INI ===
// JANGAN ada kode Swiper di luar DOMContentLoaded
// const swiper = new Swiper(".mySwiper", { ... }); // HAPUS INI