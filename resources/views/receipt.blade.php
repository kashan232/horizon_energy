<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
    <style>
        /* Simple styling for receipt */
        .receipt {
            width: 300px;
            margin: auto;
            padding: 10px;
            border: 1px solid #000;
        }
        .receipt h3 {
            text-align: center;
        }
        .receipt table {
            width: 100%;
            border-collapse: collapse;
        }
        .receipt table, .receipt th, .receipt td {
            border: 1px solid #000;
        }
        .receipt th, .receipt td {
            padding: 5px;
            text-align: left;
        }
        /* Print styling */
        @media print {
            .receipt {
                width: 100%;
                margin: 0;
                padding: 0;
                border: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <h3>Receipt</h3>
        <p>Invoice No: {{ $invoice_no }}</p>
        <p>Supplier: {{ $supplier }}</p>
        <p>Date: {{ $purchase_date }}</p>
        <p>Warehouse: {{ $warehouse_id }}</p>
        
        <table>
            <thead>
                <tr>
                    <th>Item Category</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach (json_decode($item_category) as $key => $category)
                <tr>
                    <td>{{ $category }}</td>
                    <td>{{ json_decode($item_name)[$key] }}</td>
                    <td>{{ json_decode($quantity)[$key] }}</td>
                    <td>{{ json_decode($price)[$key] }}</td>
                    <td>{{ json_decode($total)[$key] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p>Note: {{ $note }}</p>
        <p>Total Price: {{ $total_price }}</p>
        <p>Discount: {{ $discount }}</p>
        <p>Payable Amount: {{ $Payable_amount }}</p>
        <p>Cash Received: {{ $cash_received }}</p>
        <p>Change to Return: {{ $change_return }}</p>

        <button class="no-print" onclick="window.print()">Print Receipt</button>
    </div>
</body>
</html>
