@include('admin_panel.include.header_include')

<style>
    .search-container {
        position: relative;
        width: 100%;
        /* Adjust width as needed */
    }

    #productSearch {
        width: 100%;
        padding: 8px;
    }

    #searchResults {
        position: absolute;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .search-result-item {
        padding: 10px;
        cursor: pointer;
    }

    .search-result-item:hover {
        background-color: #f0f0f0;
    }
</style>

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
                    <h6 class="page-title">Add Order</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                        <a href="https://script.viserlab.com/torylab/admin/purchase/all"
                            class="btn btn-sm btn-outline--primary">
                            <i class="la la-undo"></i> Back</a>
                    </div>
                </div>

                <div class="row gy-3">
                    <div class="col-lg-12 col-md-12 mb-30">
                        <div class="card">
                            <div class="card-body">
                                @if (session()->has('success'))
                                <div class="alert alert-success">
                                    <strong>Success!</strong> {{ session('success') }}.
                                </div>
                                @endif
                                @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> {{ session('error') }}.
                                </div>
                                @endif
                                <form action="{{ route('store-order') }}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <!-- Customer Info -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group" id="supplier-wrapper">
                                                <label class="form-label">Clients</label>
                                                <select name="customer_info" class="select2-basic form-control" id="customer-select" required>
                                                    <option selected disabled>Select One</option>
                                                    @foreach($Customers as $Customer)
                                                    <option value="{{ $Customer->id . '|' . $Customer->name }}">
                                                        {{ $Customer->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Order Date -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Order Date</label>
                                                <input name="sale_date" type="date" class="form-control bg--white" required>
                                            </div>
                                        </div>

                                        <!-- Order Name -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Order Name</label>
                                                <input type="text" name="order_name" class="form-control" placeholder="Enter Order Name (e.g. Wedding, Birthday)">
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="row mb-3">
                                        <!-- Delivery Date -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Start Project Date</label>
                                                <input type="date" name="delivery_date" class="form-control bg--white" required>
                                            </div>
                                        </div>

                                        <!-- Delivery Time -->
                                        {{-- <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Delivery Time</label>
                                                <input type="time" name="delivery_time" class="form-control bg--white" required>
                                            </div>
                                        </div> --}}

                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" name="Venue" class="form-control bg--white" required>

                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>System Size</label>
                                                <input type="text" name="person_program" class="form-control bg--white" required>

                                            </div>
                                        </div>
                                        <!-- Event Type -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Maintenance Info</label>
                                                <input type="text" name="event_type" class="form-control bg--white" required>
                                            </div>
                                        </div>
                                         <!-- Alert Before Days -->
                                        <div class="col-xl-4 col-sm-6">
                                        <div class="form-group">
                                            <label>Alert Before Days</label>
                                            <input type="number" name="alert_before_days" class="form-control bg--white" placeholder="Enter days to alert before delivery" min="0">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="row mb-3">
                                        <!-- Order Status -->
                                        <!-- Special Instructions -->
                                        <div class="col-xl-12 col-sm-12">
                                            <div class="form-group">
                                                <label>Special Instructions</label>
                                                <textarea name="special_instructions" class="form-control" rows="3" placeholder="Enter any special requests or instructions"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product Items List -->
                                    <!-- <div class="row mt-2 mb-2">
                                        <div class="search-container">
                                            <label class="form-label" style="font-size: 20px;">Search Products</label>
                                            <input type="text" id="productSearch" placeholder="Search Products..." class="form-control">
                                            <ul id="searchResults" class="list-group"></ul>
                                        </div>
                                    </div> -->
                                    <div class="row mb-3">
                                        <div class="table-responsive">
                                            <table class="productTable table border">
                                                <thead class="border bg--dark">
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Sub-Category</th>
                                                        <th>Item</th>
                                                        <th>Unit</th>
                                                        <th>Quantity<span class="text--danger">*</span></th>
                                                        <th>Price<span class="text--danger">*</span></th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="purchaseItems">
                                                </tbody>

                                            </table>
                                            <button type="button" class="btn btn-primary mt-4 mb-4" id="addRow">Add More</button>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8 col-sm-6">
                                            <div class="form-group">
                                                <label>Order Note</label>
                                                <textarea name="note" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Total Price</label>
                                                        <input type="text" id="total_price" name="total_price" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Discount (PKR)</label>
                                                        <input type="number" id="discount" name="discount" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Payable Amount</label>
                                                        <input type="text" id="payable_amount" name="payable_amount" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Advance Paid</label>
                                                        <input type="text" id="advance_paid" name="advance_paid" class="form-control" oninput="calculateRemaining()">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Remaining Amount</label>
                                                        <input type="text" id="remaining_amount" name="remaining_amount" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn--primary w-100 h-45">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->

    </div>
    @include('admin_panel.include.footer_include')


    <script>
        $(document).ready(function() {
            $(document).on('change', '.item-category', function() {
                var category_id = $(this).val();
                var subCategoryDropdown = $(this).closest('tr').find('.item-subcategory');

                if (category_id) {
                    var url = "{{ route('get.subcategories', ':id') }}".replace(':id', category_id);

                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            subCategoryDropdown.empty().append('<option value="" selected disabled>Select Sub Category</option>');
                            $.each(data, function(index, subcategory) {
                                subCategoryDropdown.append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                            });
                        }
                    });
                }
            });

            // Subcategory select hone per items fetch karna
            $(document).on('change', '.item-subcategory', function() {
                var subCategory_id = $(this).val();
                var category_id = $(this).closest('tr').find('.item-category').val();
                var itemDropdown = $(this).closest('tr').find('.item-name');

                if (category_id && subCategory_id) {
                    var url = "{{ route('get.items', [':category', ':subcategory']) }}"
                        .replace(':category', category_id)
                        .replace(':subcategory', subCategory_id);

                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            itemDropdown.empty().append('<option value="" selected disabled>Select Item</option>');
                            $.each(data, function(index, item) {
                                itemDropdown.append('<option value="' + item.name + '" data-unit="' + item.unit + '" data-price="' + item.price + '">' + item.name + '</option>');
                            });
                        }
                    });
                }
            });


            // Item select hone par unit aur price set karna
            $(document).on('change', '.item-name', function() {
                var selectedOption = $(this).find(":selected");
                var unit = selectedOption.data('unit');
                var price = selectedOption.data('price');

                var row = $(this).closest('tr');
                row.find('.unit').val(unit);
                row.find('.price').val(price);
            });

            $(document).on('input', '.quantity, .price', function() {
                var row = $(this).closest('tr');
                calculateTotal(row);
            });

            // Function to calculate row-wise total
            function calculateTotal(row) {
                var quantity = parseFloat(row.find('.quantity').val()) || 0;
                var price = parseFloat(row.find('.price').val()) || 0;
                var total = quantity * price;
                row.find('.total').val(total.toFixed(2));

                calculateTotalPrice();
            }


            function calculateTotalPrice() {
                var totalPrice = 0;
                $('.total').each(function() {
                    totalPrice += parseFloat($(this).val()) || 0;
                });

                $('#total_price').val(totalPrice.toFixed(2));

                var discount = parseFloat($('#discount').val()) || 0;
                var payableAmount = totalPrice - discount;
                $('#payable_amount').val(payableAmount.toFixed(2));

                calculateRemaining(); // Advance aur remaining amount update karne ke liye
            }

            function calculateRemaining() {
                let payable = parseFloat($('#payable_amount').val()) || 0;
                let advance = parseFloat($('#advance_paid').val()) || 0;

                if (advance > payable) {
                    advance = payable; // Advance paid zyada nahi ho sakta payable amount se
                    $('#advance_paid').val(advance.toFixed(2)); // Agar zyada ho, to max payable pe lock karna
                }

                let remaining = payable - advance;
                $('#remaining_amount').val(remaining.toFixed(2));
            }

            // Events
            $(document).on('input', '.quantity, .price', function() {
                var row = $(this).closest('tr'); // Agar table mein ho
                calculateTotal(row);
            });

            $('#discount').on('input', function() {
                calculateTotalPrice();
            });

            $('#advance_paid').on('input', function() {
                calculateRemaining();
            });


            // Discount change hone par payable amount update karna
            $(document).on('input', '#discount', function() {
                calculateTotalPrice();
            });

            // Row delete hone par bhi total update hoga
            $('#purchaseItems').on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                calculateTotalPrice();
            });

            // Add a new row
            $('#addRow').click(function() {
                const newRow = createNewRow();
                $('#purchaseItems').append(newRow);
            });

            // Function to create a new row
            function createNewRow(category = '', subCategory = '', productName = '', unit = '', price = '') {
                return `
            <tr>
                <td>
                    <select name="item_category[]" class="form-control item-category" style="width:120px;" required>
                        <option value="" disabled ${category ? '' : 'selected'}>Select Category</option>
                        @foreach($Category as $Categories)
                            <option value="{{ $Categories->id }}">{{ $Categories->category }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="item_subcategory[]" class="form-control item-subcategory" style="width:120px;" required>
                        <option value="" disabled ${subCategory ? '' : 'selected'}>Select Sub Category</option>
                    </select>
                </td>
                <td>
                    <select name="item_name[]" class="form-control item-name" style="width:120px;" required>
                        <option value="" disabled ${productName ? '' : 'selected'}>Select Item</option>
                    </select>
                </td>
                <td><input type="text" name="unit[]" class="form-control unit" style="width:120px;" readonly></td>
                <td><input type="number" name="quantity[]" class="form-control quantity" style="width:120px;" required></td>
                <td><input type="number" name="price[]" class="form-control price" style="width:120px;" required></td>
                <td><input type="number" name="total[]" class="form-control total" style="width:120px;" readonly></td>
                <td>
                    <button type="button" class="btn btn-danger remove-row">Delete</button>
                </td>
            </tr>`;
            }
            // Remove a row
            $('#purchaseItems').on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                calculateTotalPrice();
            });

            // Search product functionality
            $('#productSearch').on('keyup', function() {
                const query = $(this).val();
                if (query.length > 0) {
                    $.ajax({
                        url: "{{ route('search-products') }}",
                        type: 'GET',
                        data: {
                            q: query
                        },
                        success: displaySearchResults,
                        error: function(error) {
                            console.error('Error in product search:', error);
                        }
                    });
                } else {
                    $('#searchResults').html('');
                }
            });

            // Display search results
            function displaySearchResults(products) {
                const searchResults = $('#searchResults');
                searchResults.html('');
                products.forEach(product => {
                    const listItem = `<li class="list-group-item search-result-item" data-category="${product.category}" data-product-name="${product.product_name}" data-price="${product.retail_price}">
                    ${product.category} - ${product.product_name} - ${product.retail_price}
                </li>`;
                    searchResults.append(listItem);
                });
            }

            // Add searched product as a new row
            $('#searchResults').on('click', '.search-result-item', function() {
                const category = $(this).data('category');
                const productName = $(this).data('product-name');
                const price = $(this).data('price');

                const newRow = createNewRow(category, productName, price);
                $('#purchaseItems').append(newRow);
                $('#searchResults').html('');
                calculateTotalPrice();
            });
        });
    </script>

</body>