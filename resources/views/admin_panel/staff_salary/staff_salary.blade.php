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


                // const employeeSelect = document.getElementById('employeeSelect');
                // const salaryInfo = document.getElementById('salaryInfo');
                // const salaryTable = document.getElementById('salaryTable');

                // employeeSelect.addEventListener('change', function () {
                //     const selectedId = employeeSelect.value;
                //     const selectedName = employeeSelect.options[employeeSelect.selectedIndex].text;
                //     if (!selectedId) return (salaryInfo.innerHTML = "");

                //     const data = employeeData[selectedName];
                //     const today = new Date();
                //     const currentMonth = today.toISOString().slice(0, 7);
                //     const currentData = data.history[currentMonth] || { paid: 0 };
                //     const due = data.salary - currentData.paid;

                //     salaryInfo.innerHTML = `
                //         <p><strong>Salary:</strong> ${data.salary}</p>
                //         <p><strong>Paid (${currentMonth}):</strong> ${currentData.paid || 0}</p>
                //         <p><strong>Due (${currentMonth}):</strong> <span class="status-due">${due}</span></p>
                //         <p><strong>Advance:</strong> <span class="status-advance">${data.advance}</span></p>
                //         <button class="btn btn-pay" onclick="paySalary('${selectedName}')">Pay Salary</button>
                //         <button class="btn btn-advance" onclick="giveAdvance('${selectedName}')">Give Advance</button>
                //     `;
                // });

                function paySalary(emp) {
                    const data = employeeData[emp];
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

                    if (!data.history[currentMonth]) {
                        data.history[currentMonth] = { paid: 0, date: today.toISOString().slice(0, 10) };
                    }

                    data.history[currentMonth].paid += amount;
                    updateTable();
                    employeeSelect.dispatchEvent(new Event('change'));
                }

                function giveAdvance(emp) {
                    const data = employeeData[emp];
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
                        alert("Invalid advance!");
                        return;
                    }

                    data.advance += amount;
                    updateTable();
                    employeeSelect.dispatchEvent(new Event('change'));
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
                            <td  style="text-align:center">${count++}</td>
                            <td>${emp}</td>
                            <td>${data.salary}</td>
                            <td>${paid}</td>
                            <td class="status-due   "><span class="badge--danger sm">${due > 0 ? due : 0}</span</td>
                            <td class="status-advance"><span class="badge--success sm">${data.advance}</td>
                            <td>${lastMonthPaid}</td>
                            <td style="text-align:center">
                                <button class="btn btn-pay" onclick="paySalary('${emp}')">Pay</button>
                                <button class="btn btn-advance" onclick="giveAdvance('${emp}')">Advance</button>
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
