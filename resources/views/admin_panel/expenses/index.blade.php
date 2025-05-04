@include('admin_panel.include.header_include')

<body>
    <div class="page-wrapper default-version">

        @include('admin_panel.include.sidebar_include')

        @include('admin_panel.include.navbar_include')

        <div class="body-wrapper">
            <div class="bodywrapper__inner">

                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">All Expenses</h6>
                    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="Add New Expense">
                        <i class="las la-plus"></i> Add New
                    </button>
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
                                                <th>S.N.</th>
                                                <th>Title</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($expenses as $expense)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $expense->title }}</td>
                                                <td>{{ $expense->amount }}</td>
                                                <td>{{ $expense->date }}</td>
                                                <td>{{ $expense->description }}</td>
                                                <td>
                                                    <div class="button--group">
                                                        <button type="button" class="btn btn-sm btn-outline--primary editExpenseBtn"
                                                            data-toggle="modal" data-target="#editExpenseModal"
                                                            data-expense-id="{{ $expense->id }}"
                                                            data-expense-title="{{ $expense->title }}"
                                                            data-expense-amount="{{ $expense->amount }}"
                                                            data-expense-date="{{ $expense->date }}"
                                                            data-expense-description="{{ $expense->description }}">
                                                            <i class="la la-pencil"></i> Edit
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Expense Modal -->
                <div class="modal fade" id="cuModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('store-expense') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New Expense</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="las la-times"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" step="0.01" class="form-control" name="amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" class="form-control" name="date" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--primary w-100 h-45">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Expense Modal -->
                <div class="modal fade" id="editExpenseModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('update-expense') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Expense</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="las la-times"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="expense_id" id="expense_id">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" id="expense_title" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" step="0.01" class="form-control" name="amount" id="expense_amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" class="form-control" name="date" id="expense_date" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" id="expense_description"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--primary w-100 h-45">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('admin_panel.include.footer_include')

    <script>
        $(document).ready(function() {
            $('.editExpenseBtn').click(function() {
                var id = $(this).data('expense-id');
                var title = $(this).data('expense-title');
                var amount = $(this).data('expense-amount');
                var date = $(this).data('expense-date');
                var description = $(this).data('expense-description');

                $('#expense_id').val(id);
                $('#expense_title').val(title);
                $('#expense_amount').val(amount);
                $('#expense_date').val(date);
                $('#expense_description').val(description);
            });
        });
    </script>

</body>
