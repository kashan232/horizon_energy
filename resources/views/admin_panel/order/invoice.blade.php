<!-- Meta tags and other links -->
@include('admin_panel.include.header_include')
<style>

body {
            font-family: Arial, sans-serif;
            position: relative;
            background: #f9f9f9;
            margin: 0;
            padding: 0px 0px;
        }

        /* Watermark */
        body::before {
            content: "Horizon Energy - Make the Vision Green";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 50px;
            color: rgba(34, 139, 34, 0.1); /* Forest green light transparent */
            white-space: nowrap;
            pointer-events: none;
            z-index: 0;
        }

     .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 3px solid #f9c600;
        padding: 10px 20px;
        background-color: #003366;
        color: white;
    }

    .logo {
        width: 120px;
    }

    .company-details {
        text-align: left;
        color: #e1e7ee;
    }

    .company-details h2 {
        color: #f9c600;
        margin: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .heading td {
            background-color: #003366; /* Forest Green */
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .item:nth-child(even) {
            background-color: #f9c70025;
        }

        .item:nth-child(odd) {
            background-color: #ffffff;
        }

        h1 {
            text-align: center;
            color: #003366;
            margin-bottom: 40px;
        }

    .total {
        text-align: right;
        font-size: 18px;
        margin-top: 10px;
        color: #003366;
    }

    .signature-section {
        margin-top: 50px;
        display: flex;
        justify-content: space-between;
    }

    .signature {
        text-align: center;
        border-top: 1px solid #000;
        width: 200px;
    }

    .invoice,
    .invoice-header,
    .invoice table,
    .invoice th,
    .invoice td {
        border: 2px solid #000 !important;
    }

    .invoice table {
        border-collapse: collapse;
    }

    .invoice th,
    .invoice td {
        padding: 10px;
        text-align: center;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .invoice,
        .invoice * {
            visibility: visible;
        }

        .invoice {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 0;
            margin: 0;
        }

        .invoice-footer {
            display: none;
            /* Hides the print button */
        }

        /* Remove extra margin/padding */
        html,
        body {
            margin: 0;
            padding: 0;
        }
    }

/* old schema */
    .invoice-container {
        width: 100%;
        background: #f8f9fa;
        padding: 30px 0;
    }

    .invoice {
        border: 2px solid #343a40;
        padding: 30px;
        width: 100%;
        max-width: 900px;
        margin: auto;
        background: #fff;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.15);
        font-family: 'Poppins', sans-serif;
        border-radius: 8px;
    }

    .invoice-header {
        text-align: center;
        margin-bottom: 25px;
        border-bottom: 2px solid #343a40;
        padding-bottom: 15px;
    }

    .invoice-header img {
        max-width: 140px;
        margin-bottom: 10px;
    }

    .invoice-header p {
        margin: 3px 0;
        font-size: 16px;
        font-weight: 600;
        color: #495057;
    }

    .invoice-title {
        font-size: 24px;
        font-weight: bold;
        margin: 20px 0;
        text-transform: uppercase;
        text-align: center;
        color: #343a40;
    }

    .invoice table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .invoice th {
        background: #343a40;
        color: #fff;
        font-size: 14px;
        padding: 10px;
        text-transform: uppercase;
    }

    .invoice td {
        font-size: 14px;
        padding: 10px;
        border: 1px solid #dee2e6;
        text-align: center;
    }

    .invoice tbody tr:nth-child(even) {
        background: #f8f9fa;
    }

    .invoice-footer {
        text-align: center;
        margin-top: 25px;
    }

    .invoice-footer .btn {
        font-size: 16px;
        padding: 10px 20px;
        background: #dc3545;
        color: #fff;
        border-radius: 6px;
        font-weight: bold;
    }

    @media print {
        .invoice-footer, .navbar-wrapper {
            display: none;
        }

        .invoice {
            border: none;
            box-shadow: none;
        }
    }
</style>

<!-- Page-wrapper start -->
<div class="page-wrapper default-version">
    @include('admin_panel.include.sidebar_include')
    <!-- Sidebar end -->

    <!-- Navbar-wrapper start -->
    @include('admin_panel.include.navbar_include')
    <!-- Navbar-wrapper end -->

    <div class="body-wrapper">
        <div class="bodywrapper__inner">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card b-radius--10">
                        <div class="card-body p-0">
                            <div class="invoice-container">
                                <div class="invoice text-center p-2">
                                    <!-- Header with Logo and Contact Details -->
                                    <div class="header">
                                        <div class="logo">
                                            <img src="{{ asset('assets\images\logo.png') }}" style="width: 100px; height:100px; background:#fdfdfd;border-radius:100%;" alt="Company Logo">
                                        </div>
                                        <div class="company-details">
                                            <strong>Horizon Green Enregy</strong><br>
                                            Head Office: Hyderabad<br>
                                            Autobahn Hyderabad<br>
                                            Phone: 123-456-7890<br>
                                            Email: info@yourcompany.com <br>
                                        </div>
                                    </div>
                                   
                                    <h2 class="my-3">INVOICE</h2>   

                                    <!-- Client and Invoice Details -->
                                    <div class="row mt-3">
                                        <div class="col-md-6"><strong>Client Name:</strong> {{ $order->customer_name }}</div>
                                        <div class="col-md-6 text-right"><strong>Invoice:</strong> #{{ $order->id }}</div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6"><strong>Venue:</strong> {{ $order->Venue }}</div>
                                        <div class="col-md-6 text-right"><strong>System Size:</strong> {{ $order->person_program ?? 'N/A' }}</div>
                                    </div>

                                    <!-- Invoice Title -->
                                    {{-- <div class="invoice-title">{{ $order->event_type }} Program Invoice</div> --}}

                                    <!-- Invoice Table -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Item Name</th>
                                                <th>Main Category</th>
                                                <th>Rate</th>
                                                <th>QTY</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $categories = json_decode($order->item_category, true);
                                            $names = json_decode($order->item_name, true);
                                            $units = json_decode($order->unit, true);
                                            $quantities = json_decode($order->quantity, true);
                                            $prices = json_decode($order->price, true);
                                            $totals = json_decode($order->total, true);
                                            @endphp

                                            @foreach ($names as $index => $name)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $name }}</td>
                                                <td>{{ $categories[$index] ?? '-' }}</td>
                                                <td>{{ number_format($prices[$index], 2) }}</td>
                                                <td>{{ $quantities[$index] }} {{ $units[$index] ?? '-' }}</td>
                                                <td>{{ number_format($totals[$index], 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td><strong>Total Price:</strong></td>
                                                <td><strong>{{ number_format($order->total_price, 2) }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td><strong>Discount:</strong></td>
                                                <td><strong>{{ number_format($order->discount, 2) }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td><strong>Advance Paid:</strong></td>
                                                <td><strong>{{ number_format($order->advance_paid, 2) }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td><strong>Remaining Amount:</strong></td>
                                                <td><strong>{{ number_format($order->remaining_amount, 2) }}</strong></td>
                                            </tr>
                                           
                                            
                                        </tfoot>
                                    </table>

                                    <!-- Print Button -->
                                    <div class="invoice-footer">
                                        <button onclick="window.print()" class="btn btn-danger"><i class="fas fa-print"></i> Print</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin_panel.include.footer_include')
