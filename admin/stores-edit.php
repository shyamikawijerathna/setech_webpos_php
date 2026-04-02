<?php include("includes/header.php"); ?>

<?php
checkPermission([1]); // Only Super Admin
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Store
                <a href="stores.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <form action="code.php" method="POST">
                <?php
                if(isset($_GET['id'])) 
                    {
                    if($_GET['id'] != '') {

                        $storeId = $_GET['id'];
                        
                    } else {
                        echo '<h5>No ID Found</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>No ID given in URL</h5>';
                    return false;
                }

                // Fetching the specific store data
                $storeData = getById('stores', $storeId);

                if($storeData) {
                    if($storeData['status'] == 200) {
                        ?>
                        <input type="hidden" name="storeId" value="<?= $storeData['data']['id']; ?>">

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Store_ID *</label>
                                <input type="text" name="store_id" value="<?= $storeData['data']['id']; ?>" required class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Store Name *</label>
                                <input type="text" name="store_name" value="<?= $storeData['data']['store_name']; ?>" required class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Store Code *</label>
                                <input type="text" name="store_code" value="<?= $storeData['data']['store_code']; ?>" required class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Store Address *</label>
                                <input type="text" name="store_address" value="<?= $storeData['data']['store_address']; ?>" required class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="">Store contact *</label>
                                <input type="text" name="store_contact" value="<?= $storeData['data']['store_contact']; ?>" required class="form-control">
                            </div>
                            
                           
                            <div class="col-md-12 mb-3 text-end">
                                <button type="submit" name="updateStore" class="btn btn-primary">Update Store</button>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo '<h5>'.$storeData['message'].'</h5>';
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