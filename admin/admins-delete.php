<?php
require_once("../config/function.php");



checkPermission([1]); // Only Super Admin


$paraResultId = checkParamId('id');

if(is_numeric($paraResultId)){

    $adminId = validate($paraResultId);

    // Check if admin exists before deleting
    $admin = getById('admins', $adminId);

    if($admin['status'] == 200)
    {
        $adminDeleteRes = delete('admins', $adminId);
        if($adminDeleteRes)
        {
            redirect('admins.php', 'Admin Deleted Successfully');
        }
        else
        {
            redirect('admins.php', 'Something Went Wrong');
        }
    }
    else
    {
        redirect('admins.php', $admin['message']);
    }

}else{
    redirect('admins.php', 'Something Went Wrong');
}
?>