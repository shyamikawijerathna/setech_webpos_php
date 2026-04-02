<?php 
include('includes/header1.php'); 
?>

<?php 
checkPermission([1, 2, 3]); 
?>

<div class="container-fluid ps-3 mt-4">
    
    <div class="card shadow-lg border-0 mb-4" id="quotationArea" style="background: #ffffff;">
        <div class="card-header bg-white border-bottom-0 pb-0 pt-4 px-4">
            <div class="row align-items-center mb-3">
                <div class="col-md-7">
                    <h2 class="fw-bold text-uppercase mb-1" style="color: #0d4a5e;">QUOTATION</h2>
                    <div class="company-details text-secondary">
                        <h5 class="fw-bold text-dark mb-1">SE TECHNOLOGIES</h5>
                        <p class="mb-0 small"><i class="fas fa-map-marker-alt me-2"></i>447/5 Deepahan Building, Station RD, Batuwatta</p>
                        <p class="mb-0 small"><i class="fas fa-envelope me-2"></i>shamika29.harshana@gmail.com</p>
                        <p class="mb-0 small"><i class="fas fa-phone me-2"></i>+94 765789022</p>
                    </div>
                </div>
                <div class="col-md-5 text-end">
                    <div class="p-3 rounded shadow-sm d-inline-block text-start" style="background: #f8f9fa; border-left: 4px solid #0d4a5e;">
                        <div class="mb-2 d-flex align-items-center">
                            <span class="fw-bold text-secondary me-2" style="white-space: nowrap;">Quotation No:</span>
                            <input type="text" id="q_inv_no" class="form-control form-control-sm fw-bold text-dark border-0 p-0 shadow-none" value="" placeholder="Type Num..." style="background: transparent; width: 120px; font-size: 1.1rem;">
                        </div>
                        <div class="d-flex align-items-center" style="margin-top: 5px;">
                            <span class="fw-bold text-secondary me-2" style="white-space: nowrap;">Date:</span>
                            <input type="date" id="q_date" class="form-control form-control-sm text-dark border-0 p-0 shadow-none" value="<?= date('Y-m-d'); ?>" style="background: transparent; width: 120px;">
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="mt-4 mb-4" style="border-color: #ddd;">

            <div class="row mb-4">
                <div class="col-md-5">
                    <h6 class="text-white text-uppercase fw-bold p-2 rounded" style="background: #0d4a5e;">Quotation For:</h6>
                    <div class="px-2">
                        <input type="text" class="form-control form-control-sm mb-2 border-0 border-bottom rounded-0 px-0 shadow-none text-dark fw-bold" id="q_customer_name" placeholder="Enter Customer Name">
                        <input type="text" class="form-control form-control-sm border-0 border-bottom rounded-0 px-0 shadow-none text-dark" id="q_customer_phone" placeholder="Enter Phone Number">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body px-4 pt-0">
            <?php alertMessage(); ?>
            <div class="p-4 mb-4 rounded shadow-sm no-print" style="background: linear-gradient(135deg, #0d4a5e 0%, #156680 100%)">
                <form action="quotations-code.php" method="POST">
                    <div class="row align-items-end">
                        <div class="col-md-7 mb-3 mb-md-0">
                            <label class="text-white mb-2 fw-bold">Select or Search Product</label>
                            <select name="product_id" class="form-select mySelect2 shadow-sm">
                                <option value="">-- Start Typing Product Name --</option>
                                <?php
                                $products = mysqli_query($conn, "SELECT * FROM products");
                                if(mysqli_num_rows($products) > 0){
                                    foreach($products as $prodItem){
                                        echo '<option value="'.$prodItem['id'].'">'.$prodItem['prod_name'].' (Rs.'.number_format($prodItem['sale_price'],2).')</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3 mb-md-0">
                            <label class="text-white mb-2 fw-bold">Quantity</label>
                            <input type="number" name="quantity" value="1" min="1" class="form-control shadow-sm text-center fw-bold" />
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="addItem" class="btn w-100 fw-bold shadow-sm" style="background: #ffc107; color: #000;">
                                <i class="fas fa-plus-circle me-1"></i> Add to Quote
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <?php if(isset($_SESSION['productItems']) && count($_SESSION['productItems']) > 0): ?>
                <div class="table-responsive mb-4">
                    <table class="table table-hover align-middle border mb-0">
                        <thead style="background: #f1f5f9;">
                            <tr>
                                <th class="text-center" width="5%">#</th>
                                <th width="35%">Product Description</th>
                                <th class="text-end" width="15%">Unit Price</th>
                                <th class="text-center no-print" width="15%">Adjust Qty</th>
                                <th class="text-center print-only d-none" width="10%">Qty</th>
                                <th class="text-end" width="15%">Line Total</th>
                                <th class="text-center no-print" width="10%">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $totalAmount = 0;
                                foreach($_SESSION['productItems'] as $key => $item) : 
                                    $price = (float)str_replace(',', '', $item['sale_price']);
                                    $lineTotal = $price * $item['quantity'];
                                    $totalAmount += $lineTotal;
                            ?>
                            <tr>
                                <td class="text-center text-muted"><?= $key + 1; ?></td>
                                <td class="fw-bold text-dark"><?= htmlspecialchars($item['prod_name']); ?></td>
                                <td class="text-end">Rs. <?= number_format($price, 2); ?></td>
                                
                                <td class="text-center no-print">
                                    <div class="input-group input-group-sm qtyBox mx-auto" style="width: 100px;">
                                        <input type="hidden" class="prod_id" value="<?= $item['product_id']; ?>">
                                        <button type="button" class="input-group-text decrement bg-light">-</button>
                                        <input type="text" value="<?= $item['quantity']; ?>" class="form-control qty text-center fw-bold bg-white" readonly />
                                        <button type="button" class="input-group-text increment bg-light">+</button>
                                    </div>
                                </td>
                                
                                <td class="text-center print-only d-none"><?= $item['quantity']; ?></td>
                                
                                <td class="text-end fw-bold" style="color: #0d4a5e;">Rs. <?= number_format($lineTotal, 2); ?></td>
                                <td class="text-center no-print">
                                    <a href="quote-order-item-delete.php?index=<?= $key; ?>" class="btn btn-outline-danger btn-sm rounded-circle" title="Remove Item"><i class="fas fa-times"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Financials Block -->
                <div class="row justify-content-end mb-4">
                    <div class="col-md-5">
                        <div class="p-4 rounded shadow-sm border" style="background: #ffffff;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted fw-bold text-uppercase">Sub-Total</span>
                                <span class="fw-bold fs-5 text-dark">Rs. <span id="q_sub_total"><?= number_format($totalAmount, 2, '.', ''); ?></span></span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3 no-print">
                                <span class="text-muted fw-bold text-uppercase">Discount (%)</span>
                                <input type="number" id="q_input_discount" class="form-control text-end fw-bold shadow-none w-25" value="0" min="0" max="100" style="border: 1px solid #ced4da;">
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3 print-only d-none">
                                <span class="text-muted fw-bold text-uppercase">Discount (%)</span>
                                <span class="fw-bold text-dark" id="q_print_discount_val">0%</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-3 mt-2" style="border-top: 2px dashed #ddd;">
                                <span class="fw-bold text-uppercase" style="color: #0d4a5e; font-size: 1.1rem;">Grand Total</span>
                                <span class="fw-bold" style="color: #0d4a5e; font-size: 1.5rem;">Rs. <span id="q_display_final_total"><?= number_format($totalAmount, 2, '.', ''); ?></span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="mb-5 px-2">
                    <label class="fw-bold text-uppercase mb-2" style="color: #0d4a5e;">Terms & Conditions</label>
                    <textarea class="form-control border bg-light shadow-none" rows="3" placeholder="Ex: Quotation is valid for 14 days from date. Delivery lead time 3-5 standard business days.">- Quotation is valid for 14 Days.
- Prices are subject to change without prior notice.
- Payment terms: 50% Advance, 50% on Delivery.</textarea>
                </div>

            <?php else: ?>
                <div class="text-center py-5 my-5 bg-light rounded border">
                    <i class="fas fa-box-open fs-1 text-muted mb-3"></i>
                    <h4 class="text-muted fw-bold">No Products Added Yet</h4>
                    <p class="text-secondary">Start typing in the search box above to add items to your quotation.</p>
                </div>
            <?php endif; ?>

        </div>
        
        <div class="card-footer bg-white border-0 py-4 px-4 text-end no-print" style="box-shadow: 0 -5px 10px rgba(0,0,0,0.02);">
            <button type="button" onclick="window.location.reload();" class="btn btn-secondary px-4 me-2 shadow-sm"><i class="fas fa-sync me-2"></i>Reset Quote</button>
            <button type="button" class="btn btn-primary px-5 shadow-sm fw-bold" id="downloadPdf" style="background: #0d4a5e; border-color: #0d4a5e;">
                <i class="fas fa-file-pdf me-2"></i> Save Quotation PDF
            </button>
        </div>
    </div>
</div>

<style>
/* PDF & Print Specific CSS */
@media print {
    .no-print { display: none !important; }
    .print-only { display: table-cell !important; }
    .card { border: none !important; box-shadow: none !important; }
    body { background-color: white !important; }
    #quotationArea { padding: 0 !important; }
    .table th { background-color: #f1f5f9 !important; color: #000 !important; print-color-adjust: exact; -webkit-print-color-adjust: exact; }
}

/* Base states for display */
.print-only { display: none !important; }

/* Clean UI styles */
.qtyBox .form-control[readonly] { background-color: white; }
.mySelect2 + .select2-container .select2-selection--single { height: 38px; padding: 4px; border: 1px solid #ced4da; }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    // Live Calculation Logic for Quotation Discount
    const subTotalEle = document.getElementById('q_sub_total');
    const discountInput = document.getElementById('q_input_discount');
    const printDiscountEle = document.getElementById('q_print_discount_val');
    const finalTotalEle = document.getElementById('q_display_final_total');

    function calculateQuotation() {
        if(!subTotalEle) return;
        
        const subTotal = parseFloat(subTotalEle.innerText) || 0;
        let discount = parseFloat(discountInput.value) || 0;

        // Limiter
        if (discount < 0) discount = 0;
        if (discount > 100) discount = 100;

        const discountAmount = (subTotal * discount) / 100;
        const finalTotal = subTotal - discountAmount;
        
        finalTotalEle.innerText = finalTotal.toFixed(2);
        
        // Sync to print label
        if(printDiscountEle) {
            printDiscountEle.innerText = discount + "%";
        }
    }

    if(discountInput) {
        discountInput.addEventListener('input', calculateQuotation);
    }

    // PDF Generation
    var btnDl = document.getElementById('downloadPdf');
    if(btnDl) {
        btnDl.addEventListener('click', function () {
            
            // Un-hide the print-only classes specifically for html2pdf 
            const printOnlyElements = document.querySelectorAll('.print-only');
            printOnlyElements.forEach(el => el.classList.remove('d-none'));

            // Pre-process customer details into text if they exist (to look clean)
            const cName = document.getElementById('q_customer_name').value;
            const cPhone = document.getElementById('q_customer_phone').value;
            
            const element = document.getElementById('quotationArea');
            
            const opt = {
                margin:       [5, 5, 5, 5], // Tighter margins to fit better
                filename:     'Quotation_' + (cName ? cName.replace(/\s+/g,'_') : 'DOC') + '.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { 
                    scale: 2, 
                    useCORS: true,
                    scrollY: 0, // IMPORTANT: Fixes blank space at the top by ignoring scroll position
                    windowWidth: 1000, // Forces the capture width to snap cleanly to A4 scale
                    letterRendering: true,
                },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            // Process saving
            html2pdf().set(opt).from(element).save().then(() => {
                // Return 'd-none' layout constraints back to UI
                printOnlyElements.forEach(el => el.classList.add('d-none'));
            });
        });
    }
</script>

<?php include('includes/footer.php'); ?>