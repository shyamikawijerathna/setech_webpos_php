<?php include("includes/header.php"); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Deleted Admins (Trash)
                <a href="admins.php" class="btn btn-primary float-end">Back to Admins</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Admin Name</th>
                            <th>Admin Phone No.</th>
                            <th>Deleted At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch only deleted records
                        $query = "SELECT * FROM admins WHERE deleted_at IS NOT NULL";
                        $trashAdmins = mysqli_query($conn, $query);

                        if(mysqli_num_rows($trashAdmins) > 0) {
                            foreach($trashAdmins as $item) : ?>
                                <tr>
                                    <td><?= $item['id']; ?></td>
                                    <td><?= $item['name']; ?></td>
                                    <td><?= $item['phone']; ?></td>
                                    <td><?= date('d M, Y h:i A', strtotime($item['deleted_at'])); ?></td>
                                    <td>
                                        <a href="admins-restore.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm">Restore</a>
                                    </td>
                                </tr>
                            <?php endforeach;
                        } else {
                            echo '<tr><td colspan="4">No deleted admins found.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>