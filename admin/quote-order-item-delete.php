

<?php 

require '../config/function.php';

 

checkPermission([1, 2, 3]); // Everyone can see the dashboard


$paramResult =checkParamId('index');
if(is_numeric($paramResult)){

    $indexValue = validate($paramResult);

    if(isset($_SESSION['productItems']) && isset($_SESSION['productItemIds'])){

        unset($_SESSION['productItems'][$indexValue]);
        unset($_SESSION['productItemIds'][$indexValue]);

        redirect('quotation-create.php','Item Removed');
    }else{

        redirect('quotation-create.php','There is no item');
    }

}else{

    redirect('quotation-create.php','param not numeric');
}


?>