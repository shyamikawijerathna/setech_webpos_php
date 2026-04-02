<?php
require_once("../config/function.php");

checkPermission([1]); // Only Super Admin

$paraResultId = checkParamId('id');

if(is_numeric($paraResultId ?? '')){

    $storeId = validate($paraResultId);
    
    // We use a custom query or a modified getById to find the deleted store
    $storeRestoreRes = restore('stores', $storeId);
    
    if($storeRestoreRes) {
        redirect('stores-trash.php', 'Store Restored Successfully');
    } else {
        redirect('stores-trash.php', 'Something Went Wrong');
    }

} else {
    redirect('stores-trash.php', 'Invalid Store ID');
}
?>