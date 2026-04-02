<?php include("includes/header.php")  ?>

<?php 

checkPermission([1, 2]); // admin,inventory staff can see the dashboard
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Suppliers
                <a href="suppliers-create.php" class="btn btn-success float-end"> + Add Supplier</a>
            </h4>
        </div>
        <div class="px-3 mt-3">
            <?php alertMessage(); ?>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-striped table-bordered"> 
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Supply Item</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $suppliers = getall('suppliers');
                        
                        
                        if(!$suppliers){
                            echo '<tr><td colspan="6"><h4> Something Went Wrong ! </h4></td></tr>';
                        }
                        elseif(mysqli_num_rows($suppliers) > 0)
                        {
                            foreach($suppliers as $item) : 
                            ?>
                            <tr>
                                <td><?= $item['id'] ?></td>
                                <td><?= $item['supp_name']; ?></td>
                                <td><?= $item['item']; ?></td>
                                <td><?= $item['phone_number']; ?></td>
                                 <td><?= $item['supp_email'] ;?></td>
                                <td><?= $item['address']; ?></td>
                                 
                              
                                <td>
                                    <a href="suppliers-edit.php?id=<?= $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="suppliers-delete.php?id=<?= $item['id']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Are you sure you want to delete this supplier?')">
                                       Delete
                                    </a>
                                </td>
                            </tr>
                            <?php 
                            endforeach; 
                        }
                        else
                        {
                            ?>  
                            <tr>
                                <td colspan="6" class="text-center">No Record Found</td>
                            </tr>
                            <?php
                        }
                        ?>
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