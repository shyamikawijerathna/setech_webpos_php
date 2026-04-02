<?php include("includes/header.php"); ?>

<?php 

checkPermission([1, 2]); // admin,inventory staff can see the dashboard
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Supplier Edit
                <a href="suppliers.php" class="btn btn-danger float-end">Back</a>
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

                $supplier = getById('suppliers', $paramValue);
                if($supplier['status'] == 200)
                {
                    ?>
                    <input type="hidden" name="supplierId" value="<?= $supplier['data']['id']; ?>" />

                    <div class="col-md-8 mb-3">
                        <label>Supplier Name *</label>
                        <input type="text" name="supp_name" value="<?= $supplier['data']['supp_name']; ?>" required class="form-control">
                    </div>

                    <div class="col-md-8 mb-3">
                        <label>Supplier Item *</label>
                        <input type="text" name="item" value="<?= $supplier['data']['item']; ?>" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Phone Number *</label>
                        <input type="text" name="phone_number" value="<?= $supplier['data']['phone_number']; ?>" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email *</label>
                        <input type="email" name="supp_email" value="<?= $supplier['data']['supp_email']; ?>" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Address *</label>
                        <input type="text" name="address" value="<?= $supplier['data']['address']; ?>" required class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" name="updateSupplier" class="btn btn-primary">Update</button>
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