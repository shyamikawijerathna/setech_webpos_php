<?php include("includes/header.php"); ?>

<?php
checkPermission([1]); // Only Super Admin
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Admin
                <a href="admins.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST"> 
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Store_ID *</label>
                        <input type="text" name="store_id" required class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Admin Level *</label>
                        <input type="number" name="role_level" required class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Name *</label>
                        <input type="text" name="name" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email *</label>
                        <input type="email" name="email" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Password *</label>
                        <input type="password" name="password" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Phone number *</label>
                        <input type="text" name="phone" required class="form-control">
                    </div>

                    

                    <div class="col-md-12 mb-3">
                        <button type="submit" name="saveAdmin" class="btn btn-primary">Save</button>
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
