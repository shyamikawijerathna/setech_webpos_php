<?php include("includes/header.php"); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Deleted Stores (Trash)
                <a href="stores.php" class="btn btn-primary float-end">Back to Stores</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Store Name</th>
                            <th>Deleted At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch only deleted records
                        $query = "SELECT * FROM stores WHERE deleted_at IS NOT NULL";
                        $trashStores = mysqli_query($conn, $query);

                        if(mysqli_num_rows($trashStores) > 0) {
                            foreach($trashStores as $item) : ?>
                                <tr>
                                    <td><?= $item['id']; ?></td>
                                    <td><?= $item['store_name']; ?></td>
                                    <td><?= date('d M, Y h:i A', strtotime($item['deleted_at'])); ?></td>
                                    <td>
                                        <a href="stores-restore.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm">Restore</a>
                                    </td>
                                </tr>
                            <?php endforeach;
                        } else {
                            echo '<tr><td colspan="4">No deleted stores found.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>