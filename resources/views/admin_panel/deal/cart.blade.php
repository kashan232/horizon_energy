@php
    $clientInfo = session('client_info');
    $cart = session('cart', []);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Your Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container py-5">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="d-flex justify-content-between ">
        <a href="{{ url('/all-deals') }}" class="btn  btn-lg">⬅️ Back to Deals</a>
        <h2 class="mb-4">🛒 Review Your Order</h2>
    </div>

    {{-- Client Info --}}
    @if($clientInfo)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <strong>Client Information</strong>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $clientInfo['name'] }}</p>
                <p><strong>Phone:</strong> {{ $clientInfo['phone'] }}</p>
                <p><strong>Email:</strong> {{ $clientInfo['email'] }}</p>
            </div>
        </div>
    @endif

    {{-- Cart Items --}}
    <h4 class="mb-3">🧺 Cart Items</h4>

    @if(count($cart) > 0)
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Deal</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th>Action</th> {{-- Action column add kiya --}}
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($cart as $id => $item)
                @php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $item['title'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>Rs {{ number_format($item['price']) }}</td>
                    <td>Rs {{ number_format($subtotal) }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this item?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
    
            {{-- Total Row --}}
            <tr class="table-primary">
                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                <td><strong>Rs {{ number_format($total) }}</strong></td>
            </tr>
        </tbody>
    </table>


        {{-- Place Order --}}
        <form action="{{ route('cart.place-order') }}" method="POST" class="mt-4">
            @csrf
            <button class="btn btn-success btn-lg">🚀 Place Order</button>
        </form>

    @else
        <div class="alert alert-info">
            Your cart is empty.
        </div>
    @endif

</div>

{{-- Client Info Modal --}}
<div class="modal fade" id="clientInfoModal" tabindex="-1" aria-labelledby="clientInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('client.info.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="clientInfoModalLabel">Enter Your Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> {{-- X Button --}}
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Info</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@if(!$clientInfo)
<script>
    // Automatically show modal if client info missing
    var myModal = new bootstrap.Modal(document.getElementById('clientInfoModal'), {
        backdrop: 'static',
        keyboard: false
    });
    myModal.show();
</script>
@endif

</body>
</html>
