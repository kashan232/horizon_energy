@include('admin_panel.include.header_include')

<style>
    .invoice-container {
        max-width: 1000px;
        margin: auto;
        padding: 30px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border: 2px solid #000;
    }
    .invoice-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 3px solid #000;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }
    .invoice-header img {
        max-width: 120px;
    }
    .invoice-header .header-text {
        text-align: right;
        flex-grow: 1;
    }
    .invoice-header h1 {
        font-size: 26px;
        font-weight: bold;
        margin: 0;
    }
    .invoice-header h2 {
        font-size: 20px;
        font-weight: bold;
        margin: 5px 0;
    }
    .invoice-header p {
        font-size: 16px;
        margin: 5px 0;
    }
    .invoice-body {
        font-size: 16px;
    }
    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .invoice-table th, .invoice-table td {
        border: 2px solid #000;
        padding: 10px;
        text-align: left;
        font-weight: normal;
        word-break: keep-all;
    }
    .invoice-footer {
        margin-top: 30px;
        text-align: center;
    }
    .signature {
        margin-top: 50px;
        text-align: right;
        font-weight: bold;
    }
    @media print {
        body * {
            visibility: hidden;
        }
        .invoice-container, .invoice-container * {
            visibility: visible;
        }
        .invoice-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }
        .invoice-footer {
            display: none;
        }
    }
</style>

<div class="page-wrapper default-version">
    @include('admin_panel.include.sidebar_include')
    @include('admin_panel.include.navbar_include')

    <div class="body-wrapper">
        <div class="bodywrapper__inner">
            <div class="invoice-container">
                <!-- Invoice Header -->
                <div class="invoice-header">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Company Logo">
                    <div class="header-text">
                        <h1>Horizon Energy</h1>
                        <h2>Receipt Voucher</h2>
                        <p><strong>Contact:</strong> +92 303 3830714</p>
                        <p><strong>Invoice Date:</strong> {{$order->delivery_date}}</p>
                    </div>
                </div>

                <!-- Invoice Body -->
                <div class="invoice-body">
                    <p><strong>Client Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Invoice #:</strong> {{ $order->id }}</p>
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Particular</th>
                                <th>Amount (Rs.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <strong>Received Amount Rs</strong> {{ $amountInWords }} Against 
                                    {{ $order->event_type }} Program Date ({{ $order->delivery_date }})<br>
                                    <strong>Location:</strong> {{ $order->Venue }}
                                </td>
                                <td>{{ number_format($order->payable_amount, 2) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"><strong>Paid Amount:</strong></td>
                                <td><strong>{{ number_format($order->advance_paid, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Remaining Amount:</strong></td>
                                <td><strong>{{ number_format($order->remaining_amount, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <p><strong>In Words:</strong> {{ $amountInWords }}</p>
                    <div class="signature">Authorized Signature: __________________</div>
                </div>

                <!-- Print Button -->
                <div class="invoice-footer">
                    <button onclick="window.print()" class="btn btn-danger"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin_panel.include.footer_include')
