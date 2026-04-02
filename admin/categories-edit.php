<?php include("includes/header.php"); ?>

<?php
checkPermission([1, 2]);
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Category
                <a href="categories.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?> 
            
            <form action="code.php" method="POST"> 
                <?php
                $paramId = checkParamId('id');
                if(!is_numeric($paramId)){
                    echo '<h5>'.$paramId.'</h5>';
                    return false;
                }

                $category = getById('categories', $paramId);
                if($category['status'] == 200)
                {
                    ?>
                    <input type="hidden" name="categoryId" value="<?= $category['data']['id']; ?>">

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Category Name *</label>
                            <input type="text" name="cat_name" value="<?= $category['data']['cat_name']; ?>" required class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Sub Category</label>
                            <input type="text" name="sub_category" value="<?= $category['data']['sub_category']; ?>" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Description</label>
                            <input type="text" name="description" value="<?= $category['data']['description']; ?>" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Status (Checked = visible, Unchecked = Hidden)</label>
                            <br/>
                            <input type="checkbox" name="status" <?= $category['data']['status'] == 1 ? 'checked':''; ?> style="width:30px;height:30px;">
                        </div>

                        <div class="col-md-12 mb-3">
                            <button type="submit" name="updateCategory" class="btn btn-primary">Update Category</button>
                        </div>
                    </div>
                    <?php
                }
                else
                {
                    echo '<h5>'.$category['message'].'</h5>';
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