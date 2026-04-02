<?php include("includes/header.php");  ?>

<!-- for table and pie chart -->
<?php
// 1. Monthly Sales (Current Year)
$monthlySalesQuery = "SELECT MONTHNAME(order_date) as month, SUM(total_amount) as amount 
                      FROM orders GROUP BY MONTH(order_date)";
                      
$m_result = mysqli_query($conn, $monthlySalesQuery);
$months = []; $m_amounts = [];
foreach($m_result as $row) { $months[] = $row['month']; $m_amounts[] = $row['amount']; }



// 2. Daily Sales (Last 7 Days)
$dailySalesQuery = "SELECT DATE(order_date) as date, SUM(total_amount) as amount 
                    FROM orders WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
                    GROUP BY DATE(order_date)";

$d_result = mysqli_query($conn, $dailySalesQuery);
$days = []; $d_amounts = [];
foreach($d_result as $row) { $days[] = $row['date']; $d_amounts[] = $row['amount']; }



// 3. Top 5 Selling Items (Pie Chart)
$topItemsQuery = "SELECT p.prod_name, SUM(oi.quantity) as total_qty 
                  FROM order_items oi 
                  JOIN products p ON p.id = oi.product_id 
                  GROUP BY oi.product_id ORDER BY total_qty DESC LIMIT 5";

$t_result = mysqli_query($conn, $topItemsQuery);
$items = []; $item_qty = [];
foreach($t_result as $row) { $items[] = $row['prod_name']; $item_qty[] = $row['total_qty']; }
?>



