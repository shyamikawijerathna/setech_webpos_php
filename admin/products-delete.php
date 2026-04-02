<?php
require_once("../config/function.php");

//for current date time
date_default_timezone_set("Asia/Colombo");



checkPermission([1, 2]); // Everyone can see the dashboard


$paraResult = checkParamId('id');

if(is_numeric($paraResult)){
    $productId = validate($paraResult);

    $product = getById('products', $productId);

    if($product['status'] == 200)
    {
        // --- IMAGE DELETION LOGIC ---
        $productData = $product['data'];
        $imagePath = "../" . $productData['image'];

        // Check if file exists and is not empty, then delete it
        if(!empty($productData['image']) && file_exists($imagePath)){
            unlink($imagePath);
        }

        // --- DATABASE DELETION ---
        $productDeleteRes = delete('products', $productId);

        if($productDeleteRes){
            redirect('products.php', 'Product Deleted Successfully');
        }else{
            redirect('products.php', 'Something Went Wrong while deleting the record');
        }
    }
    else
    {
        redirect('products.php', $product['message']);
    }
}else{
    redirect('products.php', 'Invalid Product ID');
}
?>