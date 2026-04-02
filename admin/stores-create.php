<?php include("includes/header.php"); ?>

<?php
checkPermission([1]); // Only Super Admin
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Create Store
                <a href="stores.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST"> 
                <div class="row">
                    
                    <div class="col-md-12 mb-3">
                        <label>Store Name *</label>
                        <input type="text" name="store_name" required class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Store Code *</label>
                        <input type="text" name="store_code" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Store Address *</label>
                        <input type="text" name="store_address" required class="form-control">
                    </div> 

                    <div class="col-md-6 mb-3">
                        <label>Contact Number *</label>
                        <input type="number" name="store_contact" required class="form-control">

                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" name="saveStore" class="btn btn-primary">Save</button>
                    </div>
                </div>
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
