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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10">
                            <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                                <h6 class="page-title">Accountant Expense</h6>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExpenseModal">
                                    Add Expense
                                </button>
                            </div>

                            <div class="table-responsive--sm table-responsive">
                                <table id="example" class="display table table--light style--two" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Accountant Name</th>
                                            <th>Expense Category</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Expenses as $key => $expense)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $expense->accountant->name ?? 'N/A' }}</td> {{-- Accountant name through relation --}}
                                            <td>{{ $expense->expense_category }}</td>
                                            <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('d-m-Y') }}</td>
                                            <td>Rs. {{ number_format($expense->expense_amount, 2) }}</td>
                                            <td>{{ $expense->expense_description }}</td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>

                </div><!-- bodywrapper__inner end -->
            </div><!-- body-wrapper end -->
        </div>

        <!-- Add Expense Modal -->
        <div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExpenseModalLabel">Add Expense</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('save-accountant-expense') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Accountant</label>
                                <select class="form-control" name="accountant_id" id="accountant_id" required>
                                    <option value="">Select Accountant</option>
                                    @foreach ($Accountants as $accountant)
                                    <option value="{{ $accountant->id }}" data-cash="{{ $accountant->cash_in_hand }}">
                                        {{ $accountant->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Cash in Hand Display -->
                            <div class="form-group mt-3">
                                <label>Cash in Hand</label>
                                <div id="cash_in_hand_display" class="alert alert-danger text-center font-weight-bold" style="font-size: 18px; padding: 10px;">
                                    Select an Accountant
                                </div>
                            </div>



                            <div class="form-group">
                                <label>Expense Category</label>
                                <select class="form-control" name="expense_category" required>
                                    <option value="Groceries">Groceries (Sabzi, Masala, Meat, etc.)</option>
                                    <option value="Fuel & Transportation">Fuel & Transportation</option>
                                    <option value="Cooking Gas">Cooking Gas</option>
                                    <option value="Staff Salaries">Staff Salaries</option>
                                    <option value="Kitchen Equipment">Kitchen Equipment & Maintenance</option>
                                    <option value="Packaging & Disposable">Packaging & Disposable Items</option>
                                    <option value="Event Setup">Event Setup & Decoration</option>
                                    <option value="Miscellaneous">Miscellaneous</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" class="form-control" name="expense_date" required>
                            </div>

                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control" name="expense_amount" required>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="expense_description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Expense</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('admin_panel.include.footer_include')
        <script>
            document.getElementById('accountant_id').addEventListener('change', function() {
                let selectedOption = this.options[this.selectedIndex];
                let cashInHand = selectedOption.getAttribute('data-cash') || 0;

                // Update the design
                let cashDisplay = document.getElementById('cash_in_hand_display');
                cashDisplay.innerHTML = "Rs. " + parseFloat(cashInHand).toLocaleString();
                cashDisplay.classList.add("alert-danger"); // Green background when amount is updated
            });
        </script>