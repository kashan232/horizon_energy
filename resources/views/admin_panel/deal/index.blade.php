@include('admin_panel.include.header_include')

<body>
    <div class="page-wrapper default-version">

        @include('admin_panel.include.sidebar_include')
        @include('admin_panel.include.navbar_include')
        <style>
            .dataTables_length,
            .dataTables_info {
                margin-left: 2px;

            }

            .dataTables_length,
            .dataTables_filter {
                margin-top: 20px;
                margin-bottom: 20px
            }

            .dataTables_filter,
            #example_next {
                margin-right: 2px;
            }

            .dataTables_info {
                margin-top: 0px !important;
            }

            .dataTables_paginate {
                margin-bottom: 18px !important;
            }

            .dataTables_paginate .paginate_button.current {
                /* background-color: #0a6b9a !important; */
                color: rgb(223, 22, 22) !important;
            }

            .sorting {
                background-color: #0a6b9a !important;

            }

            table {
                font-size: 0.75rem;
                text: centen;
                color: black
            }
        </style>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

        <link rel="stylesheet" href="datatables.checkboxes.css" />

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
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Deal Table -->
                <div class="card">
                    <div class="table-section table-responsive--sm table-responsive bg-white "
                        style="border-radius: 10px;text-align:center">
                        <table id="userTable" class="table-striped">
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
                                        <td style="text-align: center;">
                                            @if ($deal->image)
                                                <img src="{{ $deal->image }}" width="60" height="60"
                                                    style="object-fit: cover; height: 60px; width: 60px; border-radius: 50%;">
                                            @else
                                                <img src="https://via.placeholder.com/60" width="60" height="60">
                                            @endif
                                        </td>

                                        <td>{{ $deal->title }}</td>
                                        <td>Rs. {{ number_format($deal->price, 0) }}</td>
                                        <td>{{ $deal->duration }}</td>
                                        <td>
                                            @if ($deal->status)
                                                <span class="badge bg--success">Active</span>
                                            @else
                                                <span class="badge bg--danger">Inactive</span>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            <a href="{{ route('deal.edit', $deal->id) }}" class="btn btn-sm btn-outline--info">Edit</a>

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
                                        </td> --}}
                                        <td style="text-align: center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline--info ms-1 dropdown-toggle"
                                                    type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="la la-ellipsis-v"></i>More
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                    {{-- <a class="dropdown-item btn btn-sm btn-outline--primary ms-1 editBtn" href="{{ route('sale-view', ['id' => $Sale->id]) }}"> <i class="la la-eye"></i> View</a> --}}
                                                    <ul>

                                                        <li style="text-align: center">
                                                            <form action="{{ route('deal.toggle', $deal->id) }}"
                                                                method="POST"
                                                                style="display:inline-block;text-align:center">
                                                                @csrf
                                                                <button href="" style="width: 100px;margin-top:5px"
                                                                    class="btn btn-sm btn-outline--warning">
                                                                    {{ $deal->status ? 'Deactivate' : 'Activate' }}
                                                                </button>
                                                            </form>
                                                        </li>
                                                           <li style="text-align: center"><a style="width: 100px;margin-top:5px"
                                                                class="btn btn-sm btn-outline--success  "
                                                                style="text-align: center"
                                                                href="{{ route('deal.edit', $deal->id) }}"> <i
                                                                    class="la la-pen"></i> Edit</a></li>
                                                        <li style="text-align: center">
                                                            <form action="{{ route('deal.destroy', $deal->id) }}"
                                                                method="POST" style="display:inline-block;"
                                                                onsubmit="return confirm('Are you sure?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" style="width: 100px;margin-top:5px"
                                                                    class="btn btn-sm btn-outline--danger">Delete</button>
                                                            </form>
                                                        </li>

                                                    </ul>


                                                </div>
                                            </div>
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

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#userTable').DataTable();
    });
</script>
