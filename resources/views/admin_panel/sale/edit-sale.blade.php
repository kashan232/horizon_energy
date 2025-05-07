@include('admin_panel.include.header_include')

<style>
    .search-container {
        position: relative;
        width: 100%;
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
<div class="page-wrapper default-version">
    @include('admin_panel.include.sidebar_include')
    @include('admin_panel.include.navbar_include')

    <div class="body-wrapper">
        <div class="bodywrapper__inner">
            <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                <h6 class="page-title">Edit Sale</h6>
                <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                    <a href="{{ route('all-sales') }}" class="btn btn-sm btn-outline--primary">
                        <i class="la la-undo"></i> Back
                    </a>
                </div>
            </div>

            <div class="row gy-3">
                <div class="col-lg-12 col-md-12 mb-30">
                    <div class="card">
                        <div class="card-body">
                            @if (session()->has('error'))
                                <div class="alert alert-danger"><strong>Error!</strong> {{ session('error') }}.</div>
                            @endif

                            <form action="{{ route('sale.update', $sale->id) }}" method="POST">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-xl-4 col-sm-6">
                                        <div class="form-group" id="supplier-wrapper">
                                            <label class="form-label">Customers</label>
                                            <select name="customer_info" class="form-control" id="customer-select" required>
                                                @foreach($Customers as $Cus)
                                                    <option value="{{ $Cus->id . '|' . $Cus->name }}" {{ $Cus->id == $sale->customerId ? 'selected' : '' }}>
                                                        {{ $Cus->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-sm-6">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input name="sale_date" type="date" class="form-control bg--white" value="{{ $sale->sale_date }}" required>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Warehouse</label>
                                            <select name="warehouse_id" class="form-control" required>
                                                @foreach($Warehouses as $Warehouse)
                                                    <option value="{{ $Warehouse->name }}" {{ $Warehouse->name == $sale->warehouse_id ? 'selected' : '' }}>
                                                        {{ $Warehouse->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Search -->
                                <div class="row mt-2 mb-2">
                                    <div class="search-container">
                                        <label class="form-label" style="font-size: 20px;">Search Products</label>
                                        <input type="text" id="productSearch" placeholder="Search Products..." class="form-control">
                                        <ul id="searchResults" class="list-group"></ul>
                                    </div>
                                </div>

                                <!-- Product Table -->
                                <div class="row mb-3">
                                    <div class="table-responsive">
                                        <table class="productTable table border">
                                            <thead class="border bg--dark">
                                            <tr>
                                                <th>Category</th>
                                                <th>Name</th>
                                                <th>Quantity<span class="text--danger">*</span></th>
                                                <th>Price<span class="text--danger">*</span></th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="purchaseItems">
                                            @foreach(json_decode($sale->item_name) as $index => $item)
                                                <tr>
                                                    <td>
                                                        <select name="item_category[]" class="form-control item-category" required>
                                                            @foreach($Category as $Categories)
                                                                <option value="{{ $Categories->id }}" {{ $Categories->id == json_decode($sale->item_category)[$index] ? 'selected' : '' }}>
                                                                    {{ $Categories->category }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="item_name[]" class="form-control item-name" required>
                                                            <option value="{{ $item }}" selected>{{ $item }}</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="number" name="quantity[]" class="form-control quantity" value="{{ json_decode($sale->quantity)[$index] }}"></td>
                                                    <td><input type="number" name="price[]" class="form-control price" value="{{ json_decode($sale->price)[$index] }}"></td>
                                                    <td><input type="number" name="total[]" class="form-control total" value="{{ json_decode($sale->total)[$index] }}" readonly></td>
                                                    <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-primary mt-4 mb-4" id="addRow">Add More</button>
                                    </div>
                                </div>

                                <!-- Notes and Finance Section -->
                                <div class="row">
                                    <div class="col-md-8 col-sm-6">
                                        <div class="form-group">
                                            <label>Sale Note</label>
                                            <textarea name="note" class="form-control">{{ $sale->note }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Total Price</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Pkr</span>
                                                        <input type="number" name="total_price" class="form-control total_price" value="{{ $sale->total_price }}" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Discount</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Pkr</span>
                                                        <input type="number" name="discount" id="discount" class="form-control" value="{{ $sale->discount }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Payable Amount</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Pkr</span>
                                                        <input type="number" name="payable_amount" class="form-control payable_amount" value="{{ $sale->Payable_amount }}" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Cash Received</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Pkr</span>
                                                        <input type="number" name="cash_received" id="cashReceived" class="form-control" value="{{ $sale->cash_received }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Change to Return</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Pkr</span>
                                                        <input type="number" name="change_to_return" class="form-control" value="{{ $sale->change_return }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn--primary w-100 h-45">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        // When customer is selected
        $('#customer-select').change(function () {
            const customerId = $(this).val().split('|')[0];
            $.get("{{ route('get-customer-amount', ':id') }}".replace(':id', customerId), function (response) {
                $('#previous_balance').val(response.previous_balance || 0);
                updateClosingBalance();
            });
        });

        // Calculate total for all rows
     function calculateTotalPrice() {
    let total = 0;
    $('#purchaseItems tr').each(function () {
        const quantity = parseFloat($(this).find('.quantity').val()) || 0;
        const price = parseFloat($(this).find('.price').val()) || 0;
        total += quantity * price;
    });
    $('.total_price').val(total.toFixed(2));
    calculatePayableAmount(); // Update discount-adjusted total
}


        // Calculate payable after discount
        function calculatePayableAmount() {
            const totalPrice = parseFloat($('.total_price').val()) || 0;
            const discount = parseFloat($('#discount').val()) || 0;
            const payableAmount = Math.max(0, totalPrice - discount);
            $('.payable_amount').val(payableAmount.toFixed(2));
            updateClosingBalance();
        }

        // Calculate closing balance
        function updateClosingBalance() {
            const previousBalance = parseFloat($('#previous_balance').val()) || 0;
            const payableAmount = parseFloat($('.payable_amount').val()) || 0;
            const cashReceived = parseFloat($('#cashReceived').val()) || 0;
            const closingBalance = previousBalance + payableAmount - cashReceived;
            $('#closing_balance').val(closingBalance.toFixed(2));
        }

        // Add new row button
     // Add new row button
$('#addRow').click(function () {
    const newRow = $(createNewRow());
    $('#purchaseItems').append(newRow);
    attachRowEvents(newRow); // 👈 Attach events to the new row
    calculateTotalPrice();   // 👈 Recalculate totals
});

function attachRowEvents(row) {
    row.find('.quantity, .price').on('input', function () {
        const quantity = parseFloat(row.find('.quantity').val()) || 0;
        const price = parseFloat(row.find('.price').val()) || 0;
        row.find('.total').val((quantity * price).toFixed(2));
        calculateTotalPrice(); // 👈 Total update
    });

    // Attach remove button
    row.find('.remove-row').on('click', function () {
        row.remove();
        calculateTotalPrice(); // 👈 Total update after row delete
    });
}

        // Create new product row
        function createNewRow(category = '', productName = '', price = '') {
            return `
                <tr>
                    <td>
                        <select name="item_category[]" class="form-control item-category" required>
                            <option value="" ${category ? '' : 'selected'}>Select Category</option>
                            @foreach($Category as $Categories)
                                <option value="{{ $Categories->id }}" ${category === '{{ $Categories->category }}' ? 'selected' : ''}>{{ $Categories->category }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="item_name[]" class="form-control item-name" required>
                            <option value="${productName}" selected>${productName}</option>
                        </select>
                    </td>
                    <td><input type="number" name="quantity[]" class="form-control quantity" required></td>
                    <td><input type="number" name="price[]" class="form-control price" value="${price}" required></td>
                    <td><input type="number" name="total[]" class="form-control total" readonly></td>
                    <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
                </tr>`;
        }

        // Remove row
        $('#purchaseItems').on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
            calculateTotalPrice();
        });

        // Update totals when qty or price is changed
        $('#purchaseItems').on('input', '.quantity, .price', function () {
            const row = $(this).closest('tr');
            const quantity = parseFloat(row.find('.quantity').val()) || 0;
            const price = parseFloat(row.find('.price').val()) || 0;
            row.find('.total').val((quantity * price).toFixed(2));
            calculateTotalPrice();
        });

        // Fetch items by category
        $('#purchaseItems').on('change', '.item-category', function () {
            const categoryName = $(this).val();
            const row = $(this).closest('tr');
            const itemSelect = row.find('.item-name');

            if (categoryName) {
                fetch(`{{ route('get-items-by-category', ':categoryId') }}`.replace(':categoryId', categoryName))
                    .then(response => response.json())
                    .then(items => {
                        itemSelect.html('<option value="" disabled selected>Select Item</option>');
                        items.forEach(item => {
                            itemSelect.append(`<option value="${item.product_name}">${item.product_name}</option>`);
                        });
                    })
                    .catch(error => console.error('Error fetching items:', error));
            }
        });

        // Fetch price by product name
        $('#purchaseItems').on('change', '.item-name', function () {
            const productName = $(this).val();
            const row = $(this).closest('tr');
            const priceInput = row.find('.price');

            if (productName) {
                fetch(`{{ route('get-product-details', ':productName') }}`.replace(':productName', productName))
                    .then(response => response.json())
                    .then(product => {
                        priceInput.val(product.retail_price);
                        row.find('.quantity').trigger('input'); // Update total
                    })
                    .catch(error => console.error('Error fetching product details:', error));
            }
        });

        // Product Search
        $('#productSearch').on('keyup', function () {
            const query = $(this).val();

            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('search-products') }}",
                    type: 'GET',
                    data: { q: query },
                    success: function (data) {
                        let html = '';
                        data.forEach(product => {
                            html += `
                                <li class="list-group-item search-result-item"
                                    data-category="${product.category}"
                                    data-product-name="${product.name}"
                                    data-price="${product.price}">
                                    ${product.category} - ${product.name} - ${product.price}
                                </li>`;
                        });
                        $('#searchResults').html(html);
                    },
                    error: function (err) {
                        console.error("AJAX Error:", err);
                    }
                });
            } else {
                $('#searchResults').html('');
            }
        });

        // Click on searched product
       // Click on searched product
$('#searchResults').on('click', '.search-result-item', function () {
    const category = $(this).data('category');
    const productName = $(this).data('product-name');
    const price = $(this).data('price');

    const newRow = $(createNewRow(category, productName, price));
    $('#purchaseItems').append(newRow);
    attachRowEvents(newRow); // 👈 Attach input events
    $('#searchResults').empty();
    $('#productSearch').val('');
    calculateTotalPrice(); // 👈 Recalculate totals
});


        // Hide search results when clicking outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#productSearch, #searchResults').length) {
                $('#searchResults').empty();
            }
        });

        // Triggered when discount or cash changes
        $('#discount, #cashReceived').on('input', function () {
            calculatePayableAmount();
        });

    });
</script>
@include('admin_panel.include.footer_include')
