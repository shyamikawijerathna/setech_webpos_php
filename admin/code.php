<?php
// 1. Force errors to show to stop the "White Screen"
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../config/function.php");

// --- 1. CREATE ADMIN LOGIC ---
if (isset($_POST['saveAdmin'])) {
    $name     = validate($_POST['name'] ?? '');
    $storeId  = validate($_POST['store_id'] ?? '');
    $adminLevel = validate($_POST['role_level'] ?? '');
    $email    = validate($_POST['email'] ?? '');
    $password = validate($_POST['password'] ?? '');
    $phone    = validate($_POST['phone'] ?? '');

    if ($name != '' && $email !='' && $password != '') {
        $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");
        if (mysqli_num_rows($emailCheck) > 0) {
            redirect('admins-create.php', 'Email already used by another user.');
        }

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);
        $data = [
            'name'     => $name,
            'store_id' => $storeId,
            'role_level' => $adminLevel,
            'email'    => $email,
            'password' => $bcrypt_password,
            'phone'    => $phone,
        ];

        $result = insert('admins', $data);
        if($result){
            redirect('admins.php', 'Admin created successfully');
        } else {
            redirect('admins-create.php', 'Something went wrong');
        }
    } else {
        redirect('admins-create.php', 'Please fill required fields');
    }
} 

// --- 2. UPDATE ADMIN LOGIC ---
if (isset($_POST['updateAdmin'])) {
    $adminId = validate($_POST['adminId']);
    $adminData = getById('admins', $adminId);

    if($adminData['status'] != 200){
        redirect('admins.php', 'Admin ID not found');
    }

    $name  = validate($_POST['name']);
    $storeId  = validate($_POST['store_id'] ?? '');
    $adminLevel = validate($_POST['role_level'] ?? '');
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $password = validate($_POST['password']);
    
    if($password != ''){
        $finalPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $finalPassword = $adminData['data']['password'];
    }

    $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email' AND id != '$adminId'");
    if(mysqli_num_rows($emailCheck) > 0){
        redirect('admins-edit.php?id='.$adminId, 'Email already used by another admin');
    }

    $data = [
        'name'     => $name,
        'store_id' => $storeId,
        'role_level' => $adminLevel,
        'email'    => $email,
        'password' => $finalPassword,
        'phone'    => $phone,
    ];

    $result = update('admins', $adminId, $data);
    if($result){
        redirect('admins.php', 'Admin updated successfully');
    } else {
        redirect('admins-edit.php?id='.$adminId, 'Something went wrong');
    }
}

// --- 1. CREATE stores LOGIC ---
if (isset($_POST['saveStore'])) {
    $name     = validate($_POST['store_name'] ?? '');
    $code     = validate($_POST['store_code'] ?? '');
    $address  = validate($_POST['store_address'] ?? '');
    $contact  = validate($_POST['store_contact'] ?? '');
        
    if ($name != '' && $code != '' && $address !='' ) {
        $nameCheck = mysqli_query($conn, "SELECT * FROM stores WHERE store_name='$name'");
        if (mysqli_num_rows($nameCheck) > 0) {
            redirect('stores-create.php', 'Store name already exists.');
        }

        $codeCheck = mysqli_query($conn, "SELECT * FROM stores WHERE store_code='$code'");
        if (mysqli_num_rows($codeCheck) > 0) {
            redirect('stores-create.php', 'Store code already exists.');
        }

        $data = [
            'store_name'     => $name,
            'store_code'     => $code,
            'store_address'  => $address,
            'store_contact'  => $contact,
            
        ];

        $result = insert('stores', $data);
        if($result){
            redirect('stores.php', 'Store created successfully');
        } else {
            redirect('stores-create.php', 'Something went wrong');
        }
    } else {
        redirect('stores-create.php', 'Please fill required fields');
    }
} 

