<?php 
include('includes/header.php'); 
checkPermission([1, 2, 3]); 
?>

<style>
        body { background-color: #f8f9fa; }
        .card-stats { border: none; border-radius: 15px; transition: transform 0.3s; }
        .card-stats:hover { transform: translateY(-5px); }
        .bg-gradient-primary { background: linear-gradient(45deg, #4e73df, #224abe); }
        .bg-gradient-success { background: linear-gradient(45deg, #1cc88a, #13855c); }
        .bg-gradient-warning { background: linear-gradient(45deg, #f6c23e, #dda20a); }
        .bg-gradient-dark { background: linear-gradient(45deg, #5a5c69, #373840); }
    </style>

<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Financial Reports</h1>
       <!-- <button onclick="window.print()" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-print fa-sm text-white-50"></i> Print Report
        </button> -->
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats bg-gradient-success text-white shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Daily Revenue (Today)</div>
                            <div class="h4 mb-0 fw-bold" id="daily_profit_card">Rs. 0.00</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats bg-gradient-primary text-white shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Monthly Revenue</div>
                            <div class="h4 mb-0 fw-bold" id="monthly_profit_card">Rs. 0.00</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-stats bg-gradient-dark text-white shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Total Revenue (All Time)</div>
                            <div class="h4 mb-0 fw-bold" id="total_profit_card">Rs. 0.00</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4 border-0">
        <div class="card-body bg-white rounded">
            <form id="filter_form" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">From Date</label>
                    <input type="date" id="from_date" class="form-control" value="<?= date('Y-m-01'); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">To Date</label>
                    <input type="date" id="to_date" class="form-control" value="<?= date('Y-m-d'); ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">
                        <i class="fas fa-sync-alt me-2"></i> Update Report
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!--
    <div class="col-xl-3 col-md-6 mb-4">
    <div class="card card-stats bg-gradient-warning text-white shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="opacity: 0.8;">Selected Range Profit</div>
                    <div class="h4 mb-0 fw-bold" id="range_profit_display">Rs. 0.00</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-filter fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>  -->

    <div class="card shadow mb-4 border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table me-2"></i>Daily Breakdown for Selected Range</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th class="text-center">Total Invoices</th>
                            <th>Total Income</th>
                            <th>Total Discount</th>
                            <th class="text-success">Est. Profit</th>
                        </tr>
                    </thead>
                    <tbody id="report_table_body">
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!--Store wise sales report section -->

<div class="container-fluid px-6">
    <div class="card mt-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Item Sales Report by Store</h5>
        </div>
        <div class="card-body">
            <form action="" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">From Date</label>
                        <input type="date" name="from" value="<?= $_GET['from'] ?? date('Y-m-d'); ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">To Date</label>
                        <input type="date" name="to" value="<?= $_GET['to'] ?? date('Y-m-d'); ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Store</label>
                        <select name="store_id" class="form-select">
                            <option value="">All Stores</option>
                            <?php
                                $stores = mysqli_query($conn, "SELECT id, store_code, store_name FROM stores");
                                while($st = mysqli_fetch_assoc($stores)) {
                                    $selected = (isset($_GET['store_id']) && $_GET['store_id'] == $st['id']) ? 'selected' : '';
                                    echo '<option value="'.$st['id'].'" '.$selected.'>'.$st['store_code'].' - '.$st['store_name'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Generate Report</button>
                    </div>
                </div>
            </form>

            <hr class="my-4">

            <div class="table-responsive">
                <table class="table table-hover border">
                    <thead class="table-light">
                        <tr>
                            <th>Store</th>
                            <th>Date</th>
                            <th>Invoice No</th>
                            <th>Product Name</th>
                            <th class="text-center">Qty Sold</th>
                            <th class="text-end">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($_GET['from']) && isset($_GET['to'])) {
                                $from = validate($_GET['from']);
                                $to = validate($_GET['to']);
                                $store_id = validate($_GET['store_id']);

                                if($from != '' && $to != '') {
                                    // IMPROVED QUERY: Using explicit JOIN on store_id from the orders table
                                    $query = "SELECT s.store_code as code, o.order_date, o.invoice_no, p.prod_name, oi.quantity, (oi.price * oi.quantity) as total_price
                                              FROM order_items oi
                                              INNER JOIN orders o ON o.id = oi.order_id
                                              INNER JOIN products p ON p.id = oi.product_id
                                              INNER JOIN stores s ON s.id = o.store_id
                                              WHERE DATE(o.order_date) BETWEEN '$from' AND '$to'";
                                    
                                    if($store_id != "") {
                                        $query .= " AND o.store_id = '$store_id'";
                                    }

                                    $query .= " ORDER BY o.id DESC"; // Most recent first

                                    $result = mysqli_query($conn, $query);
                                    $totalRevenue = 0;

                                    if(mysqli_num_rows($result) > 0) {
                                        while($item = mysqli_fetch_assoc($result)) {
                                            $totalRevenue += $item['total_price'];
                                            ?>
                                            <tr>
                                                <td><span class="badge bg-secondary"><?= $item['code']; ?></span></td>
                                                <td><?= date('d-m-Y', strtotime($item['order_date'])); ?></td>
                                                <td class="fw-bold text-dark"><?= $item['invoice_no']; ?></td>
                                                <td><?= $item['prod_name']; ?></td>
                                                <td class="text-center"><?= $item['quantity']; ?></td>
                                                <td class="text-end text-dark fw-bold"><?= number_format($item['total_price'], 2); ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr class="table-light">
                                            <td colspan="5" class="text-end fw-bold">Grand Total:</td>
                                            <td class="text-end fw-bold text-primary border-top border-dark" style="font-size: 1.1rem;">
                                                <?= number_format($totalRevenue, 2); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center py-4'>No sales found for the selected criteria.</td></tr>";
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Please select a date range and click Generate Report.</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('filter_form');

    function loadReportData() {
        const fromDate = document.getElementById('from_date').value;
        const toDate = document.getElementById('to_date').value;

        // Fetch data from your backend file
        fetch(`get-report-data.php?from=${fromDate}&to=${toDate}`)
            .then(response => response.json())
            .then(data => {
                // 1. Update the Summary Cards
                document.getElementById('daily_profit_card').innerText = "Rs. " + parseFloat(data.cards.daily).toLocaleString(undefined, {minimumFractionDigits: 2});
                document.getElementById('monthly_profit_card').innerText = "Rs. " + parseFloat(data.cards.monthly).toLocaleString(undefined, {minimumFractionDigits: 2});
                document.getElementById('total_profit_card').innerText = "Rs. " + parseFloat(data.cards.total).toLocaleString(undefined, {minimumFractionDigits: 2});

                // 2. Update the Table
                let tableHtml = '';
                if (data.table.length > 0) {
                    data.table.forEach(row => {
                        tableHtml += `
                            <tr>
                                <td><i class="far fa-calendar-check me-2 text-primary"></i>${row.date}</td>
                                <td class="text-center"><span class="badge rounded-pill bg-info text-dark px-3">${row.total_invoices}</span></td>
                                <td class="fw-bold text-dark">Rs. ${parseFloat(row.total_income).toFixed(2)}</td>
                                <td class="text-danger"> ${parseFloat(row.total_discount).toFixed(2)} % </td>
                                <td class="text-success fw-bold">Rs. ${parseFloat(row.estimated_profit).toFixed(2)}</td>
                            </tr>`;
                    });
                } else {
                    tableHtml = '<tr><td colspan="5" class="text-center text-muted py-4">No data found for the selected range.</td></tr>';
                }
                document.getElementById('report_table_body').innerHTML = tableHtml;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('report_table_body').innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error loading data. Check console for details.</td></tr>';
            });
    }

    // Initial Load
    loadReportData();

    // Handle Form Submit
    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        loadReportData();
    });
});


</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



<?php include('includes/footer.php'); ?>