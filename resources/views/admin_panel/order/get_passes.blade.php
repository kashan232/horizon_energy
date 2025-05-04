<!-- meta tags and other links -->
@include('admin_panel.include.header_include')
<!-- page-wrapper start -->
<div class="page-wrapper default-version">
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
                        <div class="card-body p-0">
                            @if (session()->has('success'))
                            <div class="alert alert-success">
                                <strong>Success!</strong> {{ session('success') }}.
                            </div>
                            @endif
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Gate Pass ID</th>
                                        <th>Order ID</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gatePasses as $gatePass)
                                    <tr>
                                        <td>{{ $gatePass->id }}</td>
                                        <td>{{ $gatePass->order_id }}</td>
                                        <td><span class="badge bg-{{ $gatePass->status == 'returned' ? 'success' : 'warning' }}">
                                                {{ ucfirst($gatePass->status) }}</span>
                                        </td>
                                        <td>
                                            @if($gatePass->status == 'pending' || $gatePass->status == 'dispatched')
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#returnGatePassModal"
                                                data-gatepass-id="{{ $gatePass->id }}">
                                                Return
                                            </button>
                                            @endif
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
    </div>
</div>

<!-- Return Gate Pass Modal -->
<div class="modal fade" id="returnGatePassModal" tabindex="-1" aria-labelledby="returnGatePassLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Return Gate Pass</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="returnGatePassForm" action="{{ route('gatepass-return') }}" method="POST">
                    @csrf
                    <input type="hidden" name="gate_pass_id" id="returnGatePassId">
                    <div id="returnInventoryList"></div>
                    <button type="submit" class="btn btn-success mt-3">Return Inventory</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('admin_panel.include.footer_include')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let returnGatePassModal = document.getElementById("returnGatePassModal");

        returnGatePassModal.addEventListener("show.bs.modal", function(event) {
            let button = event.relatedTarget;
            let gatePassId = button.getAttribute("data-gatepass-id");

            document.getElementById("returnGatePassId").value = gatePassId;

            fetch("{{ route('gatepass.inventory', ':id') }}".replace(':id', gatePassId))
                .then(response => response.json())
                .then(data => {
                    let inventoryList = document.getElementById("returnInventoryList");
                    inventoryList.innerHTML = "";
                    data.forEach(item => {
                        inventoryList.innerHTML += `
                            <div class="mb-2">
                                <label>${item.name} (Sent: ${item.quantity})</label>
                                <input type="number" name="return_inventory[${item.item_id}]" 
                                       max="${item.quantity}" min="0" value="0" class="form-control">
                            </div>`;
                    });
                });
        });
    });
</script>