<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="store details">
        
    <?php 
        $nav_store_name = 'N/A';
        $nav_store_code = 'N/A';
        $nav_store_contact = 'N/A';
        if(isset($_SESSION['loggedInUser']['store_id']) && $_SESSION['loggedInUser']['store_id'] != '') {
            $nav_store_id = validate($_SESSION['loggedInUser']['store_id']);
            $nav_store_q = mysqli_query($conn, "SELECT store_name, store_code, store_contact FROM stores WHERE id='$nav_store_id' LIMIT 1");
            if($nav_store_q && mysqli_num_rows($nav_store_q) > 0) {
                $nav_sdata = mysqli_fetch_assoc($nav_store_q);
                $nav_store_name = $nav_sdata['store_name'] ?? 'N/A';
                $nav_store_code = $nav_sdata['store_code'] ?? 'N/A';
                $nav_store_contact = $nav_sdata['store_contact'] ?? 'N/A';
            }
        }
    ?>
    </div>
            <h1 class="mt-4">Dashboard</h1>
            <?php alertMessage(); ?>
        </div>

             <li class="nav-item d-flex align-items-center me-3 mb-4">
            <span class="text-white" style="font-size: 20px; line-height: 1.2; text-align: right;">
                <strong>Store:</strong> <?= htmlspecialchars($nav_store_name); ?> (<?= htmlspecialchars($nav_store_code); ?>)
                <span class="mx-2">|</span>
                <strong>Contact:</strong> <?= htmlspecialchars($nav_store_contact); ?>
            </span>
        </li>


        <div class="col-md-3 mb-3">
                <div class="card card-body p-3 border-0" 
                    style="background: linear-gradient(135deg, #451ed3 0%, #7914a1 100%); color: white;">
                    
                    <p class="text-sm mb-0 text-capitalize">Total Admins Here</p>
                    <h5 class="fw-bold mb-0"><?= getCount('admins'); ?></h5>
                    <p class="text-sm mb-0 text-capitalize">Company Admin Staff</p>
                    
                </div>
            </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body p-3 border-0" 
                    style="background: linear-gradient(135deg, #d84e77 0%, #b8621c 100%); color: white;">
                <p class="text-sm mb-0 text-capitalize">Total Categories</p>
                <h5 class="fw-bold mb-0"><?= getCount('categories'); ?></h5>
                <p class="text-sm mb-0 text-capitalize">Total Products Categories</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body p-3 border-0" 
                    style="background: linear-gradient(135deg, #1da734 0%, #14a1a1 100%); color: white;">
                <p class="text-sm mb-0 text-capitalize">Total Products</p>
                <h5 class="fw-bold mb-0"><?= getCount('products'); ?></h5>
                <p class="text-sm mb-0 text-capitalize">Company Total Products</p>
            </div>
        </div>

        

        <div class="col-md-3 mb-3">
            <div class="card card-body p-3 border-0" 
                    style="background: linear-gradient(135deg, #451ed3 0%, #7914a1 100%); color: white;">
                <p class="text-sm mb-0 text-capitalize">Total Suppliers</p>
                <h5 class="fw-bold mb-0"><?= getCount('suppliers'); ?></h5>
                <p class="text-sm mb-0 text-capitalize">Company Total Suppliers</p>
            </div>
        </div>

        


        <div class="col-md-12 mb-3">
                <hr>
                <h4>Orders</h4>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card card-body p-3 border-0" 
                    style="background: linear-gradient(135deg, #129b0d 0%, #96b915 100%); color: white;">
                            <p class="text-sm mb-0 text-capitalize">Today Orders</p>
                            
                            <h5 class="fw-bold mb-0">
                                <?php 
                                    $todayDate = date('Y-m-d');
                                    
                                    $todayOrders = mysqli_query($conn, "SELECT * FROM orders WHERE DATE(order_date) = '$todayDate'");
                                    
                                    if($todayOrders) {
                                        $totalCountOrders = mysqli_num_rows($todayOrders);
                                        echo $totalCountOrders; 
                                    } else {
                                        echo 'Error';
                                    }
                                ?>
                            </h5>
                            <p class="text-sm mb-0 text-capitalize">Today Total Orders</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card card-body p-3 border-0" 
                    style="background: linear-gradient(135deg, #bb1919 0%, #691f86 100%); color: white;">
                            <p class="text-sm mb-0 text-capitalize">Total Orders</p>
                            
                            <h5 class="fw-bold mb-0"><?= getCount('orders'); ?></h5>
                            <p class="text-sm mb-0 text-capitalize">Company Total Orders</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                          <div class="card card-body p-3 border-0" 
                    style="background: linear-gradient(135deg, #9b7c15 0%, #e2df3c 100%); color: white;">
                            <p class="text-sm mb-0 text-capitalize">Today Income</p>
                            
                          <?php 
                          // This is for today income
                                    $todayDate = date('Y-m-d');
                                   
                                    $todayIncomeQuery = mysqli_query($conn, "SELECT SUM(total_amount) AS today_total FROM orders WHERE DATE(order_date) = '$todayDate'");
                                    
                                    if($todayIncomeQuery) {
                                        $row = mysqli_fetch_assoc($todayIncomeQuery);
                                        $totalIncome = $row['today_total'];
                                        
                                        
                                        echo $totalIncome > 0 ? number_format($totalIncome, 2) : "0.00";
                                    } else {
                                        echo 'Error';
                                    }
                                ?>
                                <p class="text-sm mb-0 text-capitalize">Company Today Income</p>
                        </div>
                    </div>
                        
                      <div class="col-md-3 mb-3">
                             <div class="card card-body p-3 border-0" 
                    style="background: linear-gradient(135deg, #1e0c6d 0%, #a51eb1 100%); color: white;">
                            <p class="text-sm mb-0 text-capitalize">Total Income</p>
                          <?php 
                                // This is for Total income    
                                    $totalIncomeQuery = mysqli_query($conn, "SELECT SUM(total_amount) AS total_income FROM orders");
                                    
                                    if($totalIncomeQuery) {
                                        $row = mysqli_fetch_assoc($totalIncomeQuery);
                                        $overallIncome = $row['total_income'];
                                        
                                        
                                        echo $overallIncome > 0 ? number_format($overallIncome, 2) : "0.00";
                                    } else {
                                        
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                ?>
                                <p class="text-sm mb-0 text-capitalize">Company Total Income</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                             <div class="card card-body p-3 border-0" 
                    style="background: linear-gradient(135deg, #2f12af 0%, #9f83a1 100%); color: white;">
                            <p class="text-sm mb-0 text-capitalize">Total Income-This Month</p>


                    <?php 
                    $currentMonth = date('m');
                    $currentYear = date('Y');

                    // Query to sum totals where month and year match today
                    $monthlyQuery = "SELECT SUM(total_amount) AS monthly_total FROM orders 
                                    WHERE MONTH(order_date) = '$currentMonth' 
                                    AND YEAR(order_date) = '$currentYear'";
                    
                    $monthlyResult = mysqli_query($conn, $monthlyQuery);
                    
                    if($monthlyResult) {
                        $row = mysqli_fetch_assoc($monthlyResult);
                        $monthlyIncome = $row['monthly_total'];
                        
                        echo $monthlyIncome > 0 ? number_format($monthlyIncome, 2) : "0.00";
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                ?>

                <p class="text-sm mb-0 text-capitalize">Company Total Income-This Month</p>

    </div>                 
</div>


<!-- for charts -->
 <div class="col-md-12 mb-3">
                <hr>
                <h4>Charts</h4>
                    </div>
 <div class="container-fluid px-4">
 <div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header" style="background: linear-gradient(135deg, #1e0c6d 0%, #a51eb1 100%); color: white;"><i class="fas fa-chart-area me-1"></i> Daily Sales (Last 7 Days)</div>
            <div class="card-body"><canvas id="dailySalesChart" width="100%" height="80"></canvas></div>
        </div>
    </div>
    

    <div class="col-md-4">
        <div class="card mb-2">
            <div class="card-header" style="background: linear-gradient(135deg, #1e0c6d 0%, #a51eb1 100%); color: white;"><i class="fas fa-chart-bar me-1"></i> Monthly Sales Revenue</div>
            <div class="card-body"><canvas id="monthlySalesChart" width="100%" height="80"></canvas></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header" style="background: linear-gradient(135deg, #1e0c6d 0%, #a51eb1 100%); color: white;"><i class="fas fa-chart-pie me-1"></i> Top 5 Selling Items</div>
            <div class="card-body"><canvas id="topItemsPieChart" width="100%" height="60"></canvas></div>
        </div>
    </div>
</div>



    </div>
</div>
</div>


<!-- for charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// --- Daily Sales (Line Chart) ---
new Chart(document.getElementById("dailySalesChart"), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($days); ?>,
        datasets: [{
            label: "Sales Amount",
            data: <?php echo json_encode($d_amounts); ?>,
            borderColor: "rgba(2,117,216,1)",
            backgroundColor: "rgba(2,117,216,0.1)",
            fill: true
        }]
    }
});

// --- Monthly Sales (Bar Chart) ---
new Chart(document.getElementById("monthlySalesChart"), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
            label: "Revenue",
            backgroundColor: "rgba(2,117,216,1)",
            data: <?php echo json_encode($m_amounts); ?>,
        }]
    }
});

