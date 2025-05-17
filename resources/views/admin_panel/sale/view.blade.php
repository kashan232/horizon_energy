<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice-header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .invoice-header img {
            max-width: 120px;
        }

        .company-info {
            text-align: center;
            font-size: 14px;
        }

        .invoice-title {
            margin-top: 10px;
            font-weight: bold;
            font-size: 24px;
        }

        table th,
        table td {
            font-size: 14px;
            vertical-align: top;
        }

        .total-row {
            font-weight: bold;
        }

        .note {
            font-size: 13px;
            margin-top: 20px;
        }

        @media print {

            .print-btn,
            .back-btn {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="container my-4">

        <!-- Header -->
        <div class="invoice-header">
        <div class="mt-5" style="line-height: 1px;"><span class="current-date"></span></div>



            <div class="mt-5 invoice-title" style="line-height: 9px;">Horizone Energy</div>
            <div class=""></div>
        </div>
        <div class="d-flex  mb-4">
            <div class="col-3" >
                <img src="{{ asset('product_images/1744460783_67fa5bef9290e.png') }}" alt="Company Logodsadasdsad" style="right:3px !important;width: 260px;height: 500px;position:absolute;bottom:-90px;">

            </div>

            <div class="col-6" style="margin-left: 20px;">
                <p class="card-title"> <strong>Bussines Number</strong> :
                    <strong>0300-1234567</strong>
                </p>
                <p style="width:400px"><strong>Address : </strong> Plot 45, I-9 Industrial Area, Islamabad</p>
                <p style="width:400px"><strong>Email : </strong>  info@horizonsolar.com</p>

            </div>
            <div class="col-3"style="display: flex; justify-content: flex-end;">
            <div>    <p><strong>STRING-7439:</strong> <br> {{ $purchase->invoice_no }}</p>
                <p><strong>DATE:</strong><br> 20/04/2025, 17:01</p>
                <p><strong>DUE:</strong><br> 20/04/2025, 17:01</p>
                <p><strong>BALANCE DUE:</strong> <br> {{ $purchase->due_amount }}</p></div>
            </div>
        </div>
        <hr>
        <!-- Invoice Info -->
        <div class="row mb-4">
            <div class="col-sm-6">
                <p>BELL TO</p>
              <p><strong>MR {{ $purchase->customer }}</strong></p>

@foreach ($customer as $item)
    @if($item->name === $purchase->customer)
        <p>Address: {{ $item->address }}</p>
        <p>Phone: {{ $item->phone }}</p>
        {{-- Aur jo bhi fields chahiye --}}
    @endif
@endforeach




            </div>
        </div>

        <!-- Table -->
        <table class="table ">
            <thead>
                <tr>
                    <th style="border-top:2px solid black;border-bottom: 2px solid black !important;">DESCRIPTION</th>
                    <th style="border-top:2px solid black;border-bottom: 2px solid black !important;">RATE</th>
                    <th style="border-top:2px solid black;border-bottom: 2px solid black !important;">QTY</th>
                    <th style="border-top:2px solid black;border-bottom: 2px solid black !important;">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                 @foreach($purchase->item_name as $index => $item)

                <tr>
                    @php
        $categoryId = $purchase->item_category[$index] ?? null;
        $categoryName = $categories[$categoryId] ?? '';
    @endphp

        <td>{{ $categoryName }}{{ $item }}</td>
                    <td>{{ $purchase->price[$index] }}</td>
                    <td>{{ $purchase->quantity[$index] }}</td>
                    <td>{{ $purchase->price[$index] }}</td>
                </tr>

                  @endforeach

            </tbody>

        </table>
         <div class="mt-5">
        <div class="" style="line-height: 20px;"><span class="current-date"></span></div>



            <div class=" " style="line-height: 20px;"></div>
            <div class=""></div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th style="border-top:2px solid black;border-bottom: 2px solid black !important;">DESCRIPTION</th>
                    <th style="border-top:2px solid black;border-bottom: 2px solid black !important;">RATE</th>
                    <th style="border-top:2px solid black;border-bottom: 2px solid black !important;">QTY</th>
                    <th style="border-top:2px solid black;border-bottom: 2px solid black !important;">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                 @foreach($purchase->item_name as $index => $item)

                <tr>
                    <td>{{  $categories[$purchase->item_category[$index]] }} <br>  {{ $item }}</td>
                    <td>{{ $purchase->price[$index] }}</td>
                    <td>{{ $purchase->quantity[$index] }}</td>
                    <td>{{ $purchase->price[$index] }}</td>
                </tr>
                  @endforeach
 <tr>
                    <td colspan="4" style="padding-top: 30px;border:none"></td>
                </tr>
            </tbody>
            <br>
 <tfoot class="mt-5">
    <tr>
        <td colspan="3" class="text-right"><strong>Total Price:</strong></td>
        <td>{{ $purchase->total_price }}</td>
    </tr>
    <tr>
        <td colspan="3" class="text-right"><strong>Discount:</strong></td>
        <td>{{ $purchase->discount }}</td>
    </tr>
    <tr>
        <td colspan="3" class="text-right"><strong>Payable Amount:</strong></td>
        <td>{{ $purchase->Payable_amount }}</td>
    </tr>
    <tr>
        <td colspan="3" class="text-right"><strong>Paid Amount:</strong></td>
        <td>{{ $purchase->paid_amount }}</td>
    </tr>
    <tr>
        <td colspan="3" class="text-right"><strong>Due Amount:</strong></td>
        <td>{{ $purchase->due_amount }}</td>
    </tr>
</tfoot>

        </table>
        <!-- Notes -->
        <div class="note">
            <strong>Note:</strong> The system will contain A Grade Material and we will be giving 1 year complete system
            warranty.
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-between mt-4">
            <button class="btn btn-danger print-btn" onclick="window.print()">
                <i class="la la-print"></i> Print Invoice
            </button>
            <a href="{{ route('Purchase') }}" class="btn btn-secondary back-btn">
                <i class="la la-arrow-left"></i> Back
            </a>
        </div>

    </div>

</body>

</html><script>
    const today = new Date();
    const day = String(today.getDate()).padStart(2, '0');
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const year = today.getFullYear();
    const formattedDate = `${day}/${month}/${year}`;

    document.querySelector('.current-date').innerText = formattedDate;
</script>
