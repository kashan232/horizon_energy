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
                    <h6 class="page-title">All Menu Estimate</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                        <a href="{{ route('add-menu') }}" class="btn btn-outline--primary">
                            <i class="la la-plus"></i>Add New 
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                <div class="table-responsive--md table-responsive">
                                    <table id="example" class="display table table--light style--two bg--white" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Estimate ID</th>
                                                <th>Customer Name</th>
                                                <th>Total Amount</th>
                                                <th>Order Items</th>
                                                <th>Order Date</th>
                                                <th>Status</th> <!-- ADD Status Column -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr>
                                                <td class="long-text">
                                                    <span class="fw-bold text--primary">{{ $order->id }}</span>
                                                </td>
                                                <td class="long-text">
                                                    <span class="fw-bold text--primary">{{ $order->customer_name }}</span>
                                                </td>
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
                                                <td>{{ \Carbon\Carbon::parse($order->sale_date)->format('d M Y') }}</td>
                                                <td>
                                                    @if($order->status == 1)
                                                        <span class="badge bg-success">Confirmed</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($order) && isset($order->id))
                                                    <a href="{{ route('menu.invoice.show', $order->id) }}" class="btn btn-primary btn-sm mb-1">
                                                        <i class="fas fa-file-invoice"></i> Invoice
                                                    </a>
                                                @endif
                                                
                                                    @if($order->status != 1)
                                                    <a href="javascript:void(0)" 
                                                        class="btn btn-success btn-sm confirm-order-btn" 
                                                        data-id="{{ $order->id }}">
                                                        <i class="fas fa-check"></i> Confirm Order
                                                    </a>
                                                    @else
                                                    <button class="btn btn-secondary btn-sm" disabled>
                                                        <i class="fas fa-check"></i> Order Confirmed
                                                    </button>
                                                    @endif
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('.confirm-order-btn').click(function() {
        var estimateId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to confirm this order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Confirm!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('menu.confirm.order') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        estimate_id: estimateId
                    },
                    success: function(response) {
                        if(response.status == 'success') {
                            Swal.fire(
                                'Confirmed!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload(); // Refresh page after success
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,
                                'error'
                            );
                        }
                    }
                });
            }
        });
    });
});
</script>

@include('admin_panel.include.footer_include')
