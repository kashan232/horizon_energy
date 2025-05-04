<!-- meta tags and other links -->
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
        color: rgba(34, 139, 34, 0.1);
        /* Forest green light transparent */
        white-space: nowrap;
        pointer-events: none;
        z-index: 0;
    }

    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 3px solid #034564;
        padding: 10px 20px;
        background-color: #0789c7;
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
        color: #0789c7;
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
        box-shadow: 0 2px 8px rgba(230, 26, 26, 0.05);
    }

    th,
    td {
        padding: 12px 15px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .heading td {
        background-color: #0789c7;
        /* Forest Green */
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* .item:nth-child(even) {
        background-color: #f9c70025;
    } */

    .item:nth-child(odd) {
        background-color: #ffffff;
    }

    h1 {
        text-align: center;
        color: #0789c7;
        margin-bottom: 40px;
    }

    .total {
        text-align: right;
        font-size: 18px;
        margin-top: 10px;
        color: #0789c7;
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
        border: 2px solid #045074 !important;
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
</style>
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
                            <div class="invoice text-center p-2">
                                <!-- Centered Logo -->
                                <div class="header">
                                    <div class="logo">
                                        <img src="{{ asset('assets\images\logo.png') }}"
                                            style="width: 100px; height:100px; background:#fdfdfd;border-radius:100%;"
                                            alt="Company Logo">
                                    </div>
                                    <div class="company-details">
                                        <strong>Horizon Green Enregy</strong><br>
                                        Head Office: Hyderabad<br>
                                        Autobahn Hyderabad<br>
                                        Phone: 123-456-7890<br>
                                        Email: info@yourcompany.com <br>
                                        Invoice NO: : #{{ $order->id }}
                                    </div>
                                </div>

                                <h2 class="my-3">INVOICE</h2>

                                <table>
                                    <tr class="heading">
                                        <td colspan="12">Client Information</td>
                                    </tr>
                                    <tr class="item">
                                        <td>Client Name:</td>
                                        <td>{{ $order->customer_name ?? 'N/A' }}</td>
                                        <td>Opportunity Officer :</td>
                                        <td>{{ $order->oppertunity_officer ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="item">
                                        <td>Client Contact:</td>
                                        <td>{{ $order->phone ?? 'N/A' }}</td>
                                        <td>Date of Estimate:</td>
                                        <td>{{ $order->estimate_date ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Client Address:</td>
                                        <td>{{ $order->location ?? 'N/A' }}</td>
                                    </tr>

                                </table>

                                <br>
                                <table>
                                    <tr class="heading">
                                        <td colspan="4">Project Details</td>
                                    </tr>
                                    <tr class="item">
                                        <td>System Size:</td>
                                        <td colspan="3">{{ $order->system_size ?? 'N/A' }}</td>
                                    </tr>
                                </table>


                                <table>
                                    <tr class="heading">
                                        <td>Item</td>
                                        <td>Unit</td>
                                        <td>Qty</td>
                                        <td>Total</td>
                                    </tr>
                                    @php
                                        $items = json_decode($order->item_name ?? '[]', true);
                                        $units = json_decode($order->unit ?? '[]', true);
                                        $quantities = json_decode($order->quantity ?? '[]', true);
                                        $totals = json_decode($order->total ?? '[]', true);
                                    @endphp
                                    @foreach ($items as $index => $item)
                                        <tr class="item">
                                            <td>{{ $item }}</td>
                                            <td>{{ $units[$index] ?? '-' }}</td>
                                            <td>{{ $quantities[$index] ?? '-' }}</td>
                                            <td>{{ number_format($totals[$index] ?? 0, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </table>

                                <br>

                                <table>
                                    <tr class="heading">
                                        <td colspan="3">Grand Total</td>
                                        <td><strong>Rs {{ number_format($order->total_price ?? 0, 2) }}</strong></td>
                                    </tr>
                                </table>




                                <!-- Signature Section -->
                                <div class="signature-section">
                                    <div class="signature">
                                        <div class="sign-box">
                                            <hr style="width:200px;">
                                            <strong>Client Signature</strong>
                                        </div>
                                    </div>
                                    <div class="signature">
                                        <div class="sign-box">
                                            <hr style="width:200px;">
                                            <strong>Authorized Signature</strong><br>
                                        </div>
                                    </div>
                                </div>

                                <div class="footer">
                                    Thank you for your business!
                                </div>
                                <!-- Print Button -->
                                <div class="invoice-footer mt-4  mb-3">
                                    <button onclick="window.print()" class="btn btn-danger"><i class="fas fa-print"></i>
                                        Print</button>
                                </div>


                                <hr style="margin-top: 40px;">
                                <div style="text-align: center; font-size: 13px; color: #555;">
                                    <span>Developed and Designed by <strong>ProWave Software
                                            Solution</strong></span><br>
                                    <span>📞 +92 317 3836223 | +92 317 3859647</span>
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
