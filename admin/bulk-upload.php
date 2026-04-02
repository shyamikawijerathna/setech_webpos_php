<?php include("includes/header.php"); ?>


<?php 

checkPermission([1, 2]); // Everyone can see the dashboard
?>
<div class="card mt-4 shadow-sm">
    <div class="card-header">
        <h4>Bulk Import Products
            <a href="products-create.php" class="btn btn-danger float-end">Back</a>
        </h4>
    </div>
    <div class="card-body">
        <?php alertMessage(); ?>
        
        <div class="alert alert-info">
            <strong>CSV File Format Expected:</strong><br>
            Please ensure your CSV file has the following columns in order (without commas in the data):<br>
            1. <strong>Category ID</strong> (Numeric ID of the Category)<br>
            2. <strong>Product Name</strong><br>
            3. <strong>Description</strong><br>
            4. <strong>Buy Price</strong><br>
            5. <strong>Quantity</strong><br>
            6. <strong>Sale Price</strong><br>
            7. <strong>Store Location</strong><br>
            8. <strong>Image Filename</strong> (e.g., <code>product1.jpg</code> - this must match the image uploaded below)<br>
            <em>Note: The first row of the CSV is ignored as a header row.</em>
        </div>

        <form action="code.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Upload CSV File *</label>
                    <input type="file" name="import_file" class="form-control" accept=".csv" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Upload Product Images (Select Multiple Files)</label>
                    <input type="file" name="prod_images[]" class="form-control" multiple accept="image/*">
                    <small class="text-muted">Filenames must match the specific image filename defined in the CSV.</small>
                </div>
                <div class="col-md-12 text-end">
                    <button type="submit" name="bulk_import_btn" class="btn btn-primary px-4">Import Products</button>
                </div>
            </div>
        </form>
    </div>
</div>



<?php include("includes/footer.php"); ?>