// --- 2. UPDATE stores LOGIC ---
if (isset($_POST['updateStore'])) {
    $storeId = validate($_POST['storeId']);
    $code = validate($_POST['store_code']);
    $contact = validate($_POST['store_contact']);
    $address = validate($_POST['store_address']);
    $storeData = getById('stores', $storeId);

    if($storeData['status'] != 200){
        redirect('stores.php', 'Store ID not found');
    }

    $name  = validate($_POST['store_name']);
    $code  = validate($_POST['store_code']);
    $address  = validate($_POST['store_address']);
    $contact  = validate($_POST['store_contact']);

        $nameCheck = mysqli_query($conn, "SELECT * FROM stores WHERE store_name='$name' AND id != '$storeId'");

    
    if(mysqli_num_rows($nameCheck) > 0){
        redirect('stores-edit.php?id='.$storeId, 'Store name already exists');
    }

    $data = [
        'store_name'     => $name,
        'store_code'     => $code,
        'store_address'  => $address,
        'store_contact'  => $contact,
    ];

    $result = update('stores', $storeId, $data);
    if($result){
        redirect('stores.php', 'Store updated successfully');
    } else {
        redirect('stores-edit.php?id='.$storeId, 'Something went wrong');
    }
}


// --- 3. CREATE CATEGORY LOGIC ---
if (isset($_POST['saveCategory'])) {
    $cat_name     = validate($_POST['cat_name'] ?? '');
    $sub_category = validate($_POST['sub_category'] ?? '');
    $description  = validate($_POST['description'] ?? '');
    
    // Checkbox logic: 1 if checked, 0 if not
    $status = isset($_POST['status']) ? 1 : 0;

    if ($cat_name != '') {
        $catCheck = mysqli_query($conn, "SELECT * FROM categories WHERE cat_name='$cat_name' LIMIT 1");
        if (mysqli_num_rows($catCheck) > 0) {
            redirect('categories-create.php', 'Category name already exists.');
        }

        $data = [
            'cat_name'     => $cat_name,
            'sub_category' => $sub_category,
            'description'  => $description,
            'status'       => $status,
        ];

        $result = insert('categories', $data);
        if($result){
            redirect('categories.php', 'Category created successfully');
        } else {
            redirect('categories-create.php', 'Something went wrong while saving category');
        }
    } else {
        redirect('categories-create.php', 'Category name is required');
    }
}

// --- 4. update CATEGORY LOGIC ---

if (isset($_POST['updateCategory'])) {
    $categoryId = validate($_POST['categoryId']);
    
    $cat_name     = validate($_POST['cat_name']);
    $sub_category = validate($_POST['sub_category']);
    $description  = validate($_POST['description']);
    $status       = isset($_POST['status']) ? 1 : 0;

    $data = [
        'cat_name'     => $cat_name,
        'sub_category' => $sub_category,
        'description'  => $description,
        'status'       => $status,
    ];

    $result = update('categories', $categoryId, $data);

    if($result){
        redirect('categories.php', 'Category updated successfully');
    } else {
        redirect('categories-edit.php?id='.$categoryId, 'Something went wrong');
    }
}

// --- 4 Add product LOGIC ---

if(isset($_POST['saveProduct']))
{
    // 1. Capture and Validate Basic Inputs
    $categoryId  = validate($_POST['category_id']);
    $categoryName = validate($_POST['cat_name']); // Captured from the hidden input
    $prod_name   = validate($_POST['prod_name']);
    $description = validate($_POST['description']);
    $buy_price   = validate($_POST['buy_price']);
    $quantity    = validate($_POST['quantity']);
    $sale_price  = validate($_POST['sale_price']);
    $store_location = validate($_POST['store_location']);
    
    // Checkbox logic: '1' for visible, '0' for hidden
    $status = isset($_POST['status']) ? '1' : '0';

    // 2. Barcode Logic
    $barcode = validate($_POST['barcode']); 
    if(empty($barcode)){
        // Generates a random 10-digit unique number if left blank
        $barcode = mt_rand(1000000000, 9999999999); 
    }

    // 3. Image Upload Logic
    $finalImage = ""; 
    if($_FILES['image']['size'] > 0)
    {
        $path = "../assets/uploads/products/";
        
        // Create directory if it doesn't exist
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename  = time().'.'.$image_ext;

        $moveResult = move_uploaded_file($_FILES['image']['tmp_name'], $path.$filename);
        if($moveResult){
            // This path is what will be saved in the database
            $finalImage = "assets/uploads/products/".$filename;
        }
    }

    // 4. Prepare Data for Insertion
    // Ensure these keys match your table column names EXACTLY
    $data = [
        'category_id'    => $categoryId,
        'cat_name'       => $categoryName, // Saving the category name string
        'prod_name'      => $prod_name,
        'description'    => $description,
        'buy_price'      => $buy_price,
        'quantity'       => $quantity,
        'sale_price'     => $sale_price,
        'store_location' => $store_location,
        'barcode'        => $barcode,
        'image'          => $finalImage,
        'status'         => $status,
    ];

    // 5. Execute Insert
    $result = insert('products', $data);

    if($result){
        redirect('products.php', 'Product Created Successfully!');
    } else {
        redirect('products-create.php', 'Something Went Wrong. Please try again.');
    }
}

