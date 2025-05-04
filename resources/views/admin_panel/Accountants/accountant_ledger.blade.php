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
                    <h6 class="page-title"> Accountant Ledger</h6>
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
                                                <th>#</th>
                                                <th>Accountant Name</th>
                                                <th>CNIC</th>
                                                <th>Phone</th>
                                                <th>Last Payment Date</th>
                                                <th>Cash in Hand</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($AccountantLedgers as $key => $ledger)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $ledger->accountant->name }}</td>
                                                <td>{{ $ledger->accountant->Cnic }}</td>
                                                <td>{{ $ledger->accountant->Number }}</td>
                                                <td>{{ $ledger->last_payment_date }}</td>
                                                <td><strong class="text-danger">{{ $ledger->cash_in_hand }}</strong></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->
    </div>
    @include('admin_panel.include.footer_include')