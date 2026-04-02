<?php include("includes/header.php")  ?>

<?php
checkPermission([1]); // Only Super Admin
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
             <h4 class="mb-0">Admins
                    <a href="admins-create.php" class="btn btn-success float-end ms-2"> + Add Admin</a>
                    <a href="admins-trash.php" class="btn btn-secondary float-end"> 
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
                            <th>ID</th>
                            <th>Store_ID</th>
                            <th>Admin Level</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $admins =getall('admins');
                        if(mysqli_num_rows($admins) > 0)
                        {

                        ?>
                        <?php foreach($admins as $adminItem) : ?>
                        <tr>
                            <td><?= $adminItem['id']  ?> </td>
                            <td><?= $adminItem['store_id']  ?> </td>
                            <td><?= $adminItem['role_level']  ?> </td>
                            <td><?= $adminItem['name']  ?></td>
                            <td><?= $adminItem['email']  ?></td>
                            <td><?= $adminItem['phone'] ?></td>
                            <td>
                                <a href="admins-edit.php?id=<?= $adminItem['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="admins-delete.php?id=<?= $adminItem['id']; ?>" 
                                class="btn btn-danger btn-sm" 
                                onclick="return confirm('Are you sure you want to delete this admin?')">
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