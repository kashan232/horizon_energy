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
                    <h6 class="page-title">Add Purchase</h6>
                </div>

                <div class="row gy-3">
                    <div class="col-lg-12 col-md-12 mb-30">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('store-Purchase') }}" method="POST">
                                    @csrf

                                    <div class="row mb-3">
                                        <div class="col-xl-4 col-sm-4">
                                            <div class="form-group" id="supplier-wrapper">
                                                <label class="form-label">Supplier</label>
                                                <select name="supplier" class="form-control" required>
                                                    <option selected disabled>Select One</option>
                                                    @foreach($Suppliers as $Supplier)
                                                    <option value="{{ $Supplier->name }}">{{ $Supplier->name }}</option>
                                                     @endforeach
                                                    {{-- <pre>{{ dd($Suppliers) }}</pre> --}}
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-sm-4">
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input name="purchase_date" type="date" class="datepicker-here form-control bg--white" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Warehouse</label>
                                                <select name="warehouse_id" class="form-control" required>
                                                    <option selected disabled>Select One</option>
                                                    @foreach($Warehouses as $Warehouse)
                                                    <option value="{{ $Warehouse->name }}">{{ $Warehouse->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="table-responsive">
                                            <table class="productTable table border">
                                                <thead class="border bg--dark">
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Name</th>
                                                        <th>Unit</th>
                                                        <th>Quantity<span class="text--danger">*</span></th>
                                                        <th>Price<span class="text--danger">*</span></th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="purchaseItems">
                                                    <tr>
                                                        <td>
                                                            <select name="item_category[]" class=" form-control  item-category" required>
                                                                <option value="" disabled selected>Select Category</option>
                                                                @foreach($Category as $Categories)
                                                                <option value="{{ $Categories->id }}">{{ $Categories->category }}</option>

                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="item_name[]" class="form-control item-name" required>
                                                                <option value="" disabled selected class="form-control ">Select Item</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="unit[]" class="form-control unit" readonly> <!-- Readonly Unit column -->
                                                        </td>
                                                        <td>
                                                            <input type="number" name="quantity[]" class="form-control quantity" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="price[]" class="form-control price" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="total[]" class="form-control total" readonly>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger remove-row">Delete</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <button type="button" class="btn btn-primary mt-4 mb-4" id="addRow">Add More</button>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8 col-sm-6">
                                            <div class="form-group">
                                                <label>Note</label>
                                                <textarea name="note" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Total Price</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Pkr</span>
                                                            <input type="number" name="total_price" class="form-control total_price" value="0" required readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Discount</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Pkr</span>
                                                            <input type="number" name="discount" class="form-control discount" step="any" value="0">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Payable Amount</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Pkr</span>
                                                            <input type="number" name="payable_amount" class="form-control payable_amount" value="0" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Paid Amount</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Pkr</span>
                                                            <input type="number" name="paid_amount" class="form-control paid_amount" value="0">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Remaining Amount</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Pkr</span>
                                                            <input type="number" name="due_amount" class="form-control remaining_amount" readonly>
                                                        </div>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2-basic').select2();
    });
</script>
<script>
    const getItemsByCategoryUrl = "{{ route('get-items-by-category', ['categoryId' => 'CATEGORY_ID']) }}";
    const getUnitByProductUrl = "{{ route('get-unit-by-product', ['productId' => 'PRODUCT_ID']) }}";

    $(document).ready(function () {
        // Initialize select2
        $('.item-category, .item-name').select2();

        // Update payable and remaining on input
        $(document).on('input', '.total_price, .discount, .paid_amount', function () {
            updatePayableAndRemaining();
        });

        // Update row totals on quantity/price change
        $(document).on('input', '.quantity, .price', function () {
            calculateTotalAndPayable();
        });

        // Load items on category change
        $(document).on('change', '.item-category', function () {
            const row = $(this).closest('tr');
            const categoryId = $(this).val();
            const itemSelect = row.find('.item-name');

            if (categoryId) {
                fetch(getItemsByCategoryUrl.replace('CATEGORY_ID', categoryId))
                    .then(res => res.json())
                    .then(data => {
                        itemSelect.empty().append(`<option disabled selected>Select Item</option>`);
                        data.forEach(item => {
                            itemSelect.append(`<option value="${item.id}">${item.name}</option>`);
                        });
                        itemSelect.select2();
                    });
            }
        });

        // Load unit and price on item change
        $(document).on('change', '.item-name', function () {
            const row = $(this).closest('tr');
            const productId = $(this).val();

            if (productId) {
                fetch(getUnitByProductUrl.replace('PRODUCT_ID', productId))
                    .then(res => res.json())
                    .then(data => {
                        row.find('.unit').val(data.unit);
                        row.find('.price').val(data.price);
                        calculateTotalAndPayable();
                    });
            }
        });

        // Add new row
        $('#addRow').click(function () {
            const newRow = `
            <tr>
                <td>
                    <select name="item_category[]" class="form-control item-category" required>
                        <option value="" disabled selected>Select Category</option>
                        @foreach($Category as $Categories)
                            <option value="{{ $Categories->id }}">{{ $Categories->category }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="item_name[]" class="form-control item-name" required>
                        <option value="" disabled selected>Select Item</option>
                    </select>
                </td>
                <td><input type="text" name="unit[]" class="form-control unit" readonly></td>
                <td><input type="number" name="quantity[]" class="form-control quantity" required></td>
                <td><input type="number" name="price[]" class="form-control price" required></td>
                <td><input type="number" name="total[]" class="form-control total" readonly></td>
                <td><button type="button" class="btn btn-danger remove-row">Delete</button></td>
            </tr>`;
            $('#purchaseItems').append(newRow);
            $('.item-category, .item-name').select2(); // Reinitialize
        });

        // Remove row
        $(document).on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
            calculateTotalAndPayable();
        });

        // Helper: Calculate totals
        function calculateTotalAndPayable() {
            let total = 0;

            $('#purchaseItems tr').each(function () {
                const qty = parseFloat($(this).find('.quantity').val()) || 0;
                const price = parseFloat($(this).find('.price').val()) || 0;
                const rowTotal = qty * price;
                $(this).find('.total').val(rowTotal);
                total += rowTotal;
            });

            $('.total_price').val(total);
            updatePayableAndRemaining();
        }

        // Helper: Update payable and remaining
        function updatePayableAndRemaining() {
            const totalPrice = parseFloat($('.total_price').val()) || 0;
            const discount = parseFloat($('.discount').val()) || 0;
            const paid = parseFloat($('.paid_amount').val()) || 0;

            const payable = totalPrice - discount;
            const remaining = payable - paid;

            $('.payable_amount').val(payable >= 0 ? payable : 0);
            $('.remaining_amount').val(remaining >= 0 ? remaining : 0);
        }
    });
</script>

</body>
