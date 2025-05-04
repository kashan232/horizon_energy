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
                    <h6 class="page-title">All Order Items</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                       
                        <a href="{{ route('add-order') }}"
                            class="btn btn-outline--primary">
                            <i class="la la-plus"></i>Add New </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                <div class="table-responsive--md table-responsive">
                                    <table id="example" class="display  table table--light style--two bg--white" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Product Name</th>
                                                <th>Category Name  |  Sub-Category Name</th>
                                                <th>Product Unit</th>
                                                <th>Product Price</th>
                                                <th>Product Qty</th>
                                                <th>Product Subtotal</th>
                                                {{-- <th>Product Total Amount</th> --}}
                                                {{-- <th>Total Amount</th>
                                                <th>Order Items</th>
                                                <th>Status</th>
                                                <th>Order Date</th> --}}
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $order_item_tot_amount = 0;
                                            @endphp
                                                @foreach($order_items as $order_item)
                                                {{-- @dd($order_item->product->name) --}}
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $order_item->product->name }}</td>
                                                <td class="long-text">
                                                    <span class="fw-bold text--primary">{{ $order_item->product->category->category }}</span>
                                                    <br>
                                                    <span class="text--small ">{{ $order_item->product->subcategory->name }}</span>
                                                </td>
                                                <td>
                                                    {{ $order_item->product->unit->unit }}
                                                </td>
                                                <td>
                                                    {{ $order_item->product->price }}
                                                </td>
                                                @php
                                                     $poduct_subtotal = ($order_item->product->price * $order_item->qty);
                                                     $order_item_tot_amount += $poduct_subtotal;
                                                @endphp
                                                <td>
                                                    {{ $order_item->qty }}
                                                </td>
                                                <td>
                                                        {{ $poduct_subtotal }}
                                                </td>
                                                {{-- <td>
                                                    {{ $order_item->product->price }}
                                                </td> --}}
                                                {{-- <td>
                                                    <strong class="badge badge--danger">{{ $product->alert_quantity }}</strong>
                                                </td> --}}
                                                {{-- <td>{{ $product->unit }}</td>
                                                <td>{{ $product->wholesale_price }}</td>
                                                <td>{{ $product->retail_price }}</td> --}}
                                                {{-- <td> --}}
                                                    {{-- <div class="button--group"> --}}
                                                        {{-- <a href="{{ route('edit-product',['id' => $order_item->order_id ]) }}"
                                                            class="btn btn-sm btn-outline--primary ms-1 editBtn"><i
                                                                class="las la-pen"></i> Edit</a> --}}
                                                        {{-- <a href="{{ route('all-order-item',$order->id) }}"
                                                            class="btn btn-sm btn-outline--primary ms-1 editBtn"><i
                                                                class="las la-pen"></i> View Items</a> --}}
                                                    {{-- </div> --}}
                                                {{-- </td> --}}
                                                @endforeach
                                        </tbody>
                                    </table>
                                    <div class="card shadow-lg p-2 mb-5 mt-2 me-2 text-center border-0" style="max-width: 300px; float:right; border-radius: 10px;">
                                        <h4 class="mb-2">Total Amount</h4>
                                        <h1 class="fw-bold text-danger">{{ number_format($order_item_tot_amount, 2) }}</h1>
                                    </div>
                                    <!-- table end -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin_panel.include.footer_include')
