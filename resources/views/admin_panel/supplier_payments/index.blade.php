@include('admin_panel.include.header_include')

<body>
    <div class="page-wrapper default-version">
        @include('admin_panel.include.sidebar_include')

        @include('admin_panel.include.navbar_include')

        <div class="body-wrapper">
            <div class="bodywrapper__inner">

                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">All Payments</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                        <button type="button" class="btn btn-outline--primary cuModalBtn" data-modal_title="Add New Payment">
                            <i class="la la-plus"></i> Add New
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                @if (session()->has('success'))
                                    <div class="alert alert-success">
                                        <strong>Success!</strong> {{ session('success') }}
                                    </div>
                                @endif

                                <div class="table-responsive--sm table-responsive">
                                    <table id="example" class="display table table--light style--two bg--white" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Payment Date</th>
                                                <th>Amount</th>
                                                <th>Supplier</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($payments as $payment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $payment->payment_date }}</td>
                                                <td>{{ $payment->amount }}</td>
                                                <td>{{ $payment->supplier->name ?? 'N/A' }}</td>
                                                <td>
                                                    <div class="button--group">
                                                        <button type="button" class="btn btn-sm btn-outline--primary editPaymentBtn" data-payment-id="{{ $payment->id }}" data-payment-date="{{ $payment->payment_date }}" data-payment-amount="{{ $payment->amount }}" data-supplier-id="{{ $payment->supplier_id }}">
                                                            <i class="la la-pencil"></i>Edit
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table> <!-- table end -->
                                </div>
                            </div>
                        </div> <!-- card end -->
                    </div>
                </div>

                <!-- Add Payment Modal -->
                <div class="modal fade" id="cuModal">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Payment</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="las la-times"></i>
                                </button>
                            </div>
                            <form action="{{ route('payments.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Payment Date</label>
                                                <input type="date" name="payment_date" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Amount</label>
                                                <input type="number" name="amount" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Supplier</label>
                                                <select name="supplier_id" class="form-control" required>
                                                    <option value="">Select Supplier</option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> <!-- row end -->
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--primary w-100 h-45">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- Add Modal end -->

            </div> <!-- bodywrapper__inner end -->
        </div> <!-- body-wrapper end -->
    </div>

    @include('admin_panel.include.footer_include')

    <script>
        $(document).ready(function() {
            $('.editPaymentBtn').click(function() {
                var id = $(this).data('payment-id');
                var date = $(this).data('payment-date');
                var amount = $(this).data('payment-amount');
                var supplierId = $(this).data('supplier-id');

                // Open another modal for editing if needed
                // or fill the existing modal with values
            });
        });
    </script>
</body>
