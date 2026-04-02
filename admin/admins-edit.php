<?php include("includes/header.php"); ?>

<?php
checkPermission([1]); // Only Super Admin
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Admin
                <a href="admins.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <form action="code.php" method="POST">
                <?php
                if(isset($_GET['id'])) 
                    {
                    if($_GET['id'] != '') {

                        $adminId = $_GET['id'];
                        
                    } else {
                        echo '<h5>No ID Found</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>No ID given in URL</h5>';
                    return false;
                }

                // Fetching the specific admin data
                $adminData = getById('admins', $adminId);

                if($adminData) {
                    if($adminData['status'] == 200) {
                        ?>
                        <input type="hidden" name="adminId" value="<?= $adminData['data']['id']; ?>">

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Store_ID *</label>
                                <input type="text" name="store_id" value="<?= $adminData['data']['store_id']; ?>" required class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Admin Level *</label>
                                <input type="number" name="role_level" value="<?= $adminData['data']['role_level']; ?>" required class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Name *</label>
                                <input type="text" name="name" value="<?= $adminData['data']['name']; ?>" required class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Email *</label>
                                <input type="email" name="email" value="<?= $adminData['data']['email']; ?>" required class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Password (Leave blank if you don't want to change)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Phone Number</label>
                                <input type="text" name="phone" value="<?= $adminData['data']['phone']; ?>" class="form-control">
                            </div>
                           
                            <div class="col-md-12 mb-3 text-end">
                                <button type="submit" name="updateAdmin" class="btn btn-primary">Update Admin</button>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo '<h5>'.$adminData['message'].'</h5>';
                    }
                } else {
                    echo '<h5>Something went wrong!</h5>';
                }
                ?>
            </form>
        </div>
    </div>
</div>

<br> </br>
<br> </br>
<br> </br>
<br> </br>
<br> </br>

<?php include("includes/footer.php"); ?>