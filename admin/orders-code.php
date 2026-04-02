<?php 
include('../config/function.php');

//for current date time
date_default_timezone_set("Asia/Colombo");

// Initialize session arrays if not set
if(!isset($_SESSION['productItems'])){
    $_SESSION['productItems'] = [];
}
if(!isset($_SESSION['productItemIds'])){
    $_SESSION['productItemIds'] = [];
}

// --- SECTION 1:  This is for create order form (Standard Form Submit) ---
if(isset($_POST['addItem'])) 
{
    $productId = validate($_POST['product_id']); 
    $quantity = validate($_POST['quantity']);

    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId' LIMIT 1");

    if($checkProduct && mysqli_num_rows($checkProduct) > 0)
    {
        $row = mysqli_fetch_assoc($checkProduct);
        
        if($row['quantity'] < $quantity) {
            redirect('order-create.php', 'Only ' . $row['quantity'] . ' quantity available!');
            exit(); 
        }

        $productData = [
            'product_id' => $row['id'],
            'prod_name'  => $row['prod_name'],
            'image'      => $row['image'],
            'sale_price' => $row['sale_price'],
            'quantity'   => $quantity,
        ];

        if(!in_array($row['id'], $_SESSION['productItemIds'])){
            array_push($_SESSION['productItemIds'], $row['id']);
            array_push($_SESSION['productItems'], $productData);
        } else {
            foreach($_SESSION['productItems'] as $key => $item){
                if($item['product_id'] == $row['id']){
                    $_SESSION['productItems'][$key]['quantity'] += $quantity;
                }
            }
        }
        redirect('order-create.php', 'Item Added Successfully!');
    } else {
        redirect('order-create.php', 'No such product found!');
    }
}

// --- SECTION 2: QUANTITY INC/DEC (AJAX) ---
if(isset($_POST['productIncDec']))
{
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $found = false;
    foreach($_SESSION['productItems'] as $key => $item) {
        if($item['product_id'] == $productId) {
            $_SESSION['productItems'][$key]['quantity'] = $quantity;
            $found = true;
            break;
        }
    }

    ob_clean(); // This is Clears any whitespace that could break JSON
    if($found){
        //jsonResponse(200, 'success', 'Quantity Updated');
                    // Find the line that looks like: jsonResponse(200, 'success', '...');
            // Replace it with this:

            echo json_encode([
                'status' => 200,
                'message' => 'Quantity Updated'
            ]);
            exit();
    }else{
        //jsonResponse(500, 'error', 'Something Went Wrong');
        // Replace this:
            // jsonResponse(200, 'success', 'Quantity Updated');

            // With this:
            echo json_encode([
                'status' => 200,
                'status_type' => 'success',
                'message' => 'Quantity Updated'
            ]);
            exit(); // Always exit after sending a JSON response in an AJAX call
    }
}


// --- SECTION 3: PROCEED TO PLACE ORDER (AJAX) ---
if(isset($_POST['proceedToPlace'])) {
    $phone = mysqli_real_escape_string($conn, $_POST['cphone']);
    $payment_mode = mysqli_real_escape_string($conn, $_POST['payment_mode']);
    
    $sub_total = mysqli_real_escape_string($conn, $_POST['sub_total'] ?? 0);
    $discount = mysqli_real_escape_string($conn, $_POST['discount'] ?? 0);
    $final_total = mysqli_real_escape_string($conn, $_POST['total_amount'] ?? 0);
    $cash_received = mysqli_real_escape_string($conn, $_POST['cash_received'] ?? 0);
    $balance = mysqli_real_escape_string($conn, $_POST['balance'] ?? 0);

    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone_number='$phone' LIMIT 1");
    
    if($checkCustomer && mysqli_num_rows($checkCustomer) > 0) {
        $customerData = mysqli_fetch_assoc($checkCustomer);

        $isUnique = false;
        $trackingNo = "";
        while (!$isUnique) {
            $randomNum = rand(0, 99999);
            $potentialNo = str_pad($randomNum, 5, '0', STR_PAD_LEFT);
            $trackingNo = "TRK" . $potentialNo;

            $checkQuery = "SELECT tracking_no FROM orders WHERE tracking_no = '$trackingNo' LIMIT 1";
            $checkResult = mysqli_query($conn, $checkQuery);
            if (mysqli_num_rows($checkResult) == 0) { $isUnique = true; }
        }
        
        // --- INVOICE GENERATION ---
        $storeCode = $_SESSION['loggedInUser']['store_code'] ?? 'GEN';
        // CORRECTED: Define store_id from the logged-in user session
        $storeId = $_SESSION['loggedInUser']['store_id'] ?? null; 

        $today = date('Y-m-d');
        $query = "SELECT COUNT(id) as total_today FROM orders WHERE DATE(order_date) = '$today'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $nextSequence = $row['total_today'] + 1;
        $paddedId = str_pad($nextSequence, 2, '0', STR_PAD_LEFT);
        $finalInvoiceNo = $storeCode . '-' . date('ymd') . '-' . $paddedId;
        
        // --- SAVE TO SESSION ---
        $_SESSION['invoice_no'] = $finalInvoiceNo;
        $_SESSION['cphone'] = $phone;
        $_SESSION['tracking_no'] = $trackingNo;
        $_SESSION['store_id'] = $storeId; // CORRECTED: Store the actual ID value
        $_SESSION['payment_mode'] = $payment_mode;
        $_SESSION['customer_id'] = $customerData['id'];
        
        $_SESSION['sub_total'] = $sub_total;
        $_SESSION['discount'] = $discount;
        $_SESSION['total_amount'] = $final_total;
        $_SESSION['cash_received'] = $cash_received;
        $_SESSION['balance'] = $balance;

        echo json_encode(['status' => 200, 'message' => 'Success']);
        exit(); 
    } else {
        echo json_encode(['status' => 404, 'message' => 'Customer not found']);
        exit();
    }
}

// --- SECTION 4: SAVE ORDER TO DATABASE ---
if(isset($_POST['saveOrder']))
{
    // 1. Check if product items exist
    if(!isset($_SESSION['productItems']) || empty($_SESSION['productItems'])){
        echo json_encode(['status' => 404, 'message' => 'No items in order!']);
        exit;
    }

    // 2. Retrieve data from Session (Set in Section 3)
    $customerId = $_SESSION['customer_id'] ?? null;
    $trackingNo = $_SESSION['tracking_no'] ?? null; // Use the one generated in Section 3
    $invoice_no = $_SESSION['invoice_no'] ?? null;
    $payment_mode = $_SESSION['payment_mode'] ?? 'Cash';
    $order_placed_by_id = $_SESSION['loggedInUser']['id'] ?? 0;
    $storeId = $_SESSION['store_id'] ?? ($_SESSION['loggedInUser']['store_id'] ?? null); 

    // 3. Fallback: If tracking number was somehow lost, generate it here
    if(!$trackingNo){
        $isUnique = false;
        while (!$isUnique) {
            $randomNum = rand(0, 99999);
            $trackingNo = "TRK" . str_pad($randomNum, 5, '0', STR_PAD_LEFT);
            $checkResult = mysqli_query($conn, "SELECT tracking_no FROM orders WHERE tracking_no = '$trackingNo' LIMIT 1");
            if (mysqli_num_rows($checkResult) == 0) { $isUnique = true; }
        }
    }

    // 4. Prepare Order Data
    $orderData = [
        'customer_id' => $customerId,
        'tracking_no' => $trackingNo,
        'invoice_no' => $invoice_no,
        'store_id' => $storeId, 
        'sub_total' => $_SESSION['sub_total'] ?? 0,
        'discount' => $_SESSION['discount'] ?? 0,
        'total_amount' => $_SESSION['total_amount'] ?? 0,
        'cash_received' => $_SESSION['cash_received'] ?? 0,
        'balance' => $_SESSION['balance'] ?? 0,
        'order_date' => date('Y-m-d H:i:s'),
        'order_status' => 'Booked',
        'payment_mode' => $payment_mode,
        'order_placed_by_id' => $order_placed_by_id
    ];
    
    // 5. Execute Insert
    $orderResult = insert('orders', $orderData);

    if($orderResult) {
        $lastOrderId = mysqli_insert_id($conn);

        foreach($_SESSION['productItems'] as $prodItem) {
            $productId = $prodItem['product_id'];
            $qty = $prodItem['quantity'];

            $itemData = [
                'order_id' => $lastOrderId,
                'product_id' => $productId,
                'price' => $prodItem['sale_price'],
                'quantity' => $qty
            ];
            insert('order_items', $itemData);

            // Update Stock
            mysqli_query($conn, "UPDATE products SET quantity = quantity - $qty WHERE id = '$productId'");
        }

        // 6. Cleanup session after successful save
        unset($_SESSION['productItems']);
        unset($_SESSION['productItemIds']);
        unset($_SESSION['cphone']);
        unset($_SESSION['payment_mode']);
        unset($_SESSION['invoice_no']);
        unset($_SESSION['tracking_no']);
        unset($_SESSION['customer_id']);
        unset($_SESSION['sub_total']);
        unset($_SESSION['discount']);
        unset($_SESSION['total_amount']);
        unset($_SESSION['cash_received']);
        unset($_SESSION['balance']);
        unset($_SESSION['store_id']);

        echo json_encode(['status' => 200, 'message' => 'Order saved successfully!']);
        exit();
    } else {
        echo json_encode(['status' => 500, 'message' => 'Database error: Could not save order.']);
        exit();
    }
}



?>