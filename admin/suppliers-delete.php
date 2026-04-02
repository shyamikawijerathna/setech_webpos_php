<?php
require_once("../config/function.php");




checkPermission([1, 2]); // admin,inventory staff can see the dashboard


// 1. Get and validate the ID immediately
$paraResultId = checkParamId('id');

if (is_numeric($paraResultId)) {
    // 2. validate the ID
    $supplierId = validate($paraResultId);

    // 3. Check if the customer exists
    $supplier = getById('suppliers', $supplierId);

    if ($supplier['status'] == 200) {
        // 4. Perform the deletion
        $supplierDeleteRes = delete('suppliers', $supplierId);

        if ($supplierDeleteRes) {
            redirect('suppliers.php', 'Supplier Deleted Successfully');
        } else {
            redirect('suppliers.php', 'Error: Could not delete supplier.');
        }
    } else {
        // Handle case where customer ID doesn't exist in database
        
        redirect('suppliers.php',$supplier['message']);
    }
} else {
    // Handle invalid or missing ID parameter
    redirect('suppliers.php', 'Invalid Supplier ID');
}
?>