// Update product Logic
if(isset($_POST['updateProduct']))
{
    $product_id = validate($_POST['product_id']);
    
    // Fetch current product data to get the old image path
    $productData = getById('products', $product_id);
    if($productData['status'] != 200) {
        redirect('products.php', 'Product not found');
    }

    $categoryId = validate($_POST['category_id']);
    $prod_name = validate($_POST['prod_name']);
    $description = validate($_POST['description']);
    $buy_price = validate($_POST['buy_price']);
    $sale_price = validate($_POST['sale_price']);
    $quantity = validate($_POST['quantity']);
    $store_location = validate($_POST['store_location']);
    $barcode = validate($_POST['barcode']);
    $status = isset($_POST['status']) ? '1' : '0';

    // --- FETCH CATEGORY NAME (Consistency Fix) ---
    // Fetch the cat_name string based on the selected category_id
    $categoryQuery = mysqli_query($conn, "SELECT cat_name FROM categories WHERE id='$categoryId' LIMIT 1");
    if($categoryQuery && mysqli_num_rows($categoryQuery) > 0){
        $catRow = mysqli_fetch_assoc($categoryQuery);
        $categoryName = $catRow['cat_name'];
    } else {
        $categoryName = ""; // Fallback
    }

    // --- IMAGE UPDATE LOGIC ---
    $old_image = $productData['data']['image'];
    $finalImage = $old_image; // Default to existing image path

    if($_FILES['image']['size'] > 0)
    {
        $path = "../assets/uploads/products/";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename  = time().'.'.$image_ext;

        $moveResult = move_uploaded_file($_FILES['image']['tmp_name'], $path.$filename);
        
        if($moveResult) {
            $finalImage = "assets/uploads/products/".$filename;
            
            // Delete the old image file from server to save space
            if(!empty($old_image) && file_exists("../".$old_image)) {
                unlink("../".$old_image);
            }
        }
    }

    // --- DATA ARRAY ---
    $data = [
        'category_id'    => $categoryId,
        'cat_name'       => $categoryName, // Added to update cat_name column
        'barcode'        => $barcode,
        'prod_name'      => $prod_name,
        'description'    => $description,
        'buy_price'      => $buy_price,
        'quantity'       => $quantity,
        'sale_price'     => $sale_price,
        'store_location' => $store_location,
        'image'          => $finalImage,
        'status'         => $status,
    ];

    // Using update function: update('table_name', $id, $data_array)
    $result = update('products', $product_id, $data);

    if($result){
        redirect('products.php', 'Product updated successfully');
    } else {
        redirect('product-edit.php?id='.$product_id, 'Something went wrong!');
    }
}

// --- 1. CREATE customer LOGIC ---
if (isset($_POST['saveCustomer'])) {
    $cust_name     = validate($_POST['cust_name'] ?? '');
    $phone_number    = validate($_POST['phone_number'] ?? '');
    $cust_email = validate($_POST['cust_email'] ?? '');
    $home_town    = validate($_POST['home_town'] ?? '');

    if ($cust_name != '' && $cust_email !='') {
        $emailCheck = mysqli_query($conn, "SELECT * FROM customers WHERE cust_email='$cust_email'");
        if (mysqli_num_rows($emailCheck) > 0) {
            redirect('customers-create.php', 'Email already used by another user.');
        }

        $data = [
            'cust_name'     => $cust_name,
            'phone_number'    => $phone_number,
            'cust_email' => $cust_email,
            'home_town'    => $home_town,
        ];

        $result = insert('customers', $data);
        if($result){
            redirect('customers.php', 'customer created successfully');
        } else {
            redirect('customers-create.php', 'Something went wrong');
        }
    } else {
        redirect('customers-create.php', 'Please fill required fields');
    }
} 


require_once("../config/function.php");

// Handle Add Customer
if(isset($_POST['saveCustomer']))
{
    $name = validate($_POST['cust_name']);
    $phone = validate($_POST['phone_number']);
    $email = validate($_POST['cust_email']);
    $home_town = validate($_POST['home_town']);

    if($name != '' && $phone != '')
    {
        $data = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'home_town' => $home_town
        ];
        $result = insert('customers', $data);

        if($result){
            redirect('customers.php', 'Customer Created Successfully');
        }else{
            redirect('customers-create.php', 'Something Went Wrong');
        }
    }
    else
    {
        redirect('customers-create.php', 'Please fill required fields');
    }
}

// Customer update logic
if(isset($_POST['updateCustomer']))
{
    $customerId = validate($_POST['customerId']);
    
    $name = validate($_POST['cust_name']);
    $phone = validate($_POST['phone_number']);
    $email = validate($_POST['cust_email']);
    $home_town = validate($_POST['home_town']);

    if($name != '' && $phone != '')
    {
        $data = [
            'cust_name' => $name,
            'phone_number' => $phone,
            'cust_email' => $email,
            'home_town' => $home_town
        ];
        $result = update('customers', $customerId, $data);

        if($result){
            redirect('customers.php', 'Customer Updated Successfully');
        }else{
            redirect('customers-edit.php?id='.$customerId, 'Something Went Wrong');
        }
    }
    else
    {
        redirect('customers-edit.php?id='.$customerId, 'Please fill required fields');
    }
}

// Handle Add supplier
if(isset($_POST['saveSupplier']))
{
    $name = validate($_POST['supp_name']);
    $item = validate($_POST['item']);
    $phone = validate($_POST['phone_number']);
    $email = validate($_POST['supp_email']);
    $address = validate($_POST['address']);

    if($name != '' && $phone != '')
    {
        $data = [
            'supp_name' => $name,
            'item' => $item,
            'phone_number' => $phone,
            'supp_email' => $email,
            'address' => $address
        ];
        $result = insert('suppliers', $data);

        if($result){
            redirect('suppliers.php', 'supplier Created Successfully');
        }else{
            redirect('suppliers-create.php', 'Something Went Wrong');
        }
    }
    else
    {
        redirect('suppliers-create.php', 'Please fill required fields');
    }
}

// Supplier update logic
if(isset($_POST['updateSupplier']))
{
    $supplierId = validate($_POST['supplierId']);
    
    $name = validate($_POST['supp_name']);
    $item = validate($_POST['item']);
    $phone = validate($_POST['phone_number']);
    $email = validate($_POST['supp_email']);
    $address = validate($_POST['address']);

    if($name != '' && $phone != '')
    {
        $data = [
            'supp_name' => $name,
            'item' => $item,
            'phone_number' => $phone,
            'supp_email' => $email,
            'address' => $address
        ];
        $result = update('suppliers', $supplierId, $data);

        if($result){
            redirect('suppliers.php', 'Supplier Updated Successfully');
        }else{
            redirect('suppliers-edit.php?id='.$supplierId, 'Something Went Wrong');
        }
    }
    else
    {
        redirect('suppliers-edit.php?id='.$supplierId, 'Please fill required fields');
    }
}

// low stock alert functionality

