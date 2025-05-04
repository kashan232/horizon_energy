@include('admin_panel.include.header_include')
<style>
    .btn i {
        font-size: 16px;
        padding: 0px 20px;
    }
</style>

<body>
    <div class="page-wrapper default-version">

        @include('admin_panel.include.sidebar_include')
        @include('admin_panel.include.navbar_include')
     
        
        <div class="body-wrapper">
            <div class="bodywrapper__inner">
               <!-- Filter Section -->
<div class="card mb-4 shadow-sm border-0">
    <div class="card-body">
        <form method="GET" action="{{ route('vendor') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="vendor_id" class="form-label fw-semibold">Vendor Name</label>
                    <select name="vendor_id" id="vendor_id" class="form-select">
                        <option value="">-- All Vendors --</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="order_id" class="form-label fw-semibold">Order (ID - Name)</label>
                    <select name="order_id" id="order_id" class="form-select select2">
                        <option value="">-- All Orders --</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->id }}" {{ request('order_id') == $order->id ? 'selected' : '' }}>
                                #{{ $order->id }} - {{ $order->customer_name ?? 'Unknown Vendor' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="payment_status" class="form-label fw-semibold">Payment Status</label>
                    <select name="payment_status" id="payment_status" class="form-select">
                        <option value="">-- All --</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="remaining" {{ request('payment_status') == 'remaining' ? 'selected' : '' }}>Remaining</option>
                    </select>
                </div>

                <div class="col-md-3 text-center mt-2">
                    <div class="d-flex justify-content-center gap-2">
                        <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" title="Apply Filters">
                            <i class="fas fa-filter"></i>
                        </button>
                        <a href="{{ route('vendor') }}" class="btn btn-secondary" data-bs-toggle="tooltip" title="Reset Filters">
                            <i class="fas fa-redo-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Header with Action Button -->
<div class="d-flex justify-content-between align-items-center mb-4 px-1">
    <h5 class="mb-0 fw-bold">All Assigning Orders</h5>
    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#assignOrderModal">
        Assign Order to Vendor
    </button>
</div>

                

                <!-- Ledger Table -->
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                <div class="table-responsive--sm table-responsive">
                                    <table class="table--light style--two table">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Vendor Name</th>
                                                <th>Order ID</th>
                                                <th>Total Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Remaining Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ledgers as $ledger)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $ledger->vendor->name }}</td>
                                                    <td>Order #{{ $ledger->order_id }}</td>
                                                    <td>{{ $ledger->total_amount }}</td>
                                                    <td>{{ $ledger->paid_amount }}</td>
                                                    <td>{{ $ledger->remaining_amount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="p-3">
                                        {{ $ledgers->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->

    </div><!-- page-wrapper end -->

    <!-- Modal -->
    <div class="modal fade" id="assignOrderModal" tabindex="-1" aria-labelledby="assignOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form method="POST" action="{{ route('store-vendor') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignOrderModalLabel">Assign Order to Vendor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="vendor_id" class="form-label">Select Vendor</label>
                                <select id="vendor_id" name="vendor_id" class="form-select" required>
                                    <option value="">Select Vendor</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->name }} ({{ $vendor->role }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('vendor_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="order_id" class="form-label">Select Order</label>
                                <select id="modal_order_id" name="order_id" class="form-select" required onchange="fillOrderDetails()">
                                    <option value="">Select Order</option>
                                    @foreach ($orders as $order)
                                        <option 
                                            value="{{ $order->id }}" 
                                            data-client="{{ $order->customer_name }}" 
                                            data-address="{{ $order->Venue }}" 
                                            data-size="{{ $order->system_size }}"
                                            {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                            Order #{{ $order->id }} - {{ $order->customer_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('order_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Client Name</label>
                                <input type="text" id="client_name" class="form-control" readonly>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">System Size</label>
                                <input type="text" id="system_size" class="form-control" readonly>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Address</label>
                                <input type="text" id="address" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Total Amount</label>
                                <input type="text" id="total_amount_formatted" class="form-control" required value="{{ old('total_amount') }}">
                                <input type="hidden" name="total_amount" id="total_amount">
                                @error('total_amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Paid Amount</label>
                                <input type="text" id="paid_amount_formatted" class="form-control" required value="{{ old('paid_amount') }}">
                                <input type="hidden" name="paid_amount" id="paid_amount">
                                @error('paid_amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Remaining Amount</label>
                                <input type="text" id="remaining_amount_formatted" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Give Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('admin_panel.include.footer_include')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            function unformatNumber(str) {
                return str.replace(/,/g, '');
            }

            window.fillOrderDetails = function () {
    const selected = document.getElementById('modal_order_id').selectedOptions[0];
    document.getElementById('client_name').value = selected.getAttribute('data-client') || '';
    document.getElementById('system_size').value = selected.getAttribute('data-size') || '';
    document.getElementById('address').value = selected.getAttribute('data-address') || '';
}


            function calculateRemaining() {
                const total = parseFloat(unformatNumber(document.getElementById('total_amount_formatted').value)) || 0;
                const paid = parseFloat(unformatNumber(document.getElementById('paid_amount_formatted').value)) || 0;
                const remaining = total - paid;

                document.getElementById('total_amount').value = total;
                document.getElementById('paid_amount').value = paid;
                document.getElementById('remaining_amount_formatted').value = formatNumber(remaining.toFixed(2));
            }

            function formatInput(e) {
                const value = unformatNumber(e.target.value);
                if (!isNaN(value)) {
                    e.target.value = formatNumber(value);
                    calculateRemaining();
                }
            }

            document.getElementById('total_amount_formatted').addEventListener('input', formatInput);
            document.getElementById('paid_amount_formatted').addEventListener('input', formatInput);
        });
    </script>

</body>
