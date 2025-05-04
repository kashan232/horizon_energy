<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deals - Horizon Energy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        body {
            background: #f7f9fc;
        }
        .card {
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .carousel-item img {
            height: 500px;
            object-fit: cover;
        }
    </style>
</head>

@php
    $clientInfo = session('client_info');
@endphp

<body @if(!$clientInfo) onload="showClientModal()" @endif>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">Horizon Energy</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active fw-bold" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="#deals">Deals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="{{ route('cart.show') }}">🛒 Cart ({{ count(session('cart', [])) }})</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<!-- Hero Section (Swiper Slider) -->
<section class="hero-section mb-5">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">

            <!-- Slide 1 -->
            <div class="swiper-slide">
                <a href="#deals">
                    <img src="{{ asset('assets/admin/images/bg-1.png') }}" class="w-100" alt="Solar Image 1" style="height: 500px; object-fit: cover;">
                </a>
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide">
                <a href="#deals">
                    <img src="{{ asset('assets/admin/images/bg-2.png') }}" class="w-100" alt="Solar Image 2" style="height: 500px; object-fit: cover;">
                </a>
            </div>

            <!-- Slide 3 -->
            <div class="swiper-slide">
                <a href="#deals">
                    <img src="{{ asset('assets/admin/images/bg-3.png') }}" class="w-100" alt="Solar Image 3" style="height: 500px; object-fit: cover;">
                </a>
            </div>

        </div>

        <!-- Navigation buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

        <!-- Pagination dots -->
        <div class="swiper-pagination"></div>
    </div>
</section>


<!-- Deals Section -->
<main class="container">

    <!-- Client Info Modal -->
    <div class="modal fade" id="clientInfoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientInfoModalLabel">Enter Your Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> {{-- X Button --}}
                </div>
                <form method="POST" action="{{ route('client.info.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter your phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Save Info</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <h2 class="text-center mb-4 fw-bold text-primary">Available Deals</h2>

    <div class="row">
        @forelse($deals as $deal)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <img src="{{ asset('storage/' . $deal->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $deal->title }}</h5>
                        <p class="card-text fw-bold">Rs. {{ number_format($deal->price) }}</p>
                        <form method="POST" action="{{ route('cart.add', $deal->id) }}" onsubmit="return checkClientInfo(event)">
                            @csrf
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">No deals available at the moment.</p>
        @endforelse
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function showClientModal() {
    var clientInfo = @json($clientInfo);
    if (!clientInfo) {
        var myModal = new bootstrap.Modal(document.getElementById('clientInfoModal'));
        myModal.show();
    }
}

function checkClientInfo(event) {
    var clientInfo = @json($clientInfo);
    if (!clientInfo) {
        event.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById('clientInfoModal'));
        myModal.show();
        return false;
    }
    return true;
}
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>

</body>
</html>