if(isset($_POST['save_threshold'])) {
    $limit = mysqli_real_escape_string($conn, $_POST['low_stock_limit']);
    
    // Save to session so it remembers during this login
    $_SESSION['low_stock_limit'] = $limit;
    
    // OR Save to Database (Best practice)
    // mysqli_query($conn, "UPDATE settings SET value='$limit' WHERE name='low_stock_limit'");
    
    $_SESSION['status'] = "Threshold updated to $limit";
    header("Location: index.php"); // Redirect back
    exit();
}


// Add multiple products via CSV upload with images
if(isset($_POST['bulk_import_btn'])) 
{
    // Check if CSV is actually uploaded
    if (empty($_FILES['import_file']['tmp_name'])) {
        redirect('bulk-upload.php', 'Please upload a CSV file.');
        exit(); // Always exit after a redirect
    }

    $csv_file = $_FILES['import_file']['tmp_name'];
    $file_ext = pathinfo($_FILES['import_file']['name'], PATHINFO_EXTENSION);
    
    if (strtolower($file_ext) !== 'csv') {
        redirect('bulk-upload.php', 'Invalid file format. Only CSV files are allowed.');
        exit();
    }

    // 1. Handle Bulk Image Uploads
    if(isset($_FILES['prod_images']['name'][0]) && !empty($_FILES['prod_images']['name'][0])) {
        $path = "../assets/uploads/products/";
        if (!is_dir($path)) { mkdir($path, 0777, true); }

        foreach($_FILES['prod_images']['tmp_name'] as $key => $tmp_name) {
            if(!empty($tmp_name)) {
                $filename = $_FILES['prod_images']['name'][$key];
                move_uploaded_file($tmp_name, $path.$filename);
            }
        }
    }

    // 2. Handle CSV Data
    ini_set('auto_detect_line_endings', TRUE);
    if(($handle = fopen($csv_file, "r")) !== FALSE) {
        fgetcsv($handle); // Skip header row

        $successCount = 0;
        while(($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            
            // SKIP EMPTY ROWS: If the row is empty or doesn't have at least the first few columns
            if (empty($row) || !isset($row[0])) {
                continue;
            }

            // SAFETY: Use Null Coalescing (??) to prevent "Undefined array key" warnings
            $cat_id         = validate($row[0] ?? '');
            $prod_name      = validate($row[1] ?? '');
            $description    = validate($row[2] ?? '');
            $buy_price      = validate($row[3] ?? '0');
            $quantity       = validate($row[4] ?? '0');
            $sale_price     = validate($row[5] ?? '0');
            $store_location = validate($row[6] ?? '');
            $imageName      = trim($row[7] ?? '');

            // Skip row if product name is empty (basic validation)
            if(empty($prod_name)) { continue; }

            $barcode = mt_rand(1000000000, 9999999999); 
            $dbImagePath = !empty($imageName) ? "assets/uploads/products/".$imageName : "";

            // Dynamically fetch Category Name
            $cat_name_final = "Bulk Import";
            if (!empty($cat_id)) {
                $categoryQuery = mysqli_query($conn, "SELECT cat_name FROM categories WHERE id='$cat_id' LIMIT 1");
                if($categoryQuery && mysqli_num_rows($categoryQuery) > 0){
                    $catRow = mysqli_fetch_assoc($categoryQuery);
                    $cat_name_final = validate($catRow['cat_name']);
                }
            }

            // Prepare Data Array
            $data = [
                'category_id'    => $cat_id,
                'cat_name'       => $cat_name_final,
                'prod_name'      => $prod_name,
                'description'    => $description,
                'buy_price'      => $buy_price,
                'quantity'       => $quantity,
                'sale_price'     => $sale_price,
                'store_location' => $store_location,
                'barcode'        => $barcode,
                'image'          => $dbImagePath,
                'status'         => '1'
            ];

            $result = insert('products', $data);
            if($result) { 
                $successCount++; 
            } else {
                $errorMsg = mysqli_error($conn);
                redirect('products.php', "Error on row: " . $errorMsg);
                exit();
            }
        }
        fclose($handle);
        redirect('products.php', "$successCount Products Imported Successfully!");
    } else {
        redirect('bulk-upload.php', 'Could not open CSV file.');
    }
}

?>