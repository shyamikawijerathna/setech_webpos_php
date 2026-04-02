<?php include("includes/header.php"); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="mb-0">Orders
                        <a href="order-create.php" class="btn btn-success float-end"> + Create Order</a>
                    </h4>
                </div>

                <div class="col-md-8">
                    <form action="" method="GET">
                        <div class="row g-1">
                           <div class="col-md-3">
                                <input type="date" 
                                    name="from_date" 
                                    class="form-control" 
                                    value="<?= isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>" />
                            </div>
                            <div class="col-md-3">
                                <input type="date" 
                                    name="to_date" 
                                    class="form-control" 
                                    value="<?= isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>" />
                            </div>

                            <div class="col-md-3">
                                    <select name="payment_status" class="form-select">
                                        <option value="">Select Payment Status</option>
                                        <option value="cash payment" <?= (isset($_GET['payment_status']) && $_GET['payment_status'] == 'cash payment') ? 'selected' : ''; ?>>
                                            Cash Payment
                                        </option>
                                        <option value="online payment" <?= (isset($_GET['payment_status']) && $_GET['payment_status'] == 'online payment') ? 'selected' : ''; ?>>
                                            Online Payment
                                        </option>
                                    </select>
                                </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary flot-end ">Filter</button>
                                <a href="orders.php" class="btn btn-danger">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="px-3 mt-3">
            <?php alertMessage(); ?>
        </div>
        <div class="card-body">

        <?php
            // --- PAGINATION LOGIC START ---
            $perPage = 20;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $page = ($page < 1) ? 1 : $page;
            $offset = ($page - 1) * $perPage;
            // --- PAGINATION LOGIC END ---

            $query = "SELECT o.*, c.* FROM orders o JOIN customers c ON c.id = o.customer_id";
            $conditions = [];

            $fromDate = isset($_GET['from_date']) ? validate($_GET['from_date']) : '';
            $toDate = isset($_GET['to_date']) ? validate($_GET['to_date']) : '';
            $paymentStatus = isset($_GET['payment_status']) ? validate($_GET['payment_status']) : '';

            if ($fromDate != '' && $toDate != '') {
                $conditions[] = "DATE(o.order_date) BETWEEN '$fromDate' AND '$toDate'";
            } elseif ($fromDate != '') {
                $conditions[] = "DATE(o.order_date) >= '$fromDate'";
            } elseif ($toDate != '') {
                $conditions[] = "DATE(o.order_date) <= '$toDate'";
            }

            if ($paymentStatus != '') {
                $conditions[] = "o.payment_mode = '$paymentStatus'";
            }

            if (count($conditions) > 0) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }

            // --- GET TOTAL COUNT FOR PAGINATION ---
            $totalCountQuery = mysqli_query($conn, $query);
            $totalRecords = mysqli_num_rows($totalCountQuery);
            $totalPages = ceil($totalRecords / $perPage);

            // --- ADD LIMIT TO ORIGINAL QUERY ---
            $query .= " ORDER BY o.id DESC LIMIT $offset, $perPage";
            $orders = mysqli_query($conn, $query);

            if($orders){
                if(mysqli_num_rows($orders) > 0)
                {
                    ?>
                    <table class="table table-striped table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Tracking No.</th>
                                <th>Invoice No.</th>
                                <th>Cus. Name</th>
                                <th>Cus. Phone</th>
                                <th>Order Amount</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Payment Mode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($orders as $orderItem) : ?>
                            <tr>
                                <td class="fw-bold"><?= $orderItem['tracking_no']; ?></td>
                                <td><?= $orderItem['invoice_no']; ?></td>
                                <td><?= $orderItem['cust_name']; ?></td>
                                <td><?= $orderItem['phone_number']; ?></td>
                                <td class="fw-bold text-primary">Rs. <?= number_format($orderItem['total_amount'], 2); ?></td>
                                <td><?= date('d M, Y h:i A', strtotime($orderItem['order_date'])); ?></td>
                                <td>
                                    <span class="badge bg-primary"><?= $orderItem['order_status']; ?></span>
                                </td>
                                <td><?= $orderItem['payment_mode']; ?></td>
                                <td>
                                    <a href="orders-view.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-info mb-0 px-2 btn-sm">View</a>
                                    <a href="orders-view-print.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-primary mb-0 px-2 btn-sm">Print</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php
                                // Keep filters in the URL when switching pages
                                $urlParams = $_GET;
                                
                                // Previous
                                $urlParams['page'] = ($page > 1) ? $page - 1 : 1;
                                echo '<li class="page-item '.($page <= 1 ? 'disabled' : '').'"><a class="page-link" href="?'.http_build_query($urlParams).'">Previous</a></li>';

                                // Page Numbers
                                for($i = 1; $i <= $totalPages; $i++){
                                    $urlParams['page'] = $i;
                                    $active = ($i == $page) ? 'active' : '';
                                    echo '<li class="page-item '.$active.'"><a class="page-link" href="?'.http_build_query($urlParams).'">'.$i.'</a></li>';
                                }

                                // Next
                                $urlParams['page'] = ($page < $totalPages) ? $page + 1 : $totalPages;
                                echo '<li class="page-item '.($page >= $totalPages ? 'disabled' : '').'"><a class="page-link" href="?'.http_build_query($urlParams).'">Next</a></li>';
                            ?>
                        </ul>
                    </nav>

                    <?php
                }
                else {
                    echo "<h5> No Record Available! </h5>";
                }
            }
            else {
                echo "<h5> Something went Wrong! </h5>";
            }
        ?>    
        </div>
    </div>
</div>

<script>
window.onload = function() {
    const barcodeElements = document.querySelectorAll('.barcode_lines');
    barcodeElements.forEach(function(el) {
        const barcodeValue = el.getAttribute('data-value');
        if(barcodeValue) {
            JsBarcode(el, barcodeValue, {
                format: "CODE128",
                lineColor: "#000",
                width: 1.5,
                height: 30,
                displayValue: false
            });
        }
    });
};
</script>

<?php include("includes/footer.php"); ?>