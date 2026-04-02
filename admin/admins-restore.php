<?php
require_once("../config/function.php");

checkPermission([1]); // Only Super Admin

$paraResultId = checkParamId('id');

if(is_numeric($paraResultId ?? '')){

    $adminId = validate($paraResultId);
    
    // We use a custom query or a modified getById to find the deleted admin
    $adminRestoreRes = restore('admins', $adminId);
    
    if($adminRestoreRes) {
        redirect('admins-trash.php', 'Admin Restored Successfully');
    } else {
        redirect('admins-trash.php', 'Something Went Wrong');
    }

} else {
    redirect('admins-trash.php', 'Invalid Admin ID');
}
?>