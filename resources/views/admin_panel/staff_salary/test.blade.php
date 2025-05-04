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
        <style>
            .dataTables_length,
            .dataTables_info {
                margin-left: 10px;

            }
            .dataTables_length,.dataTables_filter{
             margin-top: 20px;
             margin-bottom: 20px
            }
            .dataTables_filter,
            #example_next {
                margin-right: 10px;
            }

            .dataTables_info {
                margin-top: 0px !important;
            }

            .dataTables_paginate  {
                margin-bottom: 18px !important;
            }

            .dataTables_paginate .paginate_button.current {
    /* background-color: #0a6b9a !important; */
    color: rgb(223, 22, 22) !important;
}


        </style>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
       <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
       <!-- <link rel="stylesheet" href="datatables.bootstrap5.css" /> -->
       <link rel="stylesheet" href="responsive.bootstrap5.css" />
       <link rel="stylesheet" href="datatables.checkboxes.css" />
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
       <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

        <div class="body-wrapper">
            <div class="bodywrapper__inner">

                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">Employee Salary Panel (Monthly)</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">

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
                                <table id="userTable" class="display  table table--light style--two" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Employee</th>
                                                <th>Salary</th>
                                                <th>Paid This Month	</th>
                                                <th>Due This Month	</th>
                                                <th>Last Paid Month	</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="salaryTable">

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#userTable').DataTable();
    });
</script>
    {{-- <script>
     $(document).ready(function() {
    $('.editCategoryBtn').click(function() {
        var staffId = $(this).data('staff-id');
        var staffName = $(this).data('staff-name');
        var phone = $(this).data('staff-phone');
        var email = $(this).data('staff-email');
        var usertype = $(this).data('staff-usertype');

        $('#staff_id').val(staffId || '');
        $('#staff_name').val(staffName || '');
        $('#staff_phone').val(phone || '');
        $('#staff_email').val(email || '');
        $('#staff_usertype').val(usertype || '');
    });
});

    </script> --}}
