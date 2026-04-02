<?php include("includes/header.php"); ?>

<?php 

checkPermission([1, 2]); // admin,inventory staff can see the dashboard
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Supplier
                <a href="suppliers.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?> 
            
            <form action="code.php" method="POST" enctype="multipart/form-data"> 
               
            
                    <div class="col-md-8 mb-3">
                        <label>Supplier Name *</label>
                        <input type="text" name="supp_name" required class="form-control">
                    </div>

                    <div class="col-md-8 mb-3">
                        <label>Supply Item *</label>
                        <input type="text" name="item" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Phone Number *</label>
                        <input type="text" name="phone_number" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email *</label>
                        <input type="text" name="supp_email" required class="form-control">
                       
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Address *</label>
                        <input type="text" name="address" required class="form-control">
                    </div>
           
     

                    <div class="col-md-12 mb-3">
                        <button type="submit" name="saveSupplier" class="btn btn-primary">Save</button>
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