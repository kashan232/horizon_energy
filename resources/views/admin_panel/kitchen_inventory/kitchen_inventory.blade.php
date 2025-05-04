@include('admin_panel.include.header_include')

<body>
    <div class="page-wrapper default-version">
        @include('admin_panel.include.sidebar_include')
        @include('admin_panel.include.navbar_include')
        <div class="body-wrapper">
            <div class="bodywrapper__inner">
                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">Kitchen Inventory</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                        <!-- Add Item Button -->
                        <button type="button" class="btn btn-outline--primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
                            <i class="la la-plus"></i> Add Item
                        </button>
                        <!-- Add Inventory Button -->
                        <button type="button" class="btn btn-outline--success" data-bs-toggle="modal" data-bs-target="#addInventoryModal">
                            <i class="la la-plus"></i> Add Inventory Item
                        </button>
                    </div>
                </div>

                <!-- Inventory Items Listing -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                <div class="table-responsive--md table-responsive">
                                    <table id="example" class="display table table--light style--two bg--white" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($inventoryItems as $inventory)
                                            <tr>
                                                <td>{{ $inventory->item->name ?? 'N/A' }}</td> {{-- Fetch item name properly --}}
                                                <td>{{ $inventory->quantity }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="2" class="text-center">No Inventory Data Available</td>
                                            </tr>
                                            @endforelse
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Item Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Kitchen Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('kitchen-items.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Item Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Inventory Item Modal -->
    <div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Inventory Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('inventory.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select Item</label>
                            <select class="form-control" name="item_id" required>
                                <option value="" disabled selected>Select an Item</option>
                                @foreach($kitchenItems as $kitchenItem)
                                <option value="{{ $kitchenItem->id }}">{{ $kitchenItem->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" required>
                        </div>
                        <button type="submit" class="btn btn-success">Add Inventory</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('admin_panel.include.footer_include')