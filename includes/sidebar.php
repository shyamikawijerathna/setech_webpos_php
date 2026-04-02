<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>

                    <div class="sb-sidenav-menu-heading">Interface</div>
                    
                    <?php if($_SESSION['loggedInUser']['role_level'] == 1 || $_SESSION['loggedInUser']['role_level'] == 3): ?>
                    <a class="nav-link" href="orders-create.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                        Create Order
                    </a>
                    <?php endif; ?>

                    <?php if($_SESSION['loggedInUser']['role_level'] <= 2): ?>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInventory" aria-expanded="false" aria-controls="collapseInventory">
                        <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                        Inventory
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseInventory" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="products-create.php">Add Product</a>
                            <a class="nav-link" href="products.php">View Products</a>
                            <a class="nav-link" href="categories.php">Categories</a>
                        </nav>
                    </div>
                    <?php endif; ?>

                    <?php if($_SESSION['loggedInUser']['role_level'] == 1): ?>
                    <div class="sb-sidenav-menu-heading">Administration</div>
                    <a class="nav-link" href="admins.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                        Manage Staff
                    </a>
                    <a class="nav-link" href="settings.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                        Settings
                    </a>
                    <?php endif; ?>

                    <?php if($_SESSION['loggedInUser']['role_level'] <= 2): ?>
                    <div class="sb-sidenav-menu-heading">Addons</div>
                    <a class="nav-link" href="sales-report.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Sales Report
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <span class="badge <?php 
                    if($_SESSION['loggedInUser']['role_level'] == 1) echo 'bg-danger';
                    elseif($_SESSION['loggedInUser']['role_level'] == 2) echo 'bg-warning text-dark';
                    else echo 'bg-success';
                ?>">
                    <?php 
                        if($_SESSION['loggedInUser']['role_level'] == 1) echo 'Super Admin';
                        elseif($_SESSION['loggedInUser']['role_level'] == 2) echo 'Inventory';
                        else echo 'Cashier';
                    ?>
                </span>
                <div class="mt-1"><?= $_SESSION['loggedInUser']['name']; ?></div>
            </div>
        </nav>
    </div>
</div>