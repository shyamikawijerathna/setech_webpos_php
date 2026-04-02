<?php include("includes/header.php"); ?>


<?php 

checkPermission([1, 2]); // Everyone can see the dashboard
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Product
                <a href="products.php" class="btn btn-primary float-end ms-2">Back</a>
                <a href="bulk-upload.php" class="btn btn-success float-end">Add Bulk Products</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?> 
            
            <form action="code.php" method="POST" enctype="multipart/form-data"> 
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Select Category *</label>
                        <select name="category_id" id="categorySelect" class="form-select" required onchange="updateCategoryDetails()">
                            <option value="">Select Category</option>
                            <?php 
                            $categories = getAll('categories');
                            if($categories) {
                                if(mysqli_num_rows($categories) > 0) {
                                    while($cateItem = mysqli_fetch_assoc($categories)) {
                                        ?>
                                        <option value="<?= $cateItem['id']; ?>" data-name="<?= $cateItem['cat_name']; ?>">
                                            <?= $cateItem['cat_name']; ?>
                                        </option>
                                        <?php
                                    }
                                } else {
                                    echo '<option value="">No categories found</option>';
                                }
                            }
                            ?>
                        </select>
                        <input type="hidden" name="cat_name" id="cat_name_hidden">
                    </div> 

                    <div class="col-md-6 mb-3">
                        <label>Category ID (Auto-filled)</label>
                        <input type="text" id="display_cat_id" readonly class="form-control" placeholder="Select a category above">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Product Name *</label>
                        <input type="text" name="prod_name" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Description (Model No.) *</label>
                        <textarea name="description" required class="form-control" rows="2"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Buy Price *</label>
                        <input type="text" name="buy_price" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Quantity *</label>
                        <input type="text" name="quantity" required class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Sale Price *</label>
                        <input type="text" name="sale_price" required class="form-control">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Store Location *</label>
                        <input type="text" name="store_location" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Barcode / Serial Number</label>
                        <div class="input-group">
                            <input type="text" name="barcode" id="barcodeInput" class="form-control" placeholder="Scan or generate barcode">
                            <button type="button" class="btn btn-secondary" onclick="generateBarcode()">Generate</button>
                        </div>
                        <small class="text-muted">Leave blank to auto-generate a unique 10-digit number.</small>
                    </div> 

                    <div class="col-md-6 mb-3">
                        <label>Product Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Status (Checked = Visible, Unchecked = Hidden)</label>
                        <br/>
                        <input type="checkbox" name="status" style="width:30px;height:30px;" checked>
                    </div>

                    <div class="col-md-12 mb-3 text-end">
                        <hr>
                        <button type="submit" name="saveProduct" class="btn btn-success btn-lg px-5">Save Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
/**
 * Updates the Category ID display and the hidden cat_name field 
 * when a category is selected from the dropdown.
 */
function updateCategoryDetails() {
    const select = document.getElementById('categorySelect');
    const selectedOption = select.options[select.selectedIndex];
    
    const catId = select.value;
    const catName = selectedOption.getAttribute('data-name');

    // Update the visual ID box
    document.getElementById('display_cat_id').value = catId;
    
    // Update the hidden input that sends the string 'cat_name' to code.php
    document.getElementById('cat_name_hidden').value = catName || "";
}

/**
 * Simple random barcode generator logic
 */
function generateBarcode() {
    const randomBarcode = Math.floor(1000000000 + Math.random() * 9000000000);
    document.getElementById('barcodeInput').value = randomBarcode;
}
</script>

<?php include("includes/footer.php"); ?>