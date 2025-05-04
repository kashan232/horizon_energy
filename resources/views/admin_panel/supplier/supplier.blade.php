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
                    <h6 class="page-title">All Suppliers</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                        <button type="button" class="btn btn-outline--primary cuModalBtn" data-modal_title="Add New Supplier">
                            <i class="la la-plus"></i>Add New </button>
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
                                    <table id="example" class="display  table table--light style--two bg--white" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Payable</th>
                                                <th>Receivable</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Suppliers as $Supplier)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $Supplier->name }}</td>
                                                <td>
                                                    <span class="fw-bold"> {{ $Supplier->mobile }} </span><br> <a href="#" class="__cf_email__">{{ $Supplier->email }}</a>
                                                </td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>
                                                    <div class="button--group">
                                                        <button type="button" class="btn btn-sm btn-outline--primary editCategoryBtn" data-toggle="modal" data-target="#exampleModal" data-supplier-id="{{ $Supplier->id }}" data-supplier-name="{{ $Supplier->name }}" data-supplier-email="{{ $Supplier->email }}" data-supplier-mobile="{{ $Supplier->mobile }}" data-supplier-company="{{ $Supplier->company_name }}" data-supplier-address="{{ $Supplier->address }}">
                                                            <i class="la la-pencil"></i>Edit </button>

                                                        <a href="#" class="btn btn-sm btn-outline--info">
                                                            <i class="las la-money-bill-wave-alt"></i>Payment </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table><!-- table end -->
                                </div>
                            </div>
                        </div><!-- card end -->
                    </div>
                </div>

                <div class="modal fade" id="cuModal">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"></h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="las la-times"></i>
                                </button>
                            </div>
                            <form action="{{ route('store-supplier') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control" autocomplete="off" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">E-Mail</label>
                                                <input type="email" class="form-control" name="email">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">Mobile <i class="fa fa-info-circle text--primary" title="Type the mobile number including the country code. Otherwise, SMS won't send to that number.">
                                                    </i>
                                                </label>
                                                <input type="number" name="mobile" value="" class="form-control " required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Company</label>
                                                <input type="text" name="company_name" class="form-control" autocomplete="off" value="">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" name="address" class="form-control" value="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--primary w-100 h-45">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Supplier</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('update-supplier') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="hidden" name="supplier_id" id="supplier_id">
                                                <input type="text" name="name" id="suplier_name" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">E-Mail</label>
                                                <input type="email" class="form-control" id="suplier_email" name="email">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">Mobile <i class="fa fa-info-circle text--primary" title="Type the mobile number including the country code. Otherwise, SMS won't send to that number.">
                                                    </i>
                                                </label>
                                                <input type="number" name="mobile" id="suplier_mobile" value="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Company</label>
                                                <input type="text" name="company_name" id="suplier_company" class="form-control" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" name="address" id="suplier_address" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--primary w-100 h-45">Update</button>
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
            // Edit category button click event
            $('.editCategoryBtn').click(function() {
                // Extract category ID and name from data attributes
                var supplierId = $(this).data('supplier-id');
                var suppliername = $(this).data('supplier-name');
                var supplieremail = $(this).data('supplier-email');
                var suppliermobile = $(this).data('supplier-mobile');
                var suppliercompany = $(this).data('supplier-company');
                var supplieraddress = $(this).data('supplier-address');


                $('#supplier_id').val(supplierId);
                $('#suplier_name').val(suppliername);
                $('#suplier_email').val(supplieremail);
                $('#suplier_mobile').val(suppliermobile);
                $('#suplier_company').val(suppliercompany);
                $('#suplier_address').val(supplieraddress);
            });
        });
    </script>