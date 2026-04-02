<?php 
include('includes/header.php'); 
if(!isset($_SESSION['productItems'])){
    echo '<script> window.location.href = "order-create.php"; </script>';
}
?>

<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-md-5"> <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <h5 class="mb-0">Bill Preview</h5>
                    <a href="order-create.php" class="btn btn-sm btn-light">Edit</a>
                </div>
                
                <div class="card-body bg-white" id="myBillingArea" style="font-family: 'Courier New', Courier, monospace; color: #000;">
                    <div style="text-align: center; border-bottom: 1px dashed #000; padding-bottom: 10px; margin-bottom: 10px;">
                        <h4 style="margin:0; font-weight: bold;">SE TECHNOLOGIES</h4>
                        <p style="font-size: 12px; margin: 2px;">447/5 DEEPAHAN BUILDING, BATUWATTA</p>
                        <p style="font-size: 12px; margin: 2px;">TEL: 0765789022</p>
                    </div>

                    <div style="font-size: 13px; margin-bottom: 10px;">
                        <b>Invoice:</b> <?= $_SESSION['invoice_no']; ?><br>
                        <b>Tracking:</b> <?= $_SESSION['tracking_no']; ?><br>
                        <b>Date:</b> <?= date('d/m/Y H:i'); ?><br>
                        <b>Customer:</b> <?= $_SESSION['cphone']; ?>
                    </div>

                    <table style="width: 100%; font-size: 13px; border-bottom: 1px dashed #000;">
                        <thead>
                            <tr style="border-bottom: 1px solid #000;">
                                <th align="left">Item</th>
                                <th align="center">Qty</th>
                                <th style="text-align: right; padding-right: 10px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($_SESSION['productItems'] as $row) : ?>
                            <tr>
                                <td style="padding: 5px 0;"><?= substr($row['prod_name'], 0, 20); ?></td>
                                <td align="center"><?= $row['quantity']; ?></td>
                                <td align="right"><?= number_format($row['sale_price'] * $row['quantity'], 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div style="margin-top: 10px; font-size: 14px;">
                        <div style="display: flex; justify-content: space-between;">
                            <span>Sub Total:</span>
                            <span>Rs. <?= number_format($_SESSION['sub_total'], 2); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Discount:</span>
                            <span><?= $_SESSION['discount']; ?>%</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 16px; margin: 5px 0; border-top: 1px solid #000; padding-top: 5px;">
                            <span>TOTAL:</span>
                            <span>Rs. <?= number_format($_SESSION['total_amount'], 2); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 13px;">
                            <span>Cash Received:</span>
                            <span>Rs. <?= number_format($_SESSION['cash_received'], 2); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 13px;">
                            <span>Balance:</span>
                            <span>Rs. <?= number_format($_SESSION['balance'], 2); ?></span>
                        </div>
                    </div>

                    <div style="text-align: center; margin-top: 20px; border-top: 1px dashed #000; padding-top: 10px;">
                        <p style="font-size: 12px;">THANK YOU FOR YOUR BUSINESS!</p>
                        <p style="font-size: 10px;">Software by SE Technologies</p>
                        <p style="font-size: 10px;">Tel:0765789022</p>
                    </div>
                </div>
                <div class="card-footer bg-light text-center border-0">
                    <button type="button" class="btn btn-success w-100 mb-2" id="saveOrder">CONFIRM & SAVE ORDER</button>
                    
                    <button type="button" onclick="print80mm()" class="btn btn-warning w-100 mb-2">PRINT RECEIPT</button>
                    
                    <button type="button" onclick="window.location.href='order-create.php'" class="btn btn-danger w-100">RETURN TO CREATE ORDER</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function print80mm() {
    var divContents = document.getElementById("myBillingArea").innerHTML;
    var a = window.open('', '', 'height=500, width=400');
    a.document.write('<html><head><style>');
    a.document.write('@page { size: 80mm auto; margin: 0; } body { width: 75mm; margin: 2mm; }');
    a.document.write('</style></head><body>');
    a.document.write(divContents);
    a.document.write('</body></html>');
    a.document.close();
    a.print();
}
</script>

<?php include('includes/footer.php'); ?>