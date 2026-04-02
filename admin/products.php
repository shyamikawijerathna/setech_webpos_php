<?php include("includes/header.php")  ?>

<?php 

checkPermission([1, 2, 3]); // Everyone can see the dashboard
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Products
                    <a href="products-create.php" class="btn btn-success float-end ms-2"> + Add Product</a>
                    <a href="products-trash.php" class="btn btn-secondary float-end"> 
                        <i class="fa fa-trash"></i> View Trash
                    </a>
                </h4>

            <br>
            
            <form action="" method="GET">
                <div class="row g-2">
                    <div class="col-md-3">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            <?php
                            $categories = mysqli_query($conn, "SELECT * FROM categories");
                            if(mysqli_num_rows($categories) > 0) {
                                foreach($categories as $catItem) {
                                    $selected = (isset($_GET['category']) && $_GET['category'] == $catItem['id']) ? 'selected' : '';
                                    echo '<option value="'.$catItem['id'].'" '.$selected.'>'.$catItem['cat_name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                                    <select name="location" class="form-select">
                                        <option value="">All Locations</option>
                                        <?php
                                        // This query finds all unique locations currently in your products table
                                        $loc_query = mysqli_query($conn, "SELECT DISTINCT store_location FROM products WHERE store_location != ''");
                                        if(mysqli_num_rows($loc_query) > 0) {
                                            foreach($loc_query as $locItem) {
                                                $locName = $locItem['store_location'];
                                                $selected = (isset($_GET['location']) && $_GET['location'] == $locName) ? 'selected' : '';
                                                echo '<option value="'.$locName.'" '.$selected.'>'.$locName.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="products.php" class="btn btn-danger">Reset</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="px-3 mt-3">
            <?php alertMessage(); ?>
        </div>

        <div class="card-body">
            <?php
            // --- PAGINATION SETTINGS ---
            $perPage = 15;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            if ($page < 1) $page = 1;
            $offset = ($page - 1) * $perPage;

            // --- BUILD FILTER QUERY ---
            $conditions = [];
            $categoryID = isset($_GET['category']) ? validate($_GET['category']) : '';
            $location = isset($_GET['location']) ? validate($_GET['location']) : '';

            if ($categoryID != '') {
                $conditions[] = "p.category_id = '$categoryID'";
            }
            if ($location != '') {
                $conditions[] = "p.store_location LIKE '%$location%'";
            }

            $whereSql = "";
            if (count($conditions) > 0) {
                $whereSql = " WHERE " . implode(" AND ", $conditions);
            }

            // --- COUNT TOTAL RECORDS (For Pagination) ---
            $countQuery = "SELECT COUNT(*) as total FROM products p $whereSql";
            $countRes = mysqli_query($conn, $countQuery);
            $totalRecords = mysqli_fetch_assoc($countRes)['total'];
            $totalPages = ceil($totalRecords / $perPage);

            // --- FINAL DATA QUERY ---
            // Note: cat_name column is inside products table as per your requirement
            $query = "SELECT p.* FROM products p $whereSql ORDER BY p.id DESC LIMIT $offset, $perPage";
            $products = mysqli_query($conn, $query);

            if($products) :
                if(mysqli_num_rows($products) > 0) :
            ?>

            <p class="text-muted">Showing page <?= $page ?> of <?= $totalPages ?> (Total <?= $totalRecords ?> products found)</p>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle"> 
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Barcode/SN</th>
                            <th>Buy Price</th>
                            <th>Quantity</th>
                            <th>Sale Price</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $item) : ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td>
                                    <?php 
                                        $imgTag = "../" . $item['image'];
                                        // Check if image path exists in DB AND file exists on server
                                        if(!empty($item['image']) && file_exists("../".$item['image'])){
                                            $displayImg = "../".$item['image'];
                                        } else {
                                            // Fallback to a default image
                                            $displayImg = "../assets/assets/img/no-image.png"; // Or your preferred path
                                        }
                                    ?>
                                    <img src="<?= $displayImg; ?>" 
                                        style="width:40px;height:40px;object-fit:cover;border-radius:5px;" 
                                        alt="Product Image">
                                </td>
                            <td><?= $item['prod_name']; ?></td>
                            <td><?= $item['cat_name']; ?></td>
                            <td><?= $item['barcode']; ?></td>
                            <td><?= $item['buy_price'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= $item['sale_price'] ?></td>
                            <td><?= $item['store_location'] ?></td>
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
                                <a href="products-edit.php?id=<?= $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="products-delete.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php
                        $params = $_GET; // Keep filter values in URL
                        
                        // Previous
                        $params['page'] = $page - 1;
                        $prevDisabled = ($page <= 1) ? 'disabled' : '';
                        echo '<li class="page-item '.$prevDisabled.'"><a class="page-link" href="?'.http_build_query($params).'">Previous</a></li>';

                        // Page Numbers
                        for ($i = 1; $i <= $totalPages; $i++) {
                            $params['page'] = $i;
                            $activeClass = ($i == $page) ? 'active' : '';
                            echo '<li class="page-item '.$activeClass.'"><a class="page-link" href="?'.http_build_query($params).'">'.$i.'</a></li>';
                        }

                        // Next
                        $params['page'] = $page + 1;
                        $nextDisabled = ($page >= $totalPages) ? 'disabled' : '';
                        echo '<li class="page-item '.$nextDisabled.'"><a class="page-link" href="?'.http_build_query($params).'">Next</a></li>';
                    ?>
                </ul>
            </nav>

            <?php else: ?>
                <div class="alert alert-info">No Record Found</div>
            <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-danger">Something Went Wrong!</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include("includes/footer.php")  ?>