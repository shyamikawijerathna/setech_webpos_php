<?php
require_once("../config/function.php");

checkPermission([1]); // Only Super Admin

$paraResultId = checkParamId('id');

if(is_numeric($paraResultId ?? '')){

    $productId = validate($paraResultId);
    
    // We use a custom query or a modified getById to find the deleted store
    $productRestoreRes = restore('products', $productId);
    
    if($productRestoreRes) {
        redirect('products-trash.php', 'Store Restored Successfully');
    } else {
        redirect('products-trash.php', 'Something Went Wrong');
    }

} else {
    redirect('products-trash.php', 'Invalid Store ID');
}
?>