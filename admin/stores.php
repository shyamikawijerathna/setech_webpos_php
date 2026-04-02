<?php include("includes/header.php")  ?>

<?php
checkPermission([1]); // Only Super Admin
?>

   

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
                <h4 class="mb-0">Stores
                    <a href="stores-create.php" class="btn btn-success float-end ms-2"> + Add Store</a>
                    <a href="stores-trash.php" class="btn btn-secondary float-end"> 
                        <i class="fa fa-trash"></i> View Trash
                    </a>
                </h4>
            </div>
        <div class="Add message">
            <?php alertMessage(); ?>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-striped table-bordered"> 
                    <thead>
                        <tr>
                            
                            <th>Store_ID</th>
                            <th>Store Name</th>
                            <th>Store Code</th>
                            <th>Store Address</th>
                            <th>Store Contact</th>
                            <th>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stores =getall('stores');
                        if(mysqli_num_rows($stores) > 0)
                        {

                        ?>
                        <?php foreach($stores as $storeItem) : ?>
                        <tr>
                            <td><?= $storeItem['id']  ?> </td>
                            <td><?= $storeItem['store_name']  ?> </td>
                            <td><?= $storeItem['store_code']  ?></td>
                            <td><?= $storeItem['store_address']  ?></td>
                            <td><?= $storeItem['store_contact']  ?></td>
                            <td>
                                <a href="stores-edit.php?id=<?= $storeItem['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="stores-delete.php?id=<?= $storeItem['id']; ?>" 
                                class="btn btn-danger btn-sm" 
                                onclick="return confirm('Are you sure you want to delete this store?')">
                                Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php
                        }
                        else
                        {

                          ?>  
                        <tr>
                            <td colspan="4">No Record Found</td>
                        </tr>

                            <?php

                        }
                        ?>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    
</div>


<br> </br>
<br> </br>
<br> </br>
<br> </br>
<br> </br>


 
<?php include("includes/footer.php")  ?>