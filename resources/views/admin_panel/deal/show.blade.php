<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $deal->title }} - Deal Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <!-- Header -->
    <nav class="navbar navbar-light bg-light justify-content-between px-4">
        <a class="navbar-brand">Deals</a>
        <a href="{{ route('deals.cart') }}" class="btn btn-outline-primary">
            🛒 Cart ({{ session('cart') ? count(session('cart')) : 0 }})
        </a>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <!-- Deal Image -->
            <div class="col-md-5">
                <img src="{{ asset('storage/' . $deal->image) }}" class="img-fluid rounded" alt="deal-image">
            </div>

            <!-- Deal Info -->
            <div class="col-md-7">
                <h2>{{ $deal->title }}</h2>
                <p>{{ $deal->description }}</p>
                <p><strong>Duration:</strong> {{ $deal->duration }}</p>
                <h4 class="text-success">Rs. {{ number_format($deal->price) }}</h4>

                <!-- Add to Cart -->
                <form action="{{ route('deals.addToCart', $deal->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>

                <!-- Buy Now Button -->
                <button class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#buyNowModal">Buy Now</button>
            </div>
        </div>
    </div>

    <!-- Buy Now Modal -->
    <div class="modal fade" id="buyNowModal" tabindex="-1" aria-labelledby="buyNowModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form action="{{ route('deals.checkout') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientInfoModalLabel">Enter Your Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> {{-- X Button --}}
                </div>
                <div class="modal-body">
                    <input type="hidden" name="deal_id" value="{{ $deal->id }}">
                    <div class="mb-3">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success w-100">Confirm Order</button>
                </div>
            </div>
        </form>
      </div>
    </div>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
