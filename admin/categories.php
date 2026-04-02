<?php include("includes/header.php")  ?>

<?php 

checkPermission([1, 2, 3]); // Everyone can see the dashboard
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Categories
                    <a href="categories-create.php" class="btn btn-success float-end ms-2"> + Add Category</a>
                    <a href="categories-trash.php" class="btn btn-secondary float-end"> 
                        <i class="fa fa-trash"></i> View Trash
                    </a>
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
                            <th>Sub Category</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $categories = getall('categories');
                        
                        
                        if(!$categories){
                            echo '<tr><td colspan="6"><h4> Something Went Wrong ! </h4></td></tr>';
                        }
                        elseif(mysqli_num_rows($categories) > 0)
                        {
                            foreach($categories as $item) : 
                            ?>
                            <tr>
                                <td><?= $item['id'] ?></td>
                                <td><?= $item['cat_name'] ?></td>
                                <td><?= $item['sub_category'] ?></td>
                                <td><?= $item['description'] ?></td>
                                <td>
                                    <?php 
                                        
                                        if($item['status'] == 0) {
                                            echo '<span class="badge bg-danger">Hidden</span>'; 
                                        } else {
                                            echo '<span class="badge bg-success">Visible</span>';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a href="categories-edit.php?id=<?= $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="categories-delete.php?id=<?= $item['id']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Are you sure you want to delete this category?')">
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