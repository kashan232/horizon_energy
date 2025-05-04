<!-- meta tags and other links -->
@include('admin_panel.include.header_include')

<body>
    <!-- page-wrapper start -->
    <div class="page-wrapper default-version">
        @include('admin_panel.include.sidebar_include')
        <!-- sidebar end -->

        <!-- navbar-wrapper start -->
        @include('admin_panel.include.navbar_include')
        <!-- navbar-wrapper end -->

        <div class="body-wrapper">
            <div class="bodywrapper__inner">
                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">Online Order</h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                <div class="table-responsive--md table-responsive">
                                    <table id="example" class="display table table--light style--two bg--white" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Order Type</th>
                                                <th>Customer Name</th>
                                                <th>Advance</th>
                                                <th>Remaining</th>
                                                <th>Payable Amount</th>
                                                <th>Discount</th>
                                                <th>Total Amount</th>
                                                <th>Order Items</th>
                                                <th>Status</th>
                                                <th>Payment Status</th>
                                                <th>Order Date</th>
                                                <th>Program Date</th>
                                                <th>Program Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr>
                                                <td>
                                                    @php
                                                    $statusColors = [
                                                    'System Order' => 'bg-success',
                                                    'Online Order' => 'bg-primary',
                                                    ];
                                                    @endphp
                                                    <span class="badge {{ $statusColors[$order->order_type] ?? 'bg-dark' }}">
                                                        {{ ucfirst($order->order_type) }}
                                                    </span>
                                                </td>
                                                <td class="long-text">
                                                    <span class="fw-bold text--primary">{{ $order->customer_name }}</span>
                                                </td>
                                                <td>{{ number_format($order->advance_paid, 2) }}</td>
                                                <td>{{ number_format($order->remaining_amount, 2) }}</td>
                                                <td>{{ number_format($order->payable_amount, 2) }}</td>
                                                <td>{{ number_format($order->discount, 2) }}</td>
                                                <td>{{ number_format($order->total_price, 2) }}</td>
                                                <td>
                                                    @php
                                                    $items = json_decode($order->item_name, true);
                                                    @endphp
                                                    @if(is_array($items))
                                                    {{ implode(', ', $items) }}
                                                    @else
                                                    {{ $order->item_name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                    $statusColors = [
                                                    'Pending' => 'bg-danger',
                                                    'Confirmed' => 'bg-warning',
                                                    'Preparing' => 'bg-info',
                                                    'Delivered' => 'bg-success',
                                                    'Cancelled' => 'bg-secondary'
                                                    ];
                                                    @endphp
                                                    <span class="badge {{ $statusColors[$order->order_status] ?? 'bg-dark' }}">
                                                        {{ ucfirst($order->order_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @php
                                                    $statusColors = [
                                                    'Paid' => 'bg-success',
                                                    'Unpaid' => 'bg-danger',
                                                    ];
                                                    @endphp
                                                    <span class="badge {{ $statusColors[$order->payment_status] ?? 'bg-dark' }}">
                                                        {{ ucfirst($order->payment_status) }}
                                                    </span>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($order->sale_date)->format('d M Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</td>
                                                <td>{{ ($order->delivery_time)}}</td>
                                                <td>
                                                    <a href="{{ route('invoice.show', $order->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-file-invoice"></i> Invoice
                                                    </a>
                                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#paymentModal"
                                                        data-id="{{ $order->id }}"
                                                        data-remaining="{{ $order->remaining_amount }}"
                                                        data-paid="{{ $order->advance_paid }}">
                                                        <i class="fas fa-dollar-sign"></i> Payment
                                                    </button>
                                                    <a href="{{ route('Voucher.show', $order->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-file-invoice"></i> Payment Voucher
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <!-- table end -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Make Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="paymentForm">
                        @csrf
                        <input type="hidden" id="order_id" name="order_id">

                        <div class="mb-3">
                            <label for="remaining_amount" class="form-label">Remaining Amount</label>
                            <input type="text" class="form-control" id="remaining_amount" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="paid_amount" class="form-label">Paid Amount</label>
                            <input type="number" class="form-control" id="paid_amount" name="paid_amount">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @include('admin_panel.include.footer_include')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var paymentModal = document.getElementById("paymentModal");

            paymentModal.addEventListener("show.bs.modal", function(event) {
                var button = event.relatedTarget;
                var orderId = button.getAttribute("data-id");
                var remainingAmount = parseFloat(button.getAttribute("data-remaining")) || 0;

                document.getElementById("order_id").value = orderId;
                document.getElementById("remaining_amount").value = remainingAmount.toFixed(2);
                document.getElementById("original_remaining").value = remainingAmount.toFixed(2); // Hidden Field
                document.getElementById("paid_amount").value = "";
            });

            document.getElementById("paid_amount").addEventListener("input", function() {
                var originalRemaining = parseFloat(document.getElementById("original_remaining").value); // Safe value
                var paid = parseFloat(this.value) || 0;
                var newRemaining = originalRemaining - paid;

                document.getElementById("remaining_amount").value = newRemaining >= 0 ? newRemaining.toFixed(2) : "0.00";
            });

            document.getElementById("paymentForm").addEventListener("submit", function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                fetch("{{ route('order.payment') }}", {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector("input[name='_token']").value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Payment Successfully Updated");
                            location.reload();
                        } else {
                            alert("Error: " + data.message);
                        }
                    });
            });
        });
    </script>