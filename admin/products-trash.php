<?php include("includes/header.php"); 

//for current date time
date_default_timezone_set("Asia/Colombo");

?>



<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Deleted Products (Trash)
                <a href="products.php" class="btn btn-primary float-end">Back to Products</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Deleted At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch only deleted records
                        $query = "SELECT * FROM products WHERE deleted_at IS NOT NULL";
                        $trashProducts = mysqli_query($conn, $query);

                        if(mysqli_num_rows($trashProducts) > 0) {
                            foreach($trashProducts as $item) : ?>
                                <tr>
                                    <td><?= $item['id']; ?></td>
                                    <td><?= $item['prod_name']; ?></td>
                                    <td><?= date('d M, Y h:i A', strtotime($item['deleted_at'])); ?></td>
                                    <td>
                                        <a href="products-restore.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm">Restore</a>
                                    </td>
                                </tr>
                            <?php endforeach;
                        } else {
                            echo '<tr><td colspan="4">No deleted products found.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>