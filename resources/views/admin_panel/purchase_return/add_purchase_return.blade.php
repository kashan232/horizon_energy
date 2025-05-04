@include('admin_panel.include.header_include')

<body>
    <div class="page-wrapper default-version">

        @include('admin_panel.include.sidebar_include')
        @include('admin_panel.include.navbar_include')

        <div class="body-wrapper">
            <div class="bodywrapper__inner">

                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">Add Purchase Return</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                        <a href="#" class="btn btn-sm btn-outline--primary">
                            <i class="la la-undo"></i> Back</a>
                    </div>
                </div>

                <div class="row gy-3">
                    <div class="col-lg-12 col-md-12 mb-30">
                        <div class="card">
                            <div class="card-body">
                                @if (session()->has('success'))
                                <div class="alert alert-success">
                                    <strong>Success!</strong> {{ session('success') }}.
                                </div>
                                @endif
                                <form action="{{ route('store-purchase-return') }}" method="POST">
                                    @csrf
                                    <!-- Invoice and Supplier Info -->
                                    <div class="row mb-3">
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="form-group">
                                                <label>Invoice No:</label>
                                                <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                                                <input type="text" name="invoice_no" class="form-control" value="{{ $purchase->invoice_no }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">Supplier</label>
                                                <input type="text" name="supplier" class="form-control" value="{{ $purchase->supplier }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input name="return_date" type="date" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">Warehouse</label>
                                                <input type="text" name="warehouse" class="form-control" value="{{ $purchase->warehouse_id }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product Items List -->
                                    <div class="row mb-3">
                                        <div class="table-responsive">
                                            <table class="table border">
                                                <thead class="border bg--dark">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Purchase Quantity</th>
                                                        <th>Stock Quantity</th>
                                                        <th>Return Quantity</th>
                                                        <th>Price (Per Unit)</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="purchaseItems">
                                                    @foreach($itemNames as $index => $itemName)
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="item_name[]" value="{{ $itemName }}">
                                                            {{ $itemName }}
                                                        </td> <!-- Item Name -->
                                                        <td>{{ $quantities[$index] }}</td> <!-- Purchase Quantity -->
                                                        <td>{{ $stocks[$index] }}</td> <!-- Stock Quantity -->
                                                        <td>
                                                            <input type="number" name="return_qty[]" class="form-control return-quantity" value="0" min="0" max="{{ $stocks[$index] }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="price[]" class="form-control price" value="{{ $prices[$index] }}" readonly>
                                                        </td> <!-- Price per unit -->
                                                        <td>
                                                            <input type="number" name="total[]" class="form-control total" value="0" readonly>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5" class="text-end"><strong>Subtotal:</strong></td>
                                                        <td>
                                                            <input type="number" name="subtotal" class="form-control total_price" readonly>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Final Calculation -->
                                    <div class="row">
                                        <div class="col-md-8 col-sm-6">
                                            <div class="form-group">
                                                <label>Note</label>
                                                <textarea name="note" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Discount</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" name="discount" class="form-control" step="any">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Payable Amount</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" name="payable_amount" class="form-control payable_amount" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn--primary w-100 h-45">Submit Return</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->

    </div>

    @include('admin_panel.include.footer_include')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const purchaseItems = document.getElementById('purchaseItems');

            // Calculate total price and subtotal
            purchaseItems.addEventListener('input', function(e) {
                if (e.target.classList.contains('return-quantity')) {
                    const row = e.target.closest('tr');
                    const returnQty = parseFloat(e.target.value) || 0;
                    const price = parseFloat(row.querySelector('input[name="price[]"]').value) || 0;
                    const total = row.querySelector('input[name="total[]"]');

                    total.value = (returnQty * price).toFixed(2);
                    calculateTotalPrice();
                }
            });

            function calculateTotalPrice() {
                let subtotal = 0;
                document.querySelectorAll('input[name="total[]"]').forEach(function(input) {
                    subtotal += parseFloat(input.value) || 0;
                });
                document.querySelector('input[name="subtotal"]').value = subtotal.toFixed(2);
                document.querySelector('input[name="payable_amount"]').value = subtotal.toFixed(2);
            }
        });
    </script>
</body>