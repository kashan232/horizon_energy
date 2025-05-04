<!-- meta tags and other links -->
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

        <!-- body-wrapper start -->
        <div class="body-wrapper">
            <div class="bodywrapper__inner">

                <!-- Page Title + Back Button -->
                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">Add Deal</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                        <a href="{{ route('deal.index') }}" class="btn btn-sm btn-outline--primary">
                            <i class="la la-undo"></i> Back
                        </a>
                    </div>
                </div>

                <!-- Form Start -->
                <div class="row mb-none-30">
                    <div class="col-lg-12 col-md-12 mb-30">
                        <div class="card">
                            <div class="card-body">
                                @if (session()->has('success'))
                                    <div class="alert alert-success">
                                        <strong>Success!</strong> {{ session('success') }}.
                                    </div>
                                @endif

                                <form action="{{ route('deals.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <!-- Image Upload -->
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <div class="image-upload">
                                                    <div class="thumb">
                                                        <div class="avatar-preview">
                                                            <div class="profilePicPreview"
                                                                style="background-image: url(https://script.viserlab.com/torylab/placeholder-image/400x400)">
                                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="avatar-edit">
                                                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                            <label for="profilePicUpload1" class="bg--success">Upload Image</label>
                                                            <small class="mt-2">Supported files: <b>jpeg, jpg.</b> Image will be resized into 400x400px</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Deal Info -->
                                        <div class="col-md-8 col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Deal Title</label>
                                                        <input type="text" name="title" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Deal Duration (e.g. Months )</label>
                                                        <input type="text" name="duration" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Price</label>
                                                        <input type="number" name="price" class="form-control" value="0" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <select name="status" class="form-control" required>
                                                            <option value="1" selected>Active</option>
                                                            <option value="0">Deactive</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea name="description" rows="4" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn--primary w-100 h-45">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->
    </div><!-- page-wrapper end -->
    <script>
        // Jab file select ho
        document.querySelector('.profilePicUpload').addEventListener('change', function (event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.querySelector('.profilePicPreview').style.backgroundImage = `url('${e.target.result}')`;
                    document.querySelector('.profilePicPreview').classList.add('has-image');
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    
        // Jab X button dabaye
        document.querySelector('.remove-image').addEventListener('click', function () {
            document.querySelector('.profilePicPreview').style.backgroundImage = 'url(https://script.viserlab.com/torylab/placeholder-image/400x400)';
            document.querySelector('.profilePicUpload').value = null;
            document.querySelector('.profilePicPreview').classList.remove('has-image');
        });
    </script>
    
    @include('admin_panel.include.footer_include')
</body>
