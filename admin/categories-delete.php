<?php
require_once("../config/function.php");

//for current date time
date_default_timezone_set("Asia/Colombo");

checkPermission([1, 2]);


$paraResult = checkParamId('id');

if(is_numeric($paraResult)){
    $categoryId = validate($paraResult);

    $category = getById('categories', $categoryId);
    if($category['status'] == 200)
    {
        $categoryDeleteRes = delete('categories', $categoryId);
        if($categoryDeleteRes){
            redirect('categories.php', 'Category Deleted Successfully');
        }else{
            redirect('categories.php', 'Something Went Wrong');
        }
    }
    else
    {
        redirect('categories.php', $category['message']);
    }
}else{
    redirect('categories.php', 'Something Went Wrong');
}
?>