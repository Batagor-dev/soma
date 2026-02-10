<header>
    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm py-3">
        <div class="container">
            <!-- Brand/Logo -->
            <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                <img 
                    src="{{ asset('storage/' . settings()['favicon']) }}" 
                    alt="Logo"
                    style="height:2.8rem; width:auto;"
                    class="me-2 logo-icon"
                >
                <span class="text-primary fs-4">
                    {{ settings()['title'] ?? 'MyApp' }}
                </span>
            </a>
            
            <!-- Desktop Navigation -->
            <div class="d-none d-lg-flex align-items-center">
                <ul class="navbar-nav me-4">
                    <li class="nav-item mx-2">
                        <a class="nav-link position-relative px-3 py-2 rounded" href="{{ Request::is('/') ? '#hero' : route('home') . '#hero' }}" 
                           data-bs-toggle="tooltip" title="Home">
                            <i class="bi bi-house me-1"></i> Home
                            <span class="nav-indicator"></span>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link position-relative px-3 py-2 rounded" href="{{ Request::is('/') ? '#profil' : route('home') . '#profil' }}" 
                           data-bs-toggle="tooltip" title="Profile">
                            <i class="bi bi-info-circle me-1"></i> Profile
                            <span class="nav-indicator"></span>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link position-relative px-3 py-2 rounded" href="{{ Request::is('/') ? '#struktur' : route('home') . '#struktur' }}"
                           data-bs-toggle="tooltip" title="Struktur">
                            <i class="bi bi-diagram-3 me-1"></i> Struktur
                            <span class="nav-indicator"></span>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link position-relative px-3 py-2 rounded" href="{{ Request::is('/') ? '#gallery' : route('home') . '#gallery' }}"
                           data-bs-toggle="tooltip" title="Gallery">
                            <i class="bi bi-images me-1"></i> Gallery
                            <span class="nav-indicator"></span>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link position-relative px-3 py-2 rounded" href="{{ Request::is('/') ? '#events' : route('home') . '#events' }}" 
                           data-bs-toggle="tooltip" title="Kegiatan">
                            <i class="bi bi-calendar-event me-1"></i> Kegiatan
                            <span class="nav-indicator"></span>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link position-relative px-3 py-2 rounded" href="{{ Request::is('/') ? '#contact' : route('home') . '#contact' }}"
                           data-bs-toggle="tooltip" title="Kontak">
                            <i class="bi bi-envelope me-1"></i> Kontak
                            <span class="nav-indicator"></span>
                        </a>
                    </li>
                </ul>
                
                <!-- Auth Buttons Desktop -->
                <div class="d-flex align-items-center">
                    @auth
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" 
                               id="userDropdown" data-bs-toggle="dropdown">
                                
                                @if(Auth::user()->foto == '1.png')
                                    <img 
                                        src="{{ asset('assets/img/avatars/' . Auth::user()->foto) }}" 
                                        alt="avatar" 
                                        class="rounded-circle me-2 avatar"
                                        style="width: 36px; height: 36px; object-fit: cover;"
                                    />
                                @else
                                    <img 
                                        src="{{ asset('storage/uploads/avatars/' . Auth::user()->foto) }}" 
                                        alt="avatar" 
                                        class="rounded-circle me-2 avatar"
                                        style="width: 36px; height: 36px; object-fit: cover;"
                                    />
                                @endif
                                
                                <span class="text-dark fw-medium">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" 
                                aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profil_security.index') }}">
                                        <i class="bi bi-person me-2"></i> Profil Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profil_security.index') }}">
                                        <i class="bi bi-gear me-2"></i> Pengaturan
                                    </a>
                                </li>
                                @if(auth()->user()->hasRole('Super Admin|Admin'))
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Dashboard Admin
                                    </a>
                                </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                        @csrf
                                        <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm me-2">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-person-plus me-1"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
            
            <!-- Mobile Menu Button -->
            <button class="navbar-toggler border-0 d-lg-none" type="button" 
                    data-bs-toggle="offcanvas" data-bs-target="#mobileSideNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    
    <!-- Mobile Side Navigation (Offcanvas) -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileSideNav" 
         aria-labelledby="mobileSideNavLabel">
        <div class="offcanvas-header border-bottom">
            <div class="d-flex align-items-center">
                <img 
                    src="{{ asset('storage/' . settings()['favicon']) }}" 
                    alt="Logo"
                    style="height: 40px; width: auto;"
                    class="me-3"
                >
                <div>
                    <h5 class="offcanvas-title fw-bold mb-0" id="mobileSideNavLabel">
                        {{ settings()['title'] ?? 'MyApp' }}
                    </h5>
                    <small class="text-muted">Navigation Menu</small>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        
        <div class="offcanvas-body p-0">
            <!-- User Info (if logged in) -->
            @auth
                <div class="bg-light p-4 border-bottom">
                    <div class="d-flex align-items-center">
                        @if(Auth::user()->foto == '1.png')
                            <img 
                                src="{{ asset('assets/img/avatars/' . Auth::user()->foto) }}" 
                                alt="avatar" 
                                class="rounded-circle me-3"
                                style="width: 50px; height: 50px; object-fit: cover;"
                            />
                        @else
                            <img 
                                src="{{ asset('storage/uploads/avatars/' . Auth::user()->foto) }}" 
                                alt="avatar" 
                                class="rounded-circle me-3"
                                style="width: 50px; height: 50px; object-fit: cover;"
                            />
                        @endif
                        <div>
                            <h6 class="mb-1">{{ Auth::user()->name }}</h6>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Mobile Navigation Links -->
            <nav class="nav flex-column">
                <div class="nav-header p-3 bg-light">
                    <small class="text-uppercase text-muted">Main Menu</small>
                </div>
                
                <!-- Home -->
                <a class="nav-link d-flex align-items-center py-3 px-4 border-bottom" 
                   href="{{ Request::is('/') ? '#hero' : route('home') . '#hero' }}">
                    <div class="nav-icon-wrapper bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bi bi-house text-primary"></i>
                    </div>
                    <div>
                        <span class="fw-medium">Home</span>
                        <small class="text-muted d-block">Halaman utama</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
                
                <!-- Profil -->
                <a class="nav-link d-flex align-items-center py-3 px-4 border-bottom" 
                   href="{{ Request::is('/') ? '#profil' : route('home') . '#profil' }}"">
                    <div class="nav-icon-wrapper bg-info bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bi bi-info-circle text-info"></i>
                    </div>
                    <div>
                        <span class="fw-medium">Profil</span>
                        <small class="text-muted d-block">Profil organisasi</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
                
                <!-- Struktur -->
                <a class="nav-link d-flex align-items-center py-3 px-4 border-bottom" 
                   href="{{ Request::is('/') ? '#struktur' : route('home') . '#struktur' }}">
                    <div class="nav-icon-wrapper bg-success bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bi bi-diagram-3 text-success"></i>
                    </div>
                    <div>
                        <span class="fw-medium">Struktur</span>
                        <small class="text-muted d-block">Struktur organisasi</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
                
                <!-- Gallery -->
                <a class="nav-link d-flex align-items-center py-3 px-4 border-bottom" 
                  href="{{ Request::is('/') ? '#gallery' : route('home') . '#gallery' }}">
                    <div class="nav-icon-wrapper bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bi bi-images text-warning"></i>
                    </div>
                    <div>
                        <span class="fw-medium">Gallery</span>
                        <small class="text-muted d-block">Koleksi foto</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
                
                <!-- Kegiatan -->
                <a class="nav-link d-flex align-items-center py-3 px-4 border-bottom" 
                   href="{{ Request::is('/') ? '#events' : route('home') . '#events' }}">
                    <div class="nav-icon-wrapper bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bi bi-calendar-event text-danger"></i>
                    </div>
                    <div>
                        <span class="fw-medium">Kegiatan</span>
                        <small class="text-muted d-block">Acara & kegiatan</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
                
                <!-- Kontak -->
                <a class="nav-link d-flex align-items-center py-3 px-4 border-bottom" 
                    href="{{ Request::is('/') ? '#contact' : route('home') . '#contact' }}">
                    <div class="nav-icon-wrapper bg-dark bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bi bi-envelope text-dark"></i>
                    </div>
                    <div>
                        <span class="fw-medium">Kontak</span>
                        <small class="text-muted d-block">Hubungi kami</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
                
                <!-- Menu untuk User yang Login -->
                @auth
                    <div class="nav-header p-3 bg-light mt-2">
                        <small class="text-uppercase text-muted">Akun Saya</small>
                    </div>
                    
                    <!-- Profil Saya -->
                    <a class="nav-link d-flex align-items-center py-3 px-4 border-bottom" 
                       href="{{ route('profil_security.index') }}">
                        <div class="nav-icon-wrapper bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-person text-primary"></i>
                        </div>
                        <div>
                            <span class="fw-medium">Profil Saya</span>
                        </div>
                        <i class="bi bi-chevron-right ms-auto text-muted"></i>
                    </a>
                    
                    <!-- Pengaturan -->
                    <a class="nav-link d-flex align-items-center py-3 px-4 border-bottom" 
                       href="{{ route('profil_security.index') }}">
                        <div class="nav-icon-wrapper bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-gear text-primary"></i>
                        </div>
                        <div>
                            <span class="fw-medium">Pengaturan</span>
                        </div>
                        <i class="bi bi-chevron-right ms-auto text-muted"></i>
                    </a>
                    
                    <!-- Dashboard Admin (jika admin) -->
                    @if(auth()->user()->hasRole('Super Admin|Admin'))
                    <a class="nav-link d-flex align-items-center py-3 px-4 border-bottom" 
                       href="{{ route('dashboard') }}">
                        <div class="nav-icon-wrapper bg-success bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-speedometer2 text-success"></i>
                        </div>
                        <div>
                            <span class="fw-medium">Dashboard Admin</span>
                        </div>
                        <i class="bi bi-chevron-right ms-auto text-muted"></i>
                    </a>
                    @endif
                    
                @else
                    <!-- Menu untuk Guest -->
                    <div class="nav-header p-3 bg-light mt-2">
                        <small class="text-uppercase text-muted">Akun</small>
                    </div>
                    
                    <!-- Login -->
                    <a class="nav-link d-flex align-items-center py-3 px-4 border-bottom" 
                       href="{{ route('login') }}">
                        <div class="nav-icon-wrapper bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-box-arrow-in-right text-primary"></i>
                        </div>
                        <div>
                            <span class="fw-medium">Login</span>
                        </div>
                        <i class="bi bi-chevron-right ms-auto text-muted"></i>
                    </a>
                    
                    <!-- Register -->
                    <a class="nav-link d-flex align-items-center py-3 px-4 border-bottom" 
                       href="{{ route('register') }}">
                        <div class="nav-icon-wrapper bg-success bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-person-plus text-success"></i>
                        </div>
                        <div>
                            <span class="fw-medium">Register</span>
                        </div>
                        <i class="bi bi-chevron-right ms-auto text-muted"></i>
                    </a>
                @endauth
            </nav>
            
            <!-- Mobile Auth Actions - Logout -->
            @auth
                <div class="p-3 border-top">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</header>

<!-- SPACER - TAMBAHKAN DI BAWAH HEADER DI LAYOUT UTAMA -->
<div class="header-spacer"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Navbar Scroll Effect
    const navbar = document.querySelector('.navbar');
    const headerSpacer = document.querySelector('.header-spacer');
    
    function updateNavbar() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
    
    // Initialize
    updateNavbar();
    
    // Update on scroll
    window.addEventListener('scroll', updateNavbar);
    
    // Offcanvas navigation handling
    const mobileSideNav = document.getElementById('mobileSideNav');
    if (mobileSideNav) {
        const offcanvas = bootstrap.Offcanvas.getOrCreateInstance(mobileSideNav);
        
        mobileSideNav.querySelectorAll('a.nav-link').forEach(link => {
            link.addEventListener('click', function (e) {
                const hash = this.hash || this.getAttribute('href')?.split('#')[1];
                const isHome = window.location.pathname === '/';
                
                if (hash) {
                    e.preventDefault();
                    
                    offcanvas.hide();
                    
                    offcanvas._element.addEventListener(
                        'hidden.bs.offcanvas',
                        function handler() {
                            offcanvas._element.removeEventListener('hidden.bs.offcanvas', handler);
                            
                            if (isHome) {
                                const target = document.querySelector(`#${hash}`);
                                if (target) {
                                    // Wait a bit for offcanvas to fully hide
                                    setTimeout(() => {
                                        target.scrollIntoView({
                                            behavior: 'smooth',
                                            block: 'start'
                                        });
                                    }, 100);
                                }
                            } else {
                                window.location.href = `/${hash}`;
                            }
                        }
                    );
                }
            });
        });
    }
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            container: 'body'
        });
    });
});
</script>