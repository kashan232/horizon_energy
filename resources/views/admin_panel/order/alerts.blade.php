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
                    <h6 class="page-title">Order Alerts</h6>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                <div class="table-responsive--md table-responsive">
                                    <table id="example" class="display table table--light style--two bg--white" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Order Name</th>
                                                <th>Customer Name</th>
                                                <th>Event Type</th>
                                                <th>Venue</th>
                                                <th>Delivery Date</th>
                                                <th>Delivery Time</th>
                                                <th>Alert Before Days</th>
                                                <th>Remaining Days</th>
                                                <th>Status</th> <!-- New column -->
                                                <th>Action</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($order_items as $order_item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $order_item->order_name }}</td>
                                                    <td>{{ $order_item->customer_name }}</td>
                                                    <td>{{ $order_item->event_type }}</td>
                                                    <td>{{ $order_item->Venue }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($order_item->delivery_date)->format('d-m-Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($order_item->delivery_time)->format('h:i A') }}</td>
                                                    <td>
                                                        @if(!empty($order_item->alert_before_days))
                                                            <strong class="badge badge--info">{{ $order_item->alert_before_days }} Days</strong>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $today = \Carbon\Carbon::today();
                                                            $deliveryDate = \Carbon\Carbon::parse($order_item->delivery_date);
                                                            $remainingDays = $today->diffInDays($deliveryDate, false);
                                                        @endphp
                                                        {{ $remainingDays }} days
                                                    </td>
                                                    <td>
                                                        @if($order_item->status == 'pending')
                                                            <span class="badge badge--warning">Pending</span>
                                                        @elseif($order_item->status == 'working')
                                                            <span class="badge badge--primary">Working</span>
                                                        @elseif($order_item->status == 'delivered')
                                                            <span class="badge badge--success">Delivered</span>
                                                        @elseif($order_item->status == 'cancelled')
                                                            <span class="badge badge--danger">Cancelled</span>
                                                        @else
                                                            <span class="badge badge--secondary">Unknown</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <select class="form-control status-change"  data-id="{{ $order_item->id }}">
                                                            <option selected >Change Status</option>
                                                            <option value="working">Start Work</option>
                                                            <option value="delivered">Delivered</option>
                                                            <option value="cancelled">Cancelled</option>
                                                        </select>
                                                        
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center" colspan="11">
                                                        No Order Alerts Found
                                                    </td>
                                                </tr>
                                            @endforelse
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusSelectors = document.querySelectorAll('.status-change');

        statusSelectors.forEach(function(selector) {
            selector.addEventListener('change', function() {
                const orderId = this.getAttribute('data-id');
                const status = this.value;

                if (status) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to change the status of this order?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, update it!',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post('{{ route('order.updateStatus') }}', {
                                order_id: orderId,
                                status: status
                            }).then(function(response) {
                                if (response.data.success) {
                                    Swal.fire(
                                        'Updated!',
                                        'Status has been updated successfully.',
                                        'success'
                                    );
                                    location.reload(); // Refresh page after update
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Something went wrong. Please try again.',
                                        'error'
                                    );
                                }
                            }).catch(function(error) {
                                console.error(error);
                                Swal.fire(
                                    'Error!',
                                    'There was an error while updating the status.',
                                    'error'
                                );
                            });
                        }
                    });
                }
            });
        });
    });

    
</script>




@include('admin_panel.include.footer_include')
</body>
