@include('admin_panel.include.header_include')

<body>
    <div class="page-wrapper default-version">

        @include('admin_panel.include.sidebar_include')
        @include('admin_panel.include.navbar_include')

        <div class="body-wrapper">
            <div class="bodywrapper__inner">

                <!-- Page Title + Add Deal Button -->
                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">All Deals</h6>
                    <div>
                        <a href="{{ route('deal.create') }}" class="btn btn-sm btn-outline--primary">
                            <i class="la la-plus"></i> Add Deal
                        </a>
                    </div>
                </div>

                <!-- Success Message -->
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Deal Table -->
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deals as $deal)
                                    <tr>
                                        <td>
                                            @if($deal->image)
                                                <img src="{{ asset('storage/' . $deal->image) }}" width="60" height="60" style="object-fit: cover;">
                                            @else
                                                <img src="https://via.placeholder.com/60" width="60" height="60">
                                            @endif
                                        </td>
                                        <td>{{ $deal->title }}</td>
                                        <td>Rs. {{ number_format($deal->price, 0) }}</td>
                                        <td>{{ $deal->duration }}</td>
                                        <td>
                                            @if($deal->status)
                                                <span class="badge bg--success">Active</span>
                                            @else
                                                <span class="badge bg--danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline--info">Edit</a>

                                            <form action="{{ route('deal.toggle', $deal->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline--warning">
                                                    {{ $deal->status ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>

                                            <form action="{{ route('deal.destroy', $deal->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline--danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No deals found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

    @include('admin_panel.include.footer_include')
</body>
