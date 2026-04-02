<?php include("includes/header.php"); ?>

<?php 

checkPermission([1, 2, 3]); // Everyone can see the dashboard
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Customer Edit
                <a href="customers.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?> 
            
            <form action="code.php" method="POST"> 
                <?php
                $paramValue = checkParamId('id');
                if(!is_numeric($paramValue)){
                    echo '<h5>'.$paramValue.'</h5>';
                    return false;
                }

                $customer = getById('customers', $paramValue);
                if($customer['status'] == 200)
                {
                    ?>
                    <input type="hidden" name="customerId" value="<?= $customer['data']['id']; ?>" />

                    <div class="col-md-8 mb-3">
                        <label>Customer Name *</label>
                        <input type="text" name="cust_name" value="<?= $customer['data']['cust_name']; ?>" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Phone Number *</label>
                        <input type="text" name="phone_number" value="<?= $customer['data']['phone_number']; ?>" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email *</label>
                        <input type="email" name="cust_email" value="<?= $customer['data']['cust_email']; ?>" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Home Town *</label>
                        <input type="text" name="home_town" value="<?= $customer['data']['home_town']; ?>" required class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" name="updateCustomer" class="btn btn-primary">Update</button>
                    </div>
                    <?php
                }
                else
                {
                    echo '<h5>'.$customer['message'].'</h5>';
                }
                ?>
            </form>
        </div>
    </div>
</div>

<br> </br>
<br> </br>
<br> </br>
<br> </br>
<br> </br>

<?php include("includes/footer.php"); ?>