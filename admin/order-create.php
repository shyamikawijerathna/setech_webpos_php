<?php include('includes/header1.php'); ?>

<?php 

checkPermission([1, 2, 3]); // Everyone can see the dashboard
?>

<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Customer</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Enter Customer Name</label>
                    <input type="text" class="form-control" id="c_name" />
                </div>
                <div class="mb-3">
                    <label>Enter Customer Phone Number</label>
                    <input type="text" class="form-control" id="c_phone" />
                </div>
                <div class="mb-3">
                    <label>Enter Customer Email (optional)</label>
                    <input type="text" class="form-control" id="c_email" />
                </div>
                <div class="mb-3">
                    <label>Enter Customer Home Town (optional)</label>
                    <input type="text" class="form-control" id="c_town" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary saveCustomer">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid ps-3 " style="background: linear-gradient(135deg, #0d4a5e 0%, #5dcaee 100%)">
    <div class="card shadow-sm" style="background: linear-gradient(135deg, #0d4a5e 0%, #5dcaee 100%)">
        <div class="card-header border-0" style="background: transparent;">
            <h4 class="mb-0 text-white">POINT OF SALES</h4>
        </div>
    </div>
</div>

<div class="container-fluid mt-3 ps-3 ">
    <div class="row">
        
        <div class="col-md-9" style="background: linear-gradient(135deg, #0d4a5e 0%, #156680 100%)">
            
            <div class="card mb-4 shadow-sm" style="background: linear-gradient(135deg, #09556e 0%, #61cdf1 100%)">
                <div class="card-header" style="background: linear-gradient(135deg, #0d4a5e 0%, #156680 100%)">
                    <h4 class="mb-0 text-white">Create Order
                        <a href="orders.php" class="btn btn-warning float-end">Back to DashBoard</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php alertMessage(); ?>
                    <form action="orders-code.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-white">Select Product or Scan Product</label>
                                <select name="product_id" class="form-select mySelect2">
                                    <option value="">-- Select Product --</option>
                                    <?php
                                    $products = mysqli_query($conn, "SELECT * FROM products");
                                    if(mysqli_num_rows($products) > 0){
                                        foreach($products as $prodItem){
                                            echo '<option value="'.$prodItem['id'].'">'.$prodItem['prod_name'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="text-white">Quantity</label>
                                <input type="number" name="quantity" value="1" min="1" class="form-control" />
                            </div>
                            <div class="col-md-3 mb-3">
                                <br/>
                                <button type="submit" name="addItem" class="btn btn-primary w-100">Add Item</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

           
            
            <div class="card shadow-sm" style="background: linear-gradient(135deg, #0d4a5e 0%, #5dcaee 100%)">
                <div class="card-header" style="background: linear-gradient(135deg, #0d4a5e 0%, #156680 100%)">
                    <h4 class="mb-0 text-white">Cart Items</h4>
                </div>
                <div class="card-body" id="productArea">
                    <?php if(isset($_SESSION['productItems']) && count($_SESSION['productItems']) > 0): ?>
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered table-striped" style="background: linear-gradient(135deg, #b6dae5 0%, #5dcaee 100%)">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
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
                                        <td><?= $key + 1; ?></td>
                                        <td><?= $item['prod_name']; ?></td>
                                        <td><?= number_format($price, 2); ?></td>
                                        <td>
                                            <div class="input-group qtyBox" style="width: 110px;">
                                                <input type="hidden" class="prod_id" value="<?= $item['product_id']; ?>">
                                                
                                                <button type="button" class="input-group-text decrement text-white" 
                                                        style="background: #137fa3; border-color: #0d4a5e;">-</button>
                                                
                                                <input type="text" value="<?= $item['quantity']; ?>" 
                                                    class="form-control qty text-center text-white" 
                                                    style="background: #056286; border-color: #0d4a5e;" readonly />
                                                
                                                <button type="button" class="input-group-text increment text-white" 
                                                        style="background: #218db1; border-color: #0d4a5e;">+</button>
                                            </div>
                                        </td>
                                        <td><?= number_format($lineTotal, 2); ?></td>
                                        <td>
                                            <a href="order-item-delete.php?index=<?= $key; ?>" class="btn btn-danger btn-sm">Remove</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3"> 
                            <hr>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 shadow-sm text-white" style="background-color: #0b972eff; border-radius: 15px; border-left: 8px solid #0c5c21ff;">
                                        <label class="mb-2 fw-bold">Payment Mode</label>
                                        <select id="payment_mode" class="form-select border-0 shadow-sm">
                                            <option value="" selected disabled>-- Select --</option>
                                            <option value="Cash Payment" class="text-dark">Cash Payment</option>
                                            <option value="Online Payment" class="text-dark">Online Payment</option>
                                        </select>
                                        
                                    </div>
                                        </br>
                                    <div class="col-md- mb-3">
                                    <label class="fw-bold">Customer Phone</label>
                                    <input type="number" id="cphone" class="form-control" placeholder="Ex: 0771234567" />  
                                    </div>
                                </div>
                                
                             <div class="col-md-8 mb-3">
                                        <div class="p-3 shadow-sm border" style="background-color: #66d9e9ff; border-radius: 12px;">
                                            
                                            <div class="p-3 bg-dark text-white shadow-sm" style="border-radius: 12px;">
    
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="small text-uppercase text-secondary">Sub-Total :</span>
                                                    <h5 class="mb-0 fw-bold" style="color: #ffffff;">
                                                        Rs.<span id="sub_total"><?= number_format($totalAmount, 2, '.', ''); ?></span>
                                                    </h5>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="small text-uppercase">Discount % :</span>
                                                    <input type="number" id="input_discount" class="text-end fw-bold" 
                                                        style="background: transparent; border: none; color: #ffc107; font-size: 1.2rem; outline: none; width: 30%;" 
                                                        value="0" min="0" max="100">
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <span class="small text-uppercase">Total to Pay :</span>
                                                    <h4 class="mb-0 fw-bold" style="color: #ffc107;">
                                                        Rs.<span id="display_final_total"><?= number_format($totalAmount, 2, '.', ''); ?></span>
                                                    </h4>
                                                </div>

                                                <hr style="border-color: #444;">

                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="small text-uppercase">Cash Received :</span>
                                                    <input type="number" id="input_cash" class="text-end fw-bold" 
                                                        style="background: transparent; border: none; color: #ffc107; font-size: 1.5rem; outline: none; width: 50%;" 
                                                        placeholder="0.00">
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="small text-uppercase">Balance :</span>
                                                    <h4 class="mb-0 fw-bold" style="color: #ffc107;">
                                                        Rs.<span id="display_balance">0.00</span>
                                                    </h4>
                                                </div>
                                            </div>
                                       
                                        </br>

                                        <button type="button" class="btn btn-warning w-100 fw-bold proceedToPlace">
                                            PROCEED
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="text-center py-5">
                            <h5>No items added to cart</h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <!-- end of col-md-8 and start function buttons and num pad-->    

        </div> 
        <div class="col-md-3">
            <div class="card shadow-sm p-3" style="background: #f1f1f1; border-radius: 15px;">
                <div class="sidebar">
                    <div class="action-grid">
                        <button class="btn-blue"><i class="fa fa-reply"></i> RETURN</button>
                        <button class="btn-blue"><i class="fa fa-exchange-alt"></i> EXCHANGE</button>
                        <button class="btn-blue"><i class="fa fa-tag"></i> PRICE INQUIRY</button>
                        <button class="btn-blue"><i class="fa fa-truck"></i> HOME DELIVERY</button>
                        <button class="btn-blue"><i class="fa fa-user"></i> LOYALTY ID</button>
                        <button class="btn-blue"><i class="fa fa-sync"></i> LOYALTY UPDATE</button>
                        <button class="btn-blue btn-void text-white"><i class="fa fa-shopping-bag"></i> VOID</button>
                        <button class="btn-blue" style="background: #28a745;"><i class="fa fa-percent"></i> TOTAL</button>
                    </div>

                    <div class="numpad">
                        <button onclick="numPress(7)">7</button>
                        <button onclick="numPress(8)">8</button>
                        <button onclick="numPress(9)">9</button>
                        <button onclick="numPress(4)">4</button>
                        <button onclick="numPress(5)">5</button>
                        <button onclick="numPress(6)">6</button>
                        <button onclick="numPress(1)">1</button>
                        <button onclick="numPress(2)">2</button>
                        <button onclick="numPress(3)">3</button>
                        <button onclick="numPress('.')">.</button>
                        <button onclick="numPress(0)">0</button>
                        <button onclick="numPress('00')">00</button>
                    </div>
                </div>
            </div>
        </div> </div> </div>
        
        
<script>
    // Variable to track which input field was last clicked
    let focusedInput = null;

    // Listen to the document to see which input is currently active
    document.addEventListener('focusin', function(e) {
        // Only track inputs that are not read-only
        if (e.target.tagName === 'INPUT' && !e.target.readOnly) {
            focusedInput = e.target;
        }
    });

    function numPress(val) {
        if (focusedInput) {
            // Append the number string to the current input value
            focusedInput.value = focusedInput.value + val;
            
            // Trigger the 'input' event so calculations (like calculatePOS) instantly fire
            focusedInput.dispatchEvent(new Event('input'));
            
            // Refocus so the user doesn't lose their cursor
            focusedInput.focus();
        } else {
            // Optional: alert or visual hint if they haven't clicked an input yet
            console.log("Please click an input field first!");
        }
    }

// balance calculation in order create


    const subTotalEle = document.getElementById('sub_total');
    const discountInput = document.getElementById('input_discount');
    const finalTotalEle = document.getElementById('display_final_total');
    const cashInput = document.getElementById('input_cash');
    const balanceEle = document.getElementById('display_balance');

    function calculatePOS() {
        const subTotal = parseFloat(subTotalEle.innerText) || 0;
        let discount = parseFloat(discountInput.value) || 0;

        // Ensure discount stays between 0 and 100
        if (discount < 0) discount = 0;
        if (discount > 100) discount = 100;

        // 1. Calculate New Total
        const discountAmount = (subTotal * discount) / 100;
        const finalTotal = subTotal - discountAmount;
        finalTotalEle.innerText = finalTotal.toFixed(2);

        // 2. Calculate Balance
        const cashReceived = parseFloat(cashInput.value) || 0;
        const balance = cashReceived - finalTotal;
        balanceEle.innerText = balance.toFixed(2);

        // Visual feedback for balance
        balanceEle.style.color = (balance < 0) ? "#ff4d4d" : "#ffc107";
    }

    // Listen for changes in both Discount and Cash input
    discountInput.addEventListener('input', calculatePOS);
    cashInput.addEventListener('input', calculatePOS);

</script>
    </div>
     
</div> 


<?php include('includes/footer.php'); ?>