// --- Top 5 Items (Pie Chart) ---
new Chart(document.getElementById("topItemsPieChart"), {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($items); ?>,
        datasets: [{
            data: <?php echo json_encode($item_qty); ?>,
            backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745', '#17a2b8'],
        }]
    }
});
</script>

<!-- low stock maintain  here -->






<div class="container-fluid px-4">
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i> Low Stock Alerts</h5>
                    
                    <div class="d-flex align-items-center gap-2">
                        <form action="code.php" method="POST" class="d-flex align-items-center bg-white rounded p-1">
                            <label class="text-dark small fw-bold px-2 mb-0">Threshold:</label>
                            <input type="number" name="low_stock_limit" 
                                value="<?= $lowStockThreshold; ?>" 
                                class="form-control form-control-sm border-0" 
                                style="width: 60px;" min="1">
                            <button type="submit" name="save_threshold" class="btn btn-sm btn-dark ms-1">Set</button>
                        </form>
                        <span class="badge bg-white text-danger">Action Required</span>
                    </div>
                </div>
            
        
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th class="text-center">Current Stock</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        
                           <?php
                                    // Threshold: Items with 10 or less in stock
                                    $lowStockThreshold = 15;

  

                                            // 2. Check if user has saved a custom value in the database (Recommended)
                                            // $settingQuery = mysqli_query($conn, "SELECT value FROM settings WHERE name='low_stock_limit'");
                                            // $setting = mysqli_fetch_assoc($settingQuery);
                                            // $lowStockThreshold = $setting['value'];

                                            // 3. For immediate testing, you can use a session:
                                            if(isset($_SESSION['low_stock_limit'])) {
                                                $lowStockThreshold = $_SESSION['low_stock_limit'];
                                            }


                                    // Corrected query using 'cat_name' from your categories table
                                    $lowStockQuery = "SELECT 
                                                        p.id, 
                                                        p.prod_name, 
                                                        p.quantity, 
                                                        c.cat_name 
                                                    FROM products p 
                                                    JOIN categories c ON c.id = p.category_id 
                                                    WHERE p.quantity <= $lowStockThreshold 
                                                    ORDER BY p.quantity ASC";

                                    $lowStockRes = mysqli_query($conn, $lowStockQuery);
                                    

                            if(mysqli_num_rows($lowStockRes) > 0):
                                while($product = mysqli_fetch_assoc($lowStockRes)):
                            ?>
                                <tr>
                                    <td class="fw-bold"><?= $product['prod_name']; ?></td>
                                    <td><?= $product['cat_name']; ?></td>
                                    <td class="text-center">
                                        <span class="badge <?= $product['quantity'] <= 5 ? 'bg-danger' : 'bg-warning text-dark'; ?> rounded-pill">
                                            <?= $product['quantity']; ?> Left
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if($product['quantity'] == 0): ?>
                                            <small class="text-danger fw-bold">Out of Stock</small>
                                        <?php else: ?>
                                            <small class="text-muted">Reorder Soon</small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <a href="products-edit.php?id=<?= $product['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Restock
                                        </a>
                                    </td>
                                </tr>
                            <?php 
                                endwhile;
                            else:
                            ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fas fa-check-circle text-success fa-2x mb-2"></i><br>
                                        All products are well stocked!
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



<?php include("includes/footer.php");  ?>  