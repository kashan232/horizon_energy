{{-- @extends('admin_panel.layouts.app')

@section('content') --}}

@include('admin_panel.include.header_include')

<div class="page-wrapper default-version">

    @include('admin_panel.include.sidebar_include')
    @include('admin_panel.include.navbar_include')

    <div class="body-wrapper">
        <div class="bodywrapper__inner">

            <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                <h6 class="page-title">Add Sales Return</h6>
                <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                    <a href="{{ route('Sale') }}" class="btn btn-sm btn-outline--primary">
                        <i class="la la-undo"></i> Back</a>
                </div>
            </div>

            <div class="row gy-3">
                <div class="col-lg-12 col-md-12 mb-30">
                    <div class="card">
                        <div class="card-body">
                            @if (session()->has('success'))
                            <div class="alert alert-success">
                                <strong>Success!</strong> {{ session('success') }}
                            </div>
                            @endif

                            <form action="{{ route('store-sales-return') }}" method="POST">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-xl-3 col-sm-6">
                                        <div class="form-group">
                                            <label>Invoice No:</label>
                                            <input type="hidden" name="sales_id" value="{{ $sale->id }}">
                                            <input type="text" name="invoice_no" class="form-control" value="{{ $sale->invoice_no }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6">
                                        <div class="form-group">
                                            <label>Customer</label>
                                            <input type="text" name="customer" class="form-control" value="{{ $sale->customer }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="date" name="return_date" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6">
                                        <div class="form-group">
                                            <label>Warehouse</label>
                                            <input type="text" name="warehouse" class="form-control" value="{{ $sale->warehouse_id }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="table-responsive">
                                        <table class="table border">
                                            <thead class="border bg--dark text-white">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Sold Quantity</th>
                                                    <th>Return Quantity</th>
                                                    <th>Price (Per Unit)</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="salesItems">
                                                @foreach($itemNames as $index => $itemName)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="item_name[]" value="{{ $itemName }}">
                                                        {{ $itemName }}
                                                    </td>
                                                    <td>{{ $quantities[$index] }}</td>
                                                    <td>
                                                        <input type="number" name="return_qty[]" class="form-control return-quantity" value="0" min="0" max="{{ $quantities[$index] }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="price[]" class="form-control" value="{{ $prices[$index] }}" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="total[]" class="form-control total" value="0" readonly>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                                    <td>
                                                        <input type="number" name="subtotal" class="form-control total_price" readonly>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea name="note" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Discount</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" name="discount" class="form-control discount" step="any">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Refund Amount</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" name="refund_amount" class="form-control payable_amount" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn--primary w-100 mt-3">Submit Sales Return</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- bodywrapper__inner end -->
    </div> <!-- body-wrapper end -->

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const salesItems = document.getElementById('salesItems');

        salesItems.addEventListener('input', function (e) {
            if (e.target.classList.contains('return-quantity')) {
                const row = e.target.closest('tr');
                const returnQty = parseFloat(e.target.value) || 0;
                const price = parseFloat(row.querySelector('input[name="price[]"]').value) || 0;
                const total = row.querySelector('input[name="total[]"]');
                total.value = (returnQty * price).toFixed(2);
                calculateTotals();
            }
        });

        document.querySelector('input[name="discount"]').addEventListener('input', calculateTotals);

        function calculateTotals() {
            let subtotal = 0;
            document.querySelectorAll('input[name="total[]"]').forEach(input => {
                subtotal += parseFloat(input.value) || 0;
            });

            document.querySelector('input[name="subtotal"]').value = subtotal.toFixed(2);

            const discount = parseFloat(document.querySelector('input[name="discount"]').value) || 0;
            const payable = subtotal - discount;
            document.querySelector('input[name="refund_amount"]').value = payable.toFixed(2);
        }
    });
</script>

@include('admin_panel.include.footer_include')


