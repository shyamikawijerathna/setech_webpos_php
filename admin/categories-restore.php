<?php
require_once("../config/function.php");

checkPermission([1]); // Only Super Admin

$paraResultId = checkParamId('id');

if(is_numeric($paraResultId ?? '')){

    $categoryId = validate($paraResultId);
    
    // We use a custom query or a modified getById to find the deleted category
    $categoryRestoreRes = restore('categories', $categoryId);
    
    if($categoryRestoreRes) {
        redirect('categories-trash.php', 'Category Restored Successfully');
    } else {
        redirect('categories-trash.php', 'Something Went Wrong');
    }

} else {
    redirect('categories-trash.php', 'Invalid Category ID');
}
?>