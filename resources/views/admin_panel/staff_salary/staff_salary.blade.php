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
        .dataTables_length,.dataTables_filter{
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

        .dataTables_paginate  {
            margin-bottom: 18px !important;
        }

        .dataTables_paginate .paginate_button.current {
/* background-color: #0a6b9a !important; */
color: rgb(223, 22, 22) !important;
}

.sorting {
    background-color:#0a6b9a !important;

}
table{
    font-size: 0.75rem;
    text:centen;
    color:black
}

    </style>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

   <link rel="stylesheet" href="datatables.checkboxes.css" />


    <div class="body-wrapper">
        <div class="bodywrapper__inner">
            <div class="container">
                <h6>Employee Salary Panel (Monthly)</h6>

                {{-- <div class="form-section">
                    <label>Employee:</label>
                    <select id="employeeSelect" name="staff_id">
                        <option value="">--Select--</option>
                        @foreach($staff as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                    <div id="salaryInfo" style="margin-top: 10px;"></div>
                </div> --}}

                <div class="table-section table-responsive--sm table-responsive bg-white " style="border-radius: 10px">
                    <table  id="userTable" >
                        <thead>
                            <tr>
                                <th  style="text-align:center">#</th>
                                <th>Employee test</th>
                                <th>Salary</th>
                                <th>Paid This Month</th>
                                <th>Due This Month</th>
                                <th>Advance</th>
                                <th>Last Paid Month</th>
                                <th  style="text-align:center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="salaryTable"></tbody>
                    </table>
                </div>
            </div>

            <style>
                .container { margin: 30px auto; font-family: Arial; }
                .form-section, .table-section { margin-top: 20px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
                .btn { padding: 5px 10px; margin: 2px; cursor: pointer; }
                .btn-pay { background-color: green; color: white; }
                .btn-advance { background-color: orange; color: white; }
                .status-due { color: red; }
                .status-advance { color: blue; }
                .status-clear { color: green; }
            </style>
<script>
    const employeeData = {!! $employeeDataJson !!};
    const salaryTable = document.getElementById('salaryTable');

    function paySalary(empId) {
        const data = employeeData[empId];
        const today = new Date();
        const currentMonth = today.toISOString().slice(0, 7);
        const currentData = data.history[currentMonth] || { paid: 0 };
        const due = data.salary - currentData.paid;

        if (due <= 0) {
            alert("Salary already fully paid this month.");
            return;
        }

        let amount = prompt(`Enter amount to pay (Max: ${due}):`);
        amount = parseFloat(amount);
        if (isNaN(amount) || amount <= 0 || amount > due) {
            alert("Invalid amount!");
            return;
        }

        const paymentDate = today.toISOString().slice(0, 10);

        // AJAX POST request
        fetch("{{ route('staff_salaries.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                staff_id: empId,
                amount: amount,
                type: 'pay',
                payment_date: paymentDate
            })
        })
        .then(res => res.json())
        .then(res => {
            if (res.message) {
                alert(`Salary of Rs.${amount} paid to ${data.name}`);
                location.reload(); // Or call updateTable() again if dynamic update is set up
            }
        })
        .catch(err => {
            alert("Error: " + err.message);
        });
    }

    function giveAdvance(empId) {
        const data = employeeData[empId];
        const today = new Date();
        const currentMonth = today.toISOString().slice(0, 7);
        const currentData = data.history[currentMonth] || { paid: 0 };
        const due = data.salary - currentData.paid;

        if (due > 0) {
            alert("Clear due salary before giving advance.");
            return;
        }

        let amount = prompt("Enter advance amount:");
        amount = parseFloat(amount);
        if (isNaN(amount) || amount <= 0) {
            alert("Invalid advance amount!");
            return;
        }

        const paymentDate = today.toISOString().slice(0, 10);

        // AJAX POST request
        fetch("{{ route('staff_salaries.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                staff_id: empId,
                amount: amount,
                type: 'advance',
                payment_date: paymentDate
            })
        })
        .then(res => res.json())
        .then(res => {
            if (res.message) {
                alert(`Advance of Rs.${amount} given to ${data.name}`);
                location.reload(); // Or call updateTable() again if dynamic update is set up
            }
        })
        .catch(err => {
            alert("Error: " + err.message);
        });
    }

    function updateTable() {
        salaryTable.innerHTML = "";
        let count = 1;

        for (const [emp, data] of Object.entries(employeeData)) {
            const today = new Date();
            const currentMonth = today.toISOString().slice(0, 7);
            const paid = data.history[currentMonth]?.paid || 0;
            const due = data.salary - paid;
            const lastMonthPaid = Object.keys(data.history).sort().pop() || 'N/A';

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${count++}</td>
                <td>${data.name}</td>
                <td>${data.salary}</td>
                <td>${paid}</td>
                <td><span class="badge bg-danger">${due > 0 ? due : 0}</span></td>
                <td><span class="badge bg-success">${data.advance}</span></td>
                <td>${lastMonthPaid}</td>
                <td>
                    <button class="btn btn-success btn-sm" onclick="paySalary('${emp}')">Pay</button>
                    <button class="btn btn-warning btn-sm" onclick="giveAdvance('${emp}')">Advance</button>
                </td>
            `;
            salaryTable.appendChild(row);
        }
    }

    updateTable();
</script>

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
