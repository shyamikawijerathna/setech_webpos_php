<?php include("includes/header.php"); ?>

<?php 
checkPermission([1, 2, 3]); 
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Order View
                <a href="orders-view-print.php?track=<?= $_GET['track'] ?>" class="btn btn-info px-4 mx-1 float-end">Print</a>
                <a href="orders-view-print-pos.php?track=<?= $_GET['track'] ?>" class="btn btn-info px-4 mx-1 float-end">Print POS Bill</a>
                <a href="orders.php" class="btn btn-danger px-4 mx-1 float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>

            <?php 
            if(isset($_GET['track'])) {
                if($_GET['track'] == '') {
                    ?> 
                    <div class="text-center py-5">
                        <h5>No Tracking Number Found</h5>
                        <a href="orders.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                    </div>
                    <?php
                    return false;
                }

                $trackingNo = mysqli_real_escape_string($conn, validate($_GET['track']));
                
                // Fetch Order and Customer Details
                $query = "SELECT o.*, c.* FROM orders o, customers c 
                          WHERE c.id = o.customer_id AND o.tracking_no='$trackingNo' 
                          ORDER BY o.id DESC LIMIT 1";

                $orders = mysqli_query($conn, $query);

                if($orders && mysqli_num_rows($orders) > 0) {
                    $orderData = mysqli_fetch_assoc($orders);
                    ?>
                    
                    <div class="card card-body shadow-sm border-1 mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="fw-bold border-bottom pb-2">Order Details</h5>
                                <p class="mb-1">Invoice No: <span class="fw-bold"><?= $orderData['invoice_no']; ?></span></p>
                                <p class="mb-1">Tracking No: <span class="fw-bold"><?= $orderData['tracking_no']; ?></span></p>
                                <p class="mb-1">Order Date: <span class="fw-bold"><?= $orderData['order_date']; ?></span></p>
                                <p class="mb-1">Order Status: <span class="fw-bold badge bg-primary"><?= $orderData['order_status']; ?></span></p>
                                <p class="mb-1">Payment Mode: <span class="fw-bold text-success"><?= $orderData['payment_mode']; ?></span></p>
                            </div>

                            <div class="col-md-6"> 
                                <h5 class="fw-bold border-bottom pb-2">Customer Details</h5>
                                <p class="mb-1">Full Name: <span class="fw-bold"><?= $orderData['cust_name']; ?></span></p>
                                <p class="mb-1">Email Address: <span class="fw-bold"><?= $orderData['cust_email']; ?></span></p>
                                <p class="mb-1">Phone Number: <span class="fw-bold"><?= $orderData['phone_number']; ?></span></p>
                            </div>
                        </div>
                    </div>

                    <?php
                    // Fetch Order Items
                    $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, oi.price as orderItemPrice, p.prod_name, p.image 
                                       FROM order_items as oi
                                       JOIN products as p ON p.id = oi.product_id 
                                       JOIN orders as o ON o.id = oi.order_id
                                       WHERE o.tracking_no='$trackingNo'"; 
                    
                    $orderItemRes = mysqli_query($conn, $orderItemQuery);

                    if($orderItemRes && mysqli_num_rows($orderItemRes) > 0) {
                        ?>
                        <h4 class="my-3">Order Items Details</h4>
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($orderItemRes as $orderItemRow): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= $orderItemRow['image'] != '' ? '../'.$orderItemRow['image']: '../assets/images/no-img.jpg'; ?>"
                                                 style="width:40px;height:40px;object-fit:cover;" class="me-2 rounded shadow-sm" alt="img" />
                                            <?= $orderItemRow['prod_name']; ?>
                                        </td>
                                        <td width="15%" class="text-center">Rs. <?= number_format($orderItemRow['orderItemPrice'], 2); ?></td>
                                        <td width="15%" class="text-center"><?= $orderItemRow['orderItemQuantity']; ?></td>
                                        <td width="15%" class="fw-bold text-center">
                                            Rs. <?= number_format($orderItemRow['orderItemPrice'] * $orderItemRow['orderItemQuantity'], 2); ?> 
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="row">
                                <div class="col-md-7"></div> 
                                
                                <div class="col-md-5 pe-5"> 
                                    <table class="table table-bordered mt-4">
                                        <tbody>
                                            <tr>
                                                <td class="text-end text-muted">Sub Total:</td>
                                                <td class="text-end fw-bold" style="width: 180px;">Rs. <?= number_format($orderData['sub_total'], 2); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-end text-muted">Discount:</td>
                                                <td class="text-end text-danger"><?= $orderData['discount']; ?>%</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="py-0">
                                                    <hr class="my-2 ms-auto" style="width: 100%; opacity: 0.15;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end align-middle"><span class="h5 mb-0">TOTAL:</span></td>
                                                <td class="text-end align-middle">
                                                    <span class="h5 mb-0 text-primary fw-bold">Rs. <?= number_format($orderData['total_amount'], 2); ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end text-muted pt-3">Cash Received:</td>
                                                <td class="text-end pt-3">Rs. <?= number_format($orderData['cash_received'], 2); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-end fw-bold">Balance:</td>
                                                <td class="text-end fw-bold text-success">Rs. <?= number_format($orderData['balance'], 2); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php
                    } else {
                        echo '<div class="alert alert-warning">No items found for this order.</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger">No Record Found for tracking number: '.$trackingNo.'</div>';
                }
            } else {
                ?> 
                <div class="text-center py-5">
                    <h5>No Tracking Number Found</h5>
                    <a href="orders.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>