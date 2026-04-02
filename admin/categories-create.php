<?php include("includes/header.php"); ?>

<?php
checkPermission([1, 2]);
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Category
                <a href="categories.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?> 
            
            <form action="code.php" method="POST"> 
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Category Name *</label>
                        <input type="text" name="cat_name" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Sub Category</label>
                        <input type="text" name="sub_category" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Status (Checked = visible, Unchecked = Hidden)</label>
                        <br/>
                        <input type="checkbox" name="status" style="width:30px;height:30px;">
                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" name="saveCategory" class="btn btn-primary">Save</button>
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