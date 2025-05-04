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

        <div class="body-wrapper">
            <div class="bodywrapper__inner">
                <div class="container">
                    <h2>Employee Salary Panel (Monthly)</h2>

                    <div class="form-section">
                        <label>Employee:</label>
                        <select id="employeeSelect">
                            <option value="">--Select--</option>
                            <option value="Ali">Ali</option>
                            <option value="Sara">Sara</option>
                        </select>
                        <div id="salaryInfo" style="margin-top: 10px;"></div>
                    </div>

                    <div class="table-section">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Salary</th>
                                    <th>Paid This Month</th>
                                    <th>Due This Month</th>
                                    <th>Advance</th>
                                    <th>Last Paid Month</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="salaryTable"></tbody>
                        </table>
                    </div>
                </div>

                <style>
                    .container { max-width: 900px; margin: 30px auto; font-family: Arial; }
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
                    const employeeData = {
                        Ali: {
                            salary: 30000,
                            advance: 0,
                            history: {}
                        },
                        Sara: {
                            salary: 25000,
                            advance: 0,
                            history: {}
                        }
                    };

                    const employeeSelect = document.getElementById('employeeSelect');
                    const salaryInfo = document.getElementById('salaryInfo');
                    const salaryTable = document.getElementById('salaryTable');

                    employeeSelect.addEventListener('change', function () {
                        const emp = employeeSelect.value;
                        if (!emp) return (salaryInfo.innerHTML = "");

                        const data = employeeData[emp];
                        const today = new Date();
                        const currentMonth = today.toISOString().slice(0, 7);
                        const currentData = data.history[currentMonth] || { paid: 0 };
                        const due = data.salary - currentData.paid;

                        salaryInfo.innerHTML = `
                            <p><strong>Salary:</strong> ${data.salary}</p>
                            <p><strong>Paid (${currentMonth}):</strong> ${currentData.paid || 0}</p>
                            <p><strong>Due (${currentMonth}):</strong> <span class="status-due">${due}</span></p>
                            <p><strong>Advance:</strong> <span class="status-advance">${data.advance}</span></p>
                            <button class="btn btn-pay" onclick="paySalary('${emp}')">Pay Salary</button>
                            <button class="btn btn-advance" onclick="giveAdvance('${emp}')">Give Advance</button>
                        `;
                    });

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
                                <td>${count++}</td>
                                <td>${emp}</td>
                                <td>${data.salary}</td>
                                <td>${paid}</td>
                                <td class="status-due">${due > 0 ? due : 0}</td>
                                <td class="status-advance">${data.advance}</td>
                                <td>${lastMonthPaid}</td>
                                <td>
                                    <button class="btn btn-pay" onclick="paySalary('${emp}')">Pay</button>
                                    <button class="btn btn-advance" onclick="giveAdvance('${emp}')">Advance</button>
                                </td>
                            `;
                            salaryTable.appendChild(row);
                        }
                    }

                    updateTable();
                </script>
            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->
    </div>

    @include('admin_panel.include.footer_include')
</body>
