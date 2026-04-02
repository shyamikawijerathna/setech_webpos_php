<?php include("includes/header.php"); ?>

<?php 
checkPermission([1, 2, 3]); 
?>

<style>
    /* Professional POS styling for the screen and printer */
    #myBillingArea1 {
        width: 80mm;
        margin: 0 auto;
        padding: 5mm;
        background-color: #ffffff;
        font-family: 'Courier New', Courier, monospace;
        color: #000;
    }

    /* Print logic */
    @media print {
        body * { visibility: hidden; }
        #myBillingArea1, #myBillingArea1 * { visibility: visible; }
        #myBillingArea1 {
            position: absolute;
            left: 0;
            top: 0;
            width: 80mm !important;
            margin: 0 !important;
            padding: 2mm !important;
        }
        @page {
            size: 80mm auto; /* Automatically adjust paper length */
            margin: 0;
        }
    }

    .receipt-header { text-align: center; margin-bottom: 10px; }
    .receipt-info { font-size: 13px; margin-bottom: 10px; }
    .receipt-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .receipt-table th { border-bottom: 1px dashed #000; text-align: left; padding: 5px 0; }
    .receipt-table td { padding: 5px 0; vertical-align: top; }
    .line { border-bottom: 1px dashed #000; margin: 10px 0; }
    .text-end { text-align: right; }
    .text-center { text-align: center; }

    .receipt-info { 
        font-size: 13px; 
        margin-bottom: 10px; 
    }
    /* Add this specific rule below to remove line spacing */
    .receipt-info p { 
        margin: 0; 
        padding: 0;
        line-height: 1.4; /* Adjust this number to make it tighter or looser */
    }
</style>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm no-print-card">
        <div class="card-header">
            <h4 class="mb-0">Print Order
                <a href="orders.php" class="btn btn-danger px-4 mx-1 float-end">Back</a>
            </h4>
        </div>

        <div class="card-body">
            <div id="myBillingArea1">
                <?php 
                if(isset($_GET['track'])) {
                    $trackingNo = validate($_GET['track']);
                    if($trackingNo == '') {
                        echo '<div class="text-center py-5"><h5>Please provide tracking number</h5></div>';
                        return false;
                    }

                    // In this query getting Order & Customer Details
                            $orderQuery = "SELECT o.*, o.id AS order_id, c.* FROM orders o 
                        JOIN customers c ON c.id = o.customer_id 
                        WHERE o.tracking_no = '$trackingNo' 
                        LIMIT 1";

                        $orderQueryRes = mysqli_query($conn, $orderQuery);

                        if($orderQueryRes && mysqli_num_rows($orderQueryRes) > 0) {
                            $orderDataRow = mysqli_fetch_assoc($orderQueryRes);
                            
                           
                            $currentOrderId = $orderDataRow['order_id'];
                        ?>
                        
                        <div class="receipt-header">
                            <h5 style="font-size: 18px; font-weight: bold;">Company XZY</h5>
                            <p style="font-size: 12px;">#555, 1st cross street, Colombo</p>
                            <p style="font-size: 12px;">company xyz pvt ltd.</p>
                        </div>

                        <div class="line"></div>

                        <div class="receipt-info">
                            <p>Inv No: <?= $orderDataRow['invoice_no']; ?></p>
                            <p>Tracking No: <?= $orderDataRow['tracking_no']; ?></p>
                            <p>Date: <?= date('d/m/Y H:i'); ?></p>
                            <p>Cust: <?= $orderDataRow['cust_name'] ?></p>
                            <p>Phone: <?= $orderDataRow['phone_number'] ?></p>
                            
                        </div>

                        <div class="line"></div>

                        <?php
                        $orderItemQuery = "SELECT oi.quantity as qty, oi.price as unit_price, p.prod_name 
                       FROM order_items oi 
                       JOIN products p ON p.id = oi.product_id 
                       WHERE oi.order_id = '$currentOrderId'";
    
                         $orderItemQueryRes = mysqli_query($conn, $orderItemQuery);

                        if($orderItemQueryRes && mysqli_num_rows($orderItemQueryRes) > 0) {
                            ?>
                          <table class="receipt-table" style="width: 100%; border-collapse: collapse;">
                                            <thead>
                                                <tr style="border-bottom: 2px solid #000;">
                                                    
                                                    <th width="50%" style="padding-bottom: 5px;">Item</th>
                                                    <th width="15%" class="text-center" style="padding-bottom: 5px;">Qty</th>
                                                    <th width="35%" class="text-end" style="padding-bottom: 5px;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($orderItemQueryRes as $item) : ?>
                                                <tr>
                                                    <td style="padding: 5px 0; border-bottom: 1px dashed #ccc;"><?= $item['prod_name']; ?></td>
                                                    <td class="text-center" style="padding: 5px 0; border-bottom: 1px dashed #ccc;"><?= $item['qty']; ?></td>
                                                    <td class="text-end" style="padding: 5px 0; border-bottom: 1px dashed #ccc;">
                                                        <?= number_format($item['unit_price'] * $item['qty'], 2) ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>

                            
                                        <table class="receipt-table table-sm" style="width: 100%; border-collapse: collapse;">
                                            <!--I need to get item count for each order <tr>
                                                <td class="text-end py-0" style="line-height: 1.2;"><b>Item Count:</b></td>
                                                <td class="text-end py-0" style="font-size: 16px; line-height: 1.2; width: 150px;"><b><?= number_format($orderDataRow['quantity'], 2); ?></b></td>
                                            </tr> -->
                                        
                                            <tr>
                                                <td class="text-end py-0" style="line-height: 1.2;"><b>Sub Total:</b></td>
                                                <td class="text-end py-0" style="font-size: 16px; line-height: 1.2; width: 150px;"><b><?= number_format($orderDataRow['sub_total'], 2); ?></b></td>
                                            </tr>
                                            <tr>
                                                <td class="text-end py-0" style="line-height: 1.2;"><b>Discount:</b></td>
                                                <td class="text-end py-0" style="font-size: 16px; line-height: 1.2;"><b><?= number_format($orderDataRow['discount'], 2); ?></b></td>
                                            </tr>
                                            <tr>
                                                <td class="text-end py-0" style="line-height: 1.2;"><b>Total Amount:</b></td>
                                                <td class="text-end py-0" style="font-size: 16px; line-height: 1.2;"><b><?= number_format($orderDataRow['total_amount'], 2); ?></b></td>
                                            </tr>
                                            <tr>
                                                <td class="text-end py-0" style="line-height: 1.2;"><b>Cash Received:</b></td>
                                                <td class="text-end py-0" style="font-size: 16px; line-height: 1.2;"><b><?= number_format($orderDataRow['cash_received'], 2); ?></b></td>
                                            </tr>
                                            <tr>
                                                <td class="text-end py-0" style="line-height: 1.2;"><b>Balance:</b></td>
                                                <td class="text-end py-0" style="font-size: 16px; line-height: 1.2;"><b><?= number_format($orderDataRow['balance'], 2); ?></b></td>
                                            </tr>
                                            
                                        </table>

                            <div class="line"></div>

                            <div class="text-center" style="margin-top: 15px; font-size: 12px;">
                                <p>Payment:<?= $orderDataRow['payment_mode']; ?></p>
                                
                            </div>

                            <div class="text-center" style="margin-top: 15px; font-size: 12px;">
                                <p>*** Thank You! ***</p>
                                <p><?= date('Y-m-d H:i:s') ?></p>
                            </div>
                            <?php
                        } else {
                            echo "<h6>No items found.</h6>";
                        }
                    } else {
                        echo "<h5>Order not found.</h5>";
                    }
                } else {
                    echo "<h5>No tracking number provided.</h5>";
                }
                ?>
            </div>
            <div class="mt-4 text-center">
                <button class="btn btn-info px-4 mx-1" onclick="window.print()">
                    <i class="fa fa-print"></i> Print Receipt
                </button>
              
            </div>

        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>