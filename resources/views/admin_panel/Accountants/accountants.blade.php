@include('admin_panel.include.header_include')

<body>
    <!-- page-wrapper start -->
    <div class="page-wrapper default-version">

        <!-- sidebar start -->

        @include('admin_panel.include.sidebar_include')
        <!-- sidebar end -->

        <!-- navbar-wrapper start -->
        @include('admin_panel.include.navbar_include')
        <!-- navbar-wrapper end -->

        <div class="body-wrapper">
            <div class="bodywrapper__inner">

                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">All Accountant</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">

                        <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="Add New Accountant">
                            <i class="las la-plus"></i>Add New </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                @if (session()->has('success'))
                                <div class="alert alert-success">
                                    <strong>Success!</strong> {{ session('success') }}.
                                </div>
                                @endif
                                <div class="table-responsive--sm table-responsive">
                                    <table id="example" class="display table table--light style--two" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Name</th>
                                                <th>CNIC</th>
                                                <th>Number</th>
                                                <th>Address</th>
                                                <th>User Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Accountants as $Account)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $Account->name }}</td>
                                                <td>{{ $Account->Cnic }}</td>
                                                <td>{{ $Account->Number }}</td>
                                                <td>{{ $Account->Address }}</td>
                                                <td>
                                                    <span class="badge badge--success">{{ $Account->usertype }}</span>
                                                </td>
                                                <td>
                                                    <div class="button--group">
                                                        <button type="button" class="btn btn-sm btn-outline--primary editCategoryBtn"
                                                            data-toggle="modal" data-target="#editAccountantModal"
                                                            data-id="{{ $Account->id }}"
                                                            data-name="{{ $Account->name }}"
                                                            data-cnic="{{ $Account->Cnic }}"
                                                            data-number="{{ $Account->Number }}"
                                                            data-address="{{ $Account->Address }}"
                                                            data-usertype="{{ $Account->usertype }}">
                                                            <i class="la la-pencil"></i> Edit
                                                        </button>

                                                        <button type="button" class="btn btn-sm btn-outline--success paymentBtn"
                                                            data-toggle="modal" data-target="#paymentModal"
                                                            data-id="{{ $Account->id }}"
                                                            data-name="{{ $Account->name }}">
                                                            <i class="la la-money"></i> Payment
                                                        </button>
                                                    </div>
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Create Update Modal -->
                <div class="modal fade" id="cuModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"></h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="las la-times"></i>
                                </button>
                            </div>

                            <form action="{{ route('store-Accountant') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Cnic</label>
                                        <input type="text" class="form-control" name="Cnic" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" name="Number" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="Address" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="usertype" class="form-control" required>
                                            <option disabled selected>Select One</option>
                                            <option value="Accountant">Accountant</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--primary w-100 h-45">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Accountant</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('update-Accountant') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="Accountant_id" id="Accountant_id">

                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" id="Accountant_name" required>
                                    </div>

                                    <div class="form-group">
                                        <label>CNIC</label>
                                        <input type="text" class="form-control" name="cnic" id="Accountant_cnic">
                                    </div>

                                    <div class="form-group">
                                        <label>Number</label>
                                        <input type="text" class="form-control" name="number" id="Accountant_number">
                                    </div>

                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" id="Accountant_address">
                                    </div>

                                    <div class="form-group">
                                        <label>User Type</label>
                                        <input type="text" class="form-control" name="usertype" id="Accountant_usertype">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--primary w-100 h-45">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="paymentModalLabel">Make Payment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('update-payment') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="accountant_id" id="paymentAccountantId">

                                    <div class="form-group">
                                        <label>Accountant Name</label>
                                        <input type="text" class="form-control" id="paymentAccountantName" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" class="form-control" name="payment_date" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" class="form-control" name="payment_amount" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--success w-100 h-45">Update Payment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->
    </div>
    @include('admin_panel.include.footer_include')

    <script>
        $(document).ready(function() {
            $('.editCategoryBtn').on('click', function() {
                $('#Accountant_id').val($(this).data('id'));
                $('#Accountant_name').val($(this).data('name'));
                $('#Accountant_cnic').val($(this).data('cnic'));
                $('#Accountant_number').val($(this).data('number'));
                $('#Accountant_address').val($(this).data('address'));
                $('#Accountant_usertype').val($(this).data('usertype'));
            });
        });

        $(document).on("click", ".paymentBtn", function() {
            var accountantId = $(this).data("id");
            var accountantName = $(this).data("name");

            $("#paymentAccountantId").val(accountantId);
            $("#paymentAccountantName").val(accountantName);
        });
    </script>