<?php include("includes/header.php")  ?>

<?php 

checkPermission([1, 2, 3]); // Everyone can see the dashboard
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Customers
                <a href="customers-create.php" class="btn btn-success float-end"> + Add Customer</a>
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
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Home Town</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $customers = getall('customers');
                        
                        
                        if(!$customers){
                            echo '<tr><td colspan="6"><h4> Something Went Wrong ! </h4></td></tr>';
                        }
                        elseif(mysqli_num_rows($customers) > 0)
                        {
                            foreach($customers as $item) : 
                            ?>
                            <tr>
                                <td><?= $item['id'] ?></td>
                                <td><?= $item['cust_name']; ?></td>
                                <td><?= $item['phone_number']; ?></td>
                                 <td><?= $item['cust_email'] ;?></td>
                                <td><?= $item['home_town']; ?></td>
                                 
                              
                                <td>
                                    <a href="customers-edit.php?id=<?= $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="customers-delete.php?id=<?= $item['id']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Are you sure you want to delete this customer?')">
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



<?php include("includes/footer.php")  ?>