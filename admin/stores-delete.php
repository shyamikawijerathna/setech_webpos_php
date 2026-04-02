<?php
require_once("../config/function.php");

//for current date time
date_default_timezone_set("Asia/Colombo");

checkPermission([1]); // Only Super Admin

$paraResultId = checkParamId('id');

// Using the null coalesce ?? '' to prevent the deprecated null parameter error
if(is_numeric($paraResultId ?? '')){

    $storeId = validate($paraResultId);
    $store = getById('stores', $storeId);

    if($store['status'] == 200) {
        // This now calls our updated "Soft Delete" function
        $storeDeleteRes = delete('stores', $storeId);
        
        if($storeDeleteRes) {
            redirect('stores.php', 'Store Removed Successfully');
        } else {
            redirect('stores.php', 'Something Went Wrong');
        }
    } else {
        redirect('stores.php', $store['message']);
    }

} else {
    redirect('stores.php', 'Invalid Store ID');
}
?>