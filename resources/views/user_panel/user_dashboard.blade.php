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
                    <h6 class="page-title">Dashboard</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                    </div>
                </div>


                <div class="row gy-4 mb-30">
                    <div class="col-xxl-3 col-sm-6">
                        <div class="widget-two box--shadow2 b-radius--5 bg--white">
                            <i class="las la-shopping-cart overlay-icon text--primary"></i>

                            <div class="widget-two__icon b-radius--5   bg--primary  ">
                                <i class="las la-shopping-cart"></i>
                            </div>

                            <div class="widget-two__content">
                                <h3>$637,823,750.00</h3>
                                <p>Sales</p>
                            </div>

                            <a href="#"
                                class="widget-two__btn btn btn-outline--primary">View All</a>
                        </div>

                    </div><!-- dashboard-w1 end -->

                    <div class="col-xxl-3 col-sm-6">
                        <div class="widget-two box--shadow2 b-radius--5 bg--white">
                            <i class="las la-undo overlay-icon text--warning"></i>

                            <div class="widget-two__icon b-radius--5   bg--warning  ">
                                <i class="las la-undo"></i>
                            </div>

                            <div class="widget-two__content">
                                <h3>$99,025,000.00</h3>
                                <p>Sales Return</p>
                            </div>

                            <a href="#"
                                class="widget-two__btn btn btn-outline--warning">View All</a>
                        </div>

                    </div><!-- dashboard-w1 end -->


                </div><!-- row end-->
            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->
    </div>

    @include('admin_panel.include.footer_include')