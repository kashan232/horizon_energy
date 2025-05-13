<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <title>Horizon Energy</title>
    <link rel="icon" type="image/png" href="order_page/assets/images/f_@.png">
    <link rel="stylesheet" href="order_page/assets/css/all.min.css">
    <link rel="stylesheet" href="order_page/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="order_page/assets/css/nice-select.css">
    <link rel="stylesheet" href="order_page/assets/css/slick.css">
    <link rel="stylesheet" href="order_page/assets/css/venobox.min.css">
    <link rel="stylesheet" href="order_page/assets/css/ranger_slider.css">
    <link rel="stylesheet" href="order_page/assets/css/animate.css">
    <link rel="stylesheet" href="order_page/assets/css/scroll_button.css">
    <link rel="stylesheet" href="order_page/assets/css/custom_spacing.css">
    <link rel="stylesheet" href="order_page/assets/css/select2.min.css">
    <link rel="stylesheet" href="order_page/assets/css/colorfulTab.min.css">
    <link rel="stylesheet" href="order_page/assets/css/jquery.animatedheadline.css">
    <link rel="stylesheet" href="order_page/assets/css/animated_barfiller.css">
    <link rel="stylesheet" href="order_page/assets/css/style.css">
    <link rel="stylesheet" href="order_page/assets/css/responsive.css">
    <style>
        .btn-close {
            filter: invert(1);
        }

        .sub-menu {
            list-style-type: none;
            padding-left: 20px;
        }

        .sub-menu li {
            padding: 5px 0;
        }

        footer a:hover {
            color: #f9a825 !important;
            transition: all 0.3s ease;
        }

        footer ul li {
            margin-bottom: 10px;
        }

        footer hr {
            opacity: 0.2;
        }

        footer i {
            transition: transform 0.3s ease;
        }

        footer a:hover i {
            transform: scale(1.2);
            color: #f9a825;
        }
    </style>
</head>

