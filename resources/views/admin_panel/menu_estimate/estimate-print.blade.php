<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Estimate Print</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { max-width: 150px; }
        h2 { margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        .signature { margin-top: 50px; }
        .signature div { width: 45%; display: inline-block; text-align: center; }
        @media print {
            body { margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <img src="{{ asset('path/to/your/logo.png') }}" alt="Company Logo">
        <h2>Your Company Name</h2>
        <p>Contact: 123456789 | WhatsApp: 123456789 | Email: info@example.com</p>
    </div>

    <h3>Client Information</h3>
    <table>
        <tr><th>Client Name</th><td>{{ $estimate->client_name }}</td></tr>
        <tr><th>Estimate Date</th><td>{{ $estimate->estimate_date }}</td></tr>
        <tr><th>Estimate Number</th><td>#EST{{ $estimate->id }}</td></tr>
        <!-- Baaki fields yahan add kar lo -->
    </table>

    <h3>Project Details</h3>
    <table>
        <tr><th>Location Type</th><td>{{ $estimate->location_type }}</td></tr>
        <!-- Baaki fields -->
    </table>

    <h3>System Specification</h3>
    <table>
        <tr><th>Solar System Size</th><td>{{ $estimate->system_size }}</td></tr>
        <!-- Baaki fields -->
    </table>

    <h3>Cost Breakdown</h3>
    <table>
        <tr><th>Total Material Cost</th><td>{{ $estimate->material_cost }}</td></tr>
        <tr><th>Installation Charges</th><td>{{ $estimate->installation_charges }}</td></tr>
        <tr><th>Total Estimated Price</th><td>{{ $estimate->total_price }}</td></tr>
        <!-- Baaki fields -->
    </table>

    <h3>Additional Notes</h3>
    <p>Estimated Project Completion Time: {{ $estimate->completion_time }} days</p>
    <p>Maintenance Information: {{ $estimate->maintenance_info }}</p>

    <div class="signature">
        <div>
            _____________________ <br>
            Authorized Signature
        </div>
        <div>
            _____________________ <br>
            Client Signature
        </div>
    </div>

</body>
</html>
