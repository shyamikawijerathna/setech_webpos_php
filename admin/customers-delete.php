<?php
require_once("../config/function.php");

// 1. Get and validate the ID immediately
$paraResultId = checkParamId('id');

if (is_numeric($paraResultId)) {
    // 2. Sanitize the ID
    $customerId = validate($paraResultId);

    // 3. Check if the customer exists
    $customer = getById('customers', $customerId);

    if ($customer['status'] == 200) {
        // 4. Perform the deletion
        $customerDeleteRes = delete('customers', $customerId);

        if ($customerDeleteRes) {
            redirect('customers.php', 'Customer Deleted Successfully');
        } else {
            redirect('customers.php', 'Error: Could not delete customer.');
        }
    } else {
        // Handle case where customer ID doesn't exist in database
        
        redirect('customers.php',$customer['message']);
    }
} else {
    // Handle invalid or missing ID parameter
    redirect('customers.php', 'Invalid Customer ID');
}
?>