<body>

    <!--==========================
        HEADER START
    ===========================-->
    <header>
        <div class="container container_large">
            <div class="row">
                <div class="col-xl-12 col-md-12 d-none d-md-block">
                    <div class="header_left text-center">
                        <p>Welcome To Horizon Energy</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="breadcrumb_area" style="background: url(order_page/assets/images/3.png);">
        <div class="container">
            <div class="row wow fadeInUp">
                <div class="col-12">
                    <div class="breadcrumb_text  mb-5 text-center " style="height: 90vh">
                        <h1 id="personal_h1">Welocome Horizon Energy <br> Online Order</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="menu_grid_view mt_120 xs_mt_100">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 order-2 wow fadeInLeft">
                    <div class="menu_sidebar sticky_sidebar">
                        <div class="sidebar_wizard sidebar_category mt_25">
                            <h2>Categories</h2>
                            <ul>
                                @foreach ($all_categories as $category)
                                    <li>
                                        <!-- Category Link with Sub-menu Toggle -->
                                        <a href="javascript:void(0);" class="category-toggle main-category">
                                            <!-- Added 'main-category' class -->
                                            {{ $category->category }} <span>({{ $category->products_count }})</span>
                                        </a>

                                        <!-- Sub-menu for the category -->
                                        <ul class="sub-menu" style="display: none;">
                                            @foreach ($category->products as $product)
                                                <!-- Assuming each category has a 'products' relationship -->
                                                <li>
                                                    <a href="#">{{ $product->name }}</a>
                                                    <!-- Show product name in sub-menu -->
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 order-lg-2">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-xl-4 col-sm-6 wow fadeInUp">
                                <div class="single_menu">
                                    <div class="single_menu_img">
                                        <img src="{{ asset('product_images/' . $product->image) }}" alt="menu"
                                            class="img-fluid w-100">
                                        <!-- <img src="order_page/assets/images/menu_img_2.jpg" alt="menu" class="img-fluid w-100"> -->
                                    </div>
                                    <div class="single_menu_text">
                                        <a class="category" href="#">{{ $product->category->category }}</a>
                                        <a class="title" href="#">
                                            {{ $product->name }} <span
                                                class="unit">({{ $product->unit->unit }})</span>
                                            <br> <span class="text-warning">{{ $product->subcategory->name ?? '' }}
                                            </span>
                                        </a>
                                        <p class="descrption">{{ $product->description }}</p>
                                        <div class="d-flex align-items-center">
                                            <a class="add_to_cart btn btn-warning text-white" href="#"
                                                data-bs-toggle="modal" data-bs-target="#cartModal">Order Now</a>
                                            <h3>Pkr:{{ $product->price }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="menu_grid_view mt_120 xs_mt_100">
        <div class="container">
            <div class="row">
                <!-- Sidebar Start -->
                <div class="col-xl-3 col-lg-4 col-md-6 ">
                    <div class="menu_sidebar sticky_sidebar">
                        <div class="sidebar_wizard sidebar_category mt_25">
                            <h2>Categories</h2>
                            <ul>
                                @foreach ($all_categories as $category)
                                    <li>
                                        <a href="javascript:void(0);" class="category-toggle main-category">
                                            {{ $category->category }} <span>({{ $category->products_count }})</span>
                                        </a>
                                        <ul class="sub-menu" style="display: none;">
                                            @foreach ($category->products as $product)
                                                <li>
                                                    <a href="#">{{ $product->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Sidebar End -->

                <!-- Products Start -->
                <div class="col-xl-9 col-lg-9 col-md-6">
    <!-- Deals Start -->
    <div class="mt-5">
        <h2 class="mb-4">All Deals / Packages</h2>

        <!-- Slick Slider Wrapper -->
        <div class="deal-slider">
            @foreach ($deals as $deal)
                <div class="px-2"> <!-- px-2 for spacing between slides -->
                    <div class="single_menu border rounded p-3 shadow-sm bg-white">
                        <div class="single_menu_img text-center mb-3">
                            <img src="{{ asset($deal->image) }}" alt="deal" class="img-fluid" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                        </div>
                        <div class="single_menu_text text-center">
                            <a class="category text-muted d-block mb-1" href="#">{{ $deal->category->name ?? 'No Category' }}</a>
                            <a class="title d-block fw-bold fs-5 mb-2" href="#">{{ $deal->title }}</a>
                            <p class="descrption small text-secondary mb-3">{{ $deal->description }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a
                                    class="add_to_cart btn btn-sm btn-success text-white"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#dealModal"
                                    data-products="{{ $deal->product }}">
                                    View
                                </a>
                                <h5 class="mb-0 text-primary">PKR: {{ $deal->price }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- End Slick Wrapper -->
    </div>
    <!-- Deals End -->
</div>

            </div>
        </div>
    </section>

<!-- Button to trigger the modal -->

<!-- Modal Structure -->
<div class="modal fade" id="dealModal" tabindex="-1" aria-labelledby="dealModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dealModalLabel">Book Your Deal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
      <!-- Modal Body -->
<div class="modal-body">
    <h6><strong>Products:</strong></h6>
    <ul id="productList" class="mb-3"></ul> <!-- Product names will be inserted here -->
</div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Confirm Booking</button>
            </div>
        </div>
    </div>
</div>

    <section class="pt-100 pb-100 bg-light text-center" style="margin-top:50px !important">
        <div class="container"> <br>
            <h1 class="mt-5" style="margin-top: 30px !important">About Horizon Solar</h1>
            <p class="mt-4">Empowering homes and businesses with sustainable, high-performance solar energy solutions.
                Save costs, protect the planet, and brighten the future with Horizon Solar.</p>
            <div class="row mt-5">
                <div class="col-md-4 mb-4">
                    <div class="p-4 bg-white shadow rounded h-100">
                        <div class="mb-3">
                            <i class="fas fa-bullseye fa-2x text-success"></i>
                        </div>
                        <h5 class="mb-2">Our Mission</h5>
                        <p>Making clean solar energy simple and accessible, while helping you lower costs and protect
                            the environment.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="p-4 bg-white shadow rounded h-100">
                        <div class="mb-3">
                            <i class="fas fa-lightbulb fa-2x text-warning"></i>
                        </div>
                        <h5 class="mb-2">Our Vision</h5>
                        <p>Leading the way in solar innovation to create a cleaner, greener world for future
                            generations.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="p-4 bg-white shadow rounded h-100">
                        <div class="mb-3">
                            <i class="fas fa-solar-panel fa-2x text-primary"></i>
                        </div>
                        <h5 class="mb-2">Why Choose Us?</h5>
                        <p>From design to installation and support, we deliver reliable solar solutions for lasting
                            benefits.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="pt-100 mt-120 text-white bg-dark " style="margin-top:50px !important">
        <div class="container mt-5">
            <div class="row gy-4">
                <!-- Logo and Intro -->
                <div class="col-lg-4 col-md-6">
                    <a class="footer_logo d-block mb-3" href="#">
                        <img src="order_page/assets/images/logo.png" alt="Horizon Solar" style="max-width: 180px;">
                    </a>
                    <p class="text-light">Powering a brighter future with innovative and sustainable solar solutions
                        for homes and businesses.</p>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4 col-md-6 mt-5">
                    <h4 class="mb-3 text-light">Contact Us</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Plot 45, I-9 Industrial Area,
                            Islamabad</li>
                        <li class="mb-2"><i class="fas fa-phone-alt me-2"></i> +92 300 1234567</li>
                        <li><i class="fas fa-envelope me-2"></i> info@horizonsolar.com</li>
                    </ul>
                </div>

                <!-- Social Media -->
                <div class="col-lg-4 col-md-12 mt-5">
                    <h4 class="mb-3 text-light">Follow Us</h4>
                    <div class="d-flex">
                        <a class="text-white me-3 fs-4" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="text-white me-3 fs-4" href="#"><i class="fab fa-instagram"></i></a>
                        <a class="text-white fs-4" href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

            </div>

            <hr class="border-secondary my-4">

            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-3">&copy; 2025 Horizon Solar. All rights reserved. Designed & developed by ProWave
                        Software Solutions.</p>
                </div>
            </div>
        </div>
    </footer>




    <!--==========================
        FOOTER END
    ===========================-->
    <!-- Order Table Modal -->
    <!-- Order Now Modal -->
    <!-- Order Now Modal -->
    <!-- Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="font-family: 'Poppins', sans-serif;">
                <div class="modal-header text-white" style="background: #094d9e">
                    <h5 class="modal-title text-white" id="cartModalLabel">Order Summary</h5>
                    <button type="button" class="btn text-white" data-bs-dismiss="modal"
                        aria-label="Close">✖</button>
                </div>
                <div class="modal-body">
                    <!-- CSRF Token -->
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <!-- Solar System Order Details -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Client Name</label>
                            <input type="text" class="form-control" name="client_name"
                                placeholder="Enter Client Name">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Contact Number</label>
                            <input type="text" class="form-control" name="contact_number"
                                placeholder="03XX-XXXXXXX">
                        </div>


                        <div class="col-md-4">
                            <label class="form-label">Order Date</label>
                            @php $today = date('Y-m-d'); @endphp
                            <input type="date" class="form-control" name="order_date"
                                value="{{ $today }}" min="{{ $today }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Installation Address</label>
                            <input type="text" class="form-control" name="address"
                                placeholder="Installation Site Address">
                        </div>
{{--
                        <div class="col-md-4">
                            <label class="form-label">Type of Installation</label>
                            <select class="form-control" name="installation_type">
                                <option value="">Select Type</option>
                                <option value="Residential">Residential</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Industrial">Industrial</option>
                            </select>
                        </div> --}}

                        <div class="col-md-4">
                            <label class="form-label">System Capacity (kW)</label>
                            <input type="number" class="form-control" name="system_capacity"
                                placeholder="e.g. 5, 10, 20">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Structure Type</label>
                            <select class="form-control" name="structure_type">
                                <option value="">Select Structure</option>
                                <option value="Standard L2/L3">Standard L2/L3</option>
                                <option value="Customized Pipe">Customized Pipe</option>
                                <option value="Customized Girder">Customized Girder</option>
                                <option value="Rail Mounting">Rail Mounting</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Battery Type</label>
                            <select class="form-control" name="battery_type">
                                <option value="">Select Battery Type</option>
                                <option value="Lithium">Lithium</option>
                                <option value="Lead Acid">Lead Acid</option>
                                <option value="Dry">Dry</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Battery Capacity (Ah)</label>
                            <input type="number" class="form-control" name="battery_capacity"
                                placeholder="e.g. 150, 200">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Inverter Brand</label>
                            <input type="text" class="form-control" name="inverter_brand"
                                placeholder="e.g. Inverex, Tesla">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Panels Brand</label>
                            <input type="text" class="form-control" name="panel_brand"
                                placeholder="e.g. JA Solar, Longi">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Special Instructions</label>
                            <textarea class="form-control" name="special_instructions" rows="2" placeholder="Any special requirements..."></textarea>
                        </div>
                    </div>

                    <!-- Order Items Table -->
                    <table class="table table-bordered text-center">
                        <thead style="background-color: #094d9e; color: white;">
                            <tr>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Unit</th>
                                <th>Price (PKR)</th>
                                <th style="width: 100px;">Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="cartItems"></tbody>
                    </table>

                    <!-- Subtotal -->
                    <div class="text-end mt-3">
                        <h4><strong>Subtotal: <span id="subtotal" class="text-success">PKR 0</span></strong></h4>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="confirmOrder">Confirm Order</button>
                </div>
            </div>
        </div>
    </div>





    <!--==========================
        SCROLL BUTTON START
    ===========================-->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!--==========================
        SCROLL BUTTON END
    ===========================-->


    <!--jquery library js-->
    <script src="order_page/assets/js/jquery-3.7.1.min.js"></script>
    <!--bootstrap js-->
    <script src="order_page/assets/js/bootstrap.bundle.min.js"></script>
    <!--font-awesome js-->
    <script src="order_page/assets/js/Font-Awesome.js"></script>
    <!--nice select js-->
    <script src="order_page/assets/js/jquery.nice-select.min.js"></script>
    <!--marquee js-->
    <script src="order_page/assets/js/jquery.marquee.min.js"></script>
    <!--slick js-->
    <script src="order_page/assets/js/slick.min.js"></script>
    <!--countup js-->
    <script src="order_page/assets/js/jquery.waypoints.min.js"></script>
    <script src="order_page/assets/js/jquery.countup.min.js"></script>
    <!--venobox js-->
    <script src="order_page/assets/js/venobox.min.js"></script>
    <!--scroll button js-->
    <script src="order_page/assets/js/scroll_button.js"></script>
    <!--price ranger js-->
    <script src="order_page/assets/js/ranger_jquery-ui.min.js"></script>
    <script src="order_page/assets/js/ranger_slider.js"></script>
    <!--select 2 js-->
    <script src="order_page/assets/js/select2.min.js"></script>
    <!--aos js-->
    <script src="order_page/assets/js/wow.min.js"></script>
    <!--colorfulTab js-->
    <script src="order_page/assets/js/colorfulTab.min.js"></script>
    <!--sticky sidebar js-->
    <script src="order_page/assets/js/sticky_sidebar.js"></script>
    <!--animated barfiller js-->
    <script src="order_page/assets/js/animated_barfiller.js"></script>
    <!--animatedheadline js-->
    <script src="order_page/assets/js/jquery.animatedheadline.min.js"></script>
    <!--script/custom js-->
    <script src="order_page/assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function(){
        $('.deal-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            dots: false,       // pagination dots removed
            arrows: false,     // navigation arrows removed
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dealModal = document.getElementById('dealModal');

        dealModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const products = button.getAttribute('data-products');
            const productList = dealModal.querySelector('#productList');

            // Clear existing product list items
            productList.innerHTML = '';

            // If products are present
            if (products) {
                // Check if it's JSON (like '["Fan", "AC"]') or comma separated (like 'Fan,AC')
                let productArray = [];
                try {
                    productArray = JSON.parse(products);
                } catch (e) {
                    productArray = products.split(',');
                }

                productArray.forEach(product => {
                    const li = document.createElement('li');
                    li.textContent = product.trim();
                    productList.appendChild(li);
                });
            }
        });
    });
</script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let cartItems = document.getElementById("cartItems");
            let subtotalElement = document.getElementById("subtotal");

            document.querySelectorAll(".add_to_cart").forEach(button => {
                button.addEventListener("click", function() {
                    let productCard = this.closest(".single_menu_text");
                    let itemName = productCard.querySelector(".title").textContent.trim();
                    let category = productCard.querySelector(".category").textContent.trim();
                    let subcategory = productCard.querySelector(".text-danger").textContent.trim();
                    let unit = productCard.querySelector(".unit")?.textContent.trim() || 'N/A';
                    let price = parseFloat(productCard.querySelector("h3").textContent.replace(
                        "Pkr:", "").trim());
                    let quantity = 1;
                    let total = price * quantity;

                    let newRow = `
                    <tr>
                        <td>${itemName}</td>
                        <td>${category}</td>
                        <td>${subcategory}</td>
                        <td>${unit}</td>
                        <td>${price}</td>
                        <td>
                            <input type="number" class="form-control quantity-input text-center" value="${quantity}" min="1" data-price="${price}" style="width: 70px;">
                        </td>
                        <td class="item-total">${total}</td>
                        <td>
                            <button class="btn btn-danger btn-sm delete-item">X</button>
                        </td>
                    </tr>`;

                    cartItems.insertAdjacentHTML("beforeend", newRow);
                    updateTotals();
                });
            });

            // Function to update subtotal
            function updateTotals() {
                let subtotal = 0;
                document.querySelectorAll(".item-total").forEach(cell => {
                    subtotal += parseFloat(cell.textContent);
                });
                subtotalElement.textContent = `PKR ${subtotal.toFixed(2)}`;
            }

            // Event delegation for quantity change and delete button
            cartItems.addEventListener("input", function(event) {
                if (event.target.classList.contains("quantity-input")) {
                    let quantityInput = event.target;
                    let price = parseFloat(quantityInput.getAttribute("data-price"));
                    let quantity = parseInt(quantityInput.value) || 1;

                    let totalCell = quantityInput.closest("tr").querySelector(".item-total");
                    totalCell.textContent = (price * quantity).toFixed(2);

                    updateTotals();
                }
            });

            cartItems.addEventListener("click", function(event) {
                if (event.target.classList.contains("delete-item")) {
                    event.target.closest("tr").remove();
                    updateTotals();
                }
            });

        });

        document.getElementById("confirmOrder").addEventListener("click", function() {
            let orderData = {
                client_name: document.querySelector("[name='client_name']").value.trim(),
                sale_date: document.querySelector("[name='sale_date']").value.trim(),
                order_name: document.querySelector("[name='order_name']").value.trim(),
                program_date: document.querySelector("[name='program_date']").value.trim(),
                delivery_time: document.querySelector("[name='delivery_time']").value.trim(),
                venue: document.querySelector("[name='venue']").value.trim(),
                person_program: document.querySelector("[name='person_program']").value.trim(),
                event_type: document.querySelector("[name='event_type']").value.trim(),
                special_instructions: document.querySelector("[name='special_instructions']").value.trim(),
                total_price: document.getElementById("subtotal").textContent.replace("PKR ", "").trim(),
                items: []
            };

            document.querySelectorAll("#cartItems tr").forEach(row => {
                orderData.items.push({
                    item_name: row.children[0].textContent.trim(),
                    item_category: row.children[1].textContent.trim(),
                    item_subcategory: row.children[2]?.textContent.trim() ||
                    "", // Handle missing subcategory
                    unit: row.children[3].textContent.trim(),
                    price: row.children[4].textContent.trim(),
                    quantity: row.querySelector(".quantity-input").value,
                    total: row.children[6].textContent.trim(),
                });
            });

            fetch("{{ route('save.order') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                            "content")
                    },
                    body: JSON.stringify(orderData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: "Order Placed!",
                            text: "Your order has been placed successfully.",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Page refresh after closing alert
                            }
                        });

                        document.getElementById("cartModal").classList.remove("show");
                        document.querySelector(".modal-backdrop")?.remove(); // Handle modal backdrop safely
                        document.getElementById("cartItems").innerHTML = ""; // Clear Cart
                        document.getElementById("subtotal").textContent = "PKR 0";
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: "There was an issue saving your order. Please try again.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire({
                        title: "Error!",
                        text: "Something went wrong. Please try again later.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                });
        });
    </script>
    <!-- JavaScript to toggle sub-menu visibility -->
    <script>
        document.querySelectorAll('.category-toggle').forEach(function(categoryLink) {
            categoryLink.addEventListener('click', function() {
                let subMenu = this
                .nextElementSibling; // Next element after the category link is the sub-menu
                if (subMenu.style.display === "none" || subMenu.style.display === "") {
                    subMenu.style.display = "block"; // Show sub-menu
                } else {
                    subMenu.style.display = "none"; // Hide sub-menu
                }
            });
        });
    </script>


</body>

</html>
