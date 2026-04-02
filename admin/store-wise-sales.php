<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
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

                            $query = "SELECT s.store_code, o.order_date, o.invoice_no, p.prod_name, oi.quantity, (oi.price * oi.quantity) as total_price
                                      FROM order_items oi
                                      JOIN orders o ON o.id = oi.order_id
                                      JOIN products p ON p.id = oi.product_id
                                      JOIN stores s ON s.id = o.store_id
                                      WHERE DATE(o.order_date) BETWEEN '$from' AND '$to'";
                            
                            if($store_id != "") {
                                $query .= " AND o.store_id = '$store_id'";
                            }

                            $result = mysqli_query($conn, $query);
                            if(mysqli_num_rows($result) > 0) {
                                foreach($result as $item) {
                                    ?>
                                    <tr>
                                        <td><span class="badge bg-secondary"><?= $item['store_code']; ?></span></td>
                                        <td><?= date('d-m-Y', strtotime($item['order_date'])); ?></td>
                                        <td class="fw-bold"><?= $item['invoice_no']; ?></td>
                                        <td><?= $item['prod_name']; ?></td>
                                        <td class="text-center"><?= $item['quantity']; ?></td>
                                        <td class="text-end text-primary fw-bold"><?= number_format($item['total_price'], 2); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center py-4'>No sales found for the selected criteria.</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>