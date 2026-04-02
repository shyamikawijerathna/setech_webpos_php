<?php include("includes/header.php"); ?>

<?php 

checkPermission([1, 2]); // Everyone can see the dashboard
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Product
                <a href="products.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?> 
            
            <form action="code.php" method="POST" enctype="multipart/form-data"> 

            <?php  
                $paramValue = checkParamId('id');
                if(!is_numeric($paramValue)){
                    echo '<h5>Id is not an integer</h5>';
                    return false;
                }

                $product = getById('products', $paramValue);

                if($product['status'] == 200) 
                {
                    $productData = $product['data'];
                ?>

                <input type="hidden" name="product_id" value="<?= $productData['id']; ?>">

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Select Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            <?php 
                            $categories = getAll('categories');
                            if($categories) {
                                if(mysqli_num_rows($categories) > 0) {
                                    while($cateItem = mysqli_fetch_assoc($categories)) {
                                        ?>
                                        <option value="<?= $cateItem['id']; ?>" 
                                            <?= $productData['category_id'] == $cateItem['id'] ? 'selected':''; ?>
                                        >
                                            <?= $cateItem['cat_name']; ?>
                                        </option>
                                        <?php
                                    }
                                } else {
                                    echo '<option value="">No categories found</option>';
                                }
                            } else {
                                echo '<option value="">Database Error</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Product Name *</label>
                        <input type="text" name="prod_name" value="<?= $productData['prod_name']; ?>" required class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Description *</label>
                        <textarea name="description" class="form-control" rows="3"><?= $productData['description']; ?></textarea>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Buy Price *</label>
                        <input type="text" name="buy_price" value="<?= $productData['buy_price']; ?>" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Sale Price *</label>
                        <input type="text" name="sale_price" value="<?= $productData['sale_price']; ?>" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Quantity *</label>
                        <input type="text" name="quantity" value="<?= $productData['quantity']; ?>" class="form-control">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Store Location</label>
                        <input type="text" name="store_location" value="<?= $productData['store_location'] ?? ''; ?>" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Barcode/Serial Number</label>
                        <div class="input-group">
                            <input type="text" name="barcode" id="barcodeInput" value="<?= $productData['barcode']; ?>" class="form-control">
                            <button type="button" class="btn btn-secondary" onclick="generateBarcode()">Generate</button>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                        <div class="mt-2">
                            <small>Current Image:</small><br>
                            <img src="../<?= $productData['image']; ?>" style="width:70px;height:70px;" alt="Product Image">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Status (Checked=Hidden, Unchecked=Visible)</label>
                        <br/>
                        <input type="checkbox" name="status" <?= $productData['status'] == '1' ? 'checked':''; ?> style="width:30px;height:30px;">
                    </div>

                    <div class="col-md-12 mb-3">
                        <button type="submit" name="updateProduct" class="btn btn-primary">Update Product</button>
                    </div>
                </div>

                <?php
                } else {
                    echo '<h5>'.$product['message'].'</h5>';
                }
            ?>
            </form>
        </div>
    </div>
</div>

<script>
function generateBarcode() {
    const randomBarcode = Math.floor(100000000 + Math.random() * 900000000);
    document.getElementById('barcodeInput').value = randomBarcode;
}
</script>

<br> </br>
<br> </br>
<br> </br>
<br> </br>
<br> </br>

<?php include("includes/footer.php"); ?>