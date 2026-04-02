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
        redirect('quotation-create.php', 'Item Added Successfully!');
    } else {
        redirect('quotation-create.php', 'No such product found!');
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

    // Check if customer exists
    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone_number='$phone' LIMIT 1");
    
    if($checkCustomer && mysqli_num_rows($checkCustomer) > 0) {
        $customerData = mysqli_fetch_assoc($checkCustomer);


        // 1. Start a loop to find a unique number
$isUnique = false;
$trackingNo = "";

while (!$isUnique) {
    //we Generate a random number between 0 and 99999
    $randomNum = rand(0, 99999);
    
    // Format it to always be 5 digits (e.g., 00123 instead of 123)
    $potentialNo = str_pad($randomNum, 5, '0', STR_PAD_LEFT);
    $trackingNo = "TRK" . $potentialNo;

    // 2. Check the database if this tracking number already exists
    $checkQuery = "SELECT tracking_no FROM orders WHERE tracking_no = '$trackingNo' LIMIT 1";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        // No match found! The number is unique.
        $isUnique = true;
    }
    // If match is found, the loop runs again to generate a new number
}
        
        // 2. Calculate the NEXT Invoice ID
    // We check the AUTO_INCREMENT value from the database schema
    $query = "SELECT id FROM orders ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $nextId = $row['id'] + 1;
    } else {
        $nextId = 1; // First order ever
    }

    // Format: YYMMDD-ID (e.g., 260122-19)
    $finalInvoiceNo = date('ymd') . '-' . $nextId;
        
        // Save to session
        $_SESSION['invoice_no'] = $finalInvoiceNo; // We will generate the real one during Save
        $_SESSION['cphone'] = $phone;
        $_SESSION['payment_mode'] = $payment_mode;
        $_SESSION['customer_id'] = $customerData['id'];

        // Return JSON success
        echo json_encode(['status' => 200, 'message' => 'Success']);
        exit(); 
    } else {
        echo json_encode(['status' => 404, 'message' => 'Customer not found']);
        exit();
    }
}

//Save Order


if(isset($_POST['saveOrder']))
{
    // 1. Basic Validations
    if(!isset($_SESSION['productItems'])){
        echo json_encode(['status' => 404, 'message' => 'No items in order!']);
        exit;
    }

    $phone = validate($_SESSION['cphone']);
    $payment_mode = validate($_SESSION['payment_mode']);
    $order_placed_by_id = $_SESSION['loggedInUser']['user_id'];

    // 2. Calculate the NEXT Invoice ID
    // We check the AUTO_INCREMENT value from the database schema
    $query = "SELECT id FROM orders ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $nextId = $row['id'] + 1;
    } else {
        $nextId = 1; // First order ever
    }

    // Format: YYMMDD-ID (e.g., 260122-19)
    $finalInvoiceNo = date('ymd') . '-' . $nextId;

    // 3. Calculate Total Amount
    $totalAmount = 0;
    foreach($_SESSION['productItems'] as $item){
        $totalAmount += ($item['sale_price'] * $item['quantity']);
    }

    // 1. Start a loop to find a unique number
$isUnique = false;
$trackingNo = "";

while (!$isUnique) {
    //we Generate a random number between 0 and 99999
    $randomNum = rand(0, 99999);
    
    // Format it to always be 5 digits (e.g., 00123 instead of 123)
    $potentialNo = str_pad($randomNum, 5, '0', STR_PAD_LEFT);
    $trackingNo = "TRK" . $potentialNo;

    // 2. Check the database if this tracking number already exists
    $checkQuery = "SELECT tracking_no FROM orders WHERE tracking_no = '$trackingNo' LIMIT 1";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        // No match found! The number is unique.
        $isUnique = true;
    }
    // If match is found, the loop runs again to generate a new number
}

    // 4. Get Customer ID
    $customerRes = mysqli_query($conn, "SELECT id FROM customers WHERE phone_number='$phone' LIMIT 1");
    $custRow = mysqli_fetch_assoc($customerRes);
    $customerId = $custRow['id'];

    // 5. Insert Order
    $orderData = [
        'customer_id' => $customerId,
        'tracking_no' => $trackingNo,
        'invoice_no' => $finalInvoiceNo,
        'total_amount' => $totalAmount,
        'order_date' => date('Y-m-d H:i:s'),
        'order_status' => 'Booked',
        'payment_mode' => $payment_mode,
        'order_placed_by_id' => $order_placed_by_id
    ];
    
    $orderResult = insert('orders', $orderData);

    if($orderResult) {
        $lastOrderId = mysqli_insert_id($conn);

        // 6. Insert Order Items & Deduct Stock
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

            // Deduct from stock
            mysqli_query($conn, "UPDATE products SET quantity = quantity - $qty WHERE id = '$productId'");
        }

        // 7. In this part session Cleanup
        unset($_SESSION['productItems'], $_SESSION['cphone'], $_SESSION['payment_mode'], $_SESSION['invoice_no']);

        echo json_encode(['status' => 200, 'message' => 'Order saved! Invoice: ' . $finalInvoiceNo]);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Something went wrong.']);
    }
}



?>