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
                    <h6 class="page-title">Edit Order: #{{$order->estimate_number}}</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                        <a href="{{ route('all-menu') }}" class="btn btn-sm btn-outline--primary">
                            <i class="la la-undo"></i> Back</a>
                    </div>
                </div>
                <div class="row mb-none-30">
                    <div class="col-lg-12 col-md-12 mb-30">
                        <div class="card">
                            <div class="card-body">
                                @if (session()->has('success'))
                                    <div class="alert alert-success">
                                        <strong>Success!</strong> {{ session('success') }}.
                                    </div>
                                @endif
                                <div class="container">
                                    <form action="{{ route('update-order', $order->id) }}" method="POST">
                                        @csrf
                                        @method('POST') {{-- Agar chahein to PUT bhi kar sakte hain --}}
                                        
                                        <div class="row">
                                            {{-- Client Details --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Client Name</label>
                                                    <input type="text" name="client_name" class="form-control" value="{{ $order->client_name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Client Address</label>
                                                    <input type="text" name="client_address" class="form-control" value="{{ $order->client_address }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Client Contact</label>
                                                    <input type="text" name="client_contact" class="form-control" value="{{ $order->client_contact }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Estimate Date</label>
                                                    <input type="date" name="estimate_date" class="form-control" value="{{ $order->estimate_date }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Estimate Number</label>
                                                    <input type="text" name="estimate_number" class="form-control" value="{{ $order->estimate_number }}">
                                                </div>
                                            </div>
                                    
                                            {{-- Project Details --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Location Type</label>
                                                    <input type="text" name="location_type" class="form-control" value="{{ $order->location_type }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Site Location</label>
                                                    <input type="text" name="site_location" class="form-control" value="{{ $order->site_location }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Roof Area</label>
                                                    <input type="text" name="roof_area" class="form-control" value="{{ $order->roof_area }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Monthly Units</label>
                                                    <input type="text" name="monthly_units" class="form-control" value="{{ $order->monthly_units }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Electricity Bill</label>
                                                    <input type="text" name="electricity_bill" class="form-control" value="{{ $order->electricity_bill }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Mounting Structure</label>
                                                    <input type="text" name="mounting_structure" class="form-control" value="{{ $order->mounting_structure }}">
                                                </div>
                                            </div>
                                    
                                            {{-- Battery Section --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Battery Type</label>
                                                    <input type="text" name="battery_type" class="form-control" value="{{ $order->battery_type }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Battery Capacity</label>
                                                    <input type="text" name="battery_capacity" class="form-control" value="{{ $order->battery_capacity }}">
                                                </div>
                                            </div>
                                    
                                            {{-- System Specification --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>System Size</label>
                                                    <input type="text" name="system_size" class="form-control" value="{{ $order->system_size }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Panel Brand/Model</label>
                                                    <input type="text" name="panel_brand_model" class="form-control" value="{{ $order->panel_brand_model }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Number of Panels</label>
                                                    <input type="text" name="number_of_panels" class="form-control" value="{{ $order->number_of_panels }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Inverter Brand Capacity</label>
                                                    <input type="text" name="inverter_brand_capacity" class="form-control" value="{{ $order->inverter_brand_capacity }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Structure Type</label>
                                                    <input type="text" name="structure_type" class="form-control" value="{{ $order->structure_type }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>System Type</label>
                                                    <input type="text" name="system_type" class="form-control" value="{{ $order->system_type }}">
                                                </div>
                                            </div>
                                    
                                            {{-- Warranty & Services --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Panel Warranty</label>
                                                    <input type="text" name="panel_warranty" class="form-control" value="{{ $order->panel_warranty }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Inverter Warranty</label>
                                                    <input type="text" name="inverter_warranty" class="form-control" value="{{ $order->inverter_warranty }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Installation Warranty</label>
                                                    <input type="text" name="installation_warranty" class="form-control" value="{{ $order->installation_warranty }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Net Metering</label>
                                                    <input type="text" name="net_metering" class="form-control" value="{{ $order->net_metering }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Material Cost</label>
                                                    <input type="text" name="material_cost" class="form-control" value="{{ $order->material_cost }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Installation Charges</label>
                                                    <input type="text" name="installation_charges" class="form-control" value="{{ $order->installation_charges }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Transportation Charges</label>
                                                    <input type="text" name="transportation_charges" class="form-control" value="{{ $order->transportation_charges }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Discount</label>
                                                    <input type="text" name="discount" class="form-control" value="{{ $order->discount }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Estimated Price</label>
                                                    <input type="text" name="estimated_price" class="form-control" value="{{ $order->estimated_price }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Payment Terms</label>
                                                    <input type="text" name="payment_terms" class="form-control" value="{{ $order->payment_terms }}">
                                                </div>
                                            </div>
                                    
                                            {{-- Additional Notes --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Completion Time</label>
                                                    <input type="text" name="completion_time" class="form-control" value="{{ $order->completion_time }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Maintenance Info</label>
                                                    <input type="text" name="maintenance_info" class="form-control" value="{{ $order->maintenance_info }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Total </label>
                                                    <input type="text" name="total" class="form-control" value="{{ $order->total  }}">
                                                </div>
                                            </div>
                                    
                                        </div>
                                    
                                        <div class="text-right mt-3">
                                            <button type="submit" class="btn btn-primary">Update Order</button>
                                        </div>
                                    </form>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->
    </div>
    @include('admin_panel.include.footer_include')
</body>
