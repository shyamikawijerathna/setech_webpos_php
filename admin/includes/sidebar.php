 
 <?php 
 
    $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/")+1);
 ?>

 
 
 
 
 <div id="layoutSidenav_nav" style="background: linear-gradient(135deg, #0d4a5e 0%, #5dcaee 100%)">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <img src="../assets/uploads/products/mdm_logo.jpeg" alt="Logo" style="width: 210px; height: 100px; margin-bottom: 5px;">

                            <!-- <div class="sb-sidenav-menu-heading">Interface</div> -->
                            <a class="nav-link <?= $page == 'index.php' ? 'active':''; ?>" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>

                            <a class="nav-link <?= $page == 'order-create.php' ? 'active':''; ?>" href="order-create.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cart-plus"></i></div>
                                Create Order
                            </a>

                            <a class="nav-link <?= $page == 'orders.php' ? 'active':''; ?>" href="orders.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                Orders
                            </a>

                            <a class="nav-link <?= $page == 'quotation-create.php' ? 'active':''; ?>" href="quotation-create.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-file"></i></div>
                                Create Quotation
                            </a>

                                <!-- <div class="sb-sidenav-menu-heading">Stores</div> -->
                            <a class="nav-link <?= ($page == 'stores-create.php') || ($page == 'stores.php') ? 'collapse active':'collapsed'; ?>"
                           
                            
                            href="#"
                             data-bs-toggle="collapse" 
                             data-bs-target="#collapseStores" aria-expanded="false" aria-controls="collapseStores">
                                <div class="sb-nav-link-icon"><i class="fas fa-plus-circle"></i></div>
                                Stores
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse  <?= ($page == 'stores-create.php') || ($page == 'stores.php') ? 'collapse active':'collapsed'; ?>"

                                id="collapseStores" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= $page == 'stores-create.php' ? 'active':''; ?>" href="stores-create.php">Create Store</a>
                                    <a class="nav-link <?= $page == 'stores.php' ? 'active':''; ?>" href="stores.php">View Stores</a>
                                </nav>
                            </div>
                           
                            <!-- <div class="sb-sidenav-menu-heading">Categories</div> -->
                            <a class="nav-link <?= ($page == 'categories-create.php') || ($page == 'categories.php') ? 'collapse active':'collapsed'; ?>"
                           
                            
                            href="#"
                             data-bs-toggle="collapse" 
                             data-bs-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
                                <div class="sb-nav-link-icon"><i class="fas fa-plus-circle"></i></div>
                                Categories
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse  <?= ($page == 'categories-create.php') || ($page == 'categories.php') ? 'collapse active':'collapsed'; ?>"

                                id="collapseCategory" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= $page == 'categories-create.php' ? 'active':''; ?>" href="categories-create.php">Create Category</a>
                                    <a class="nav-link <?= $page == 'categories.php' ? 'active':''; ?>" href="categories.php">View Categories</a>
                                </nav>
                            </div>

                            <!-- <div class="sb-sidenav-menu-heading">Products</div> -->
                            <a class="nav-link <?= ($page == 'products-create.php') || ($page == 'products.php') ? 'collapse active':'collapsed'; ?>"
                           
                            
                            href="#"
                             data-bs-toggle="collapse" 
                             data-bs-target="#collapseProduct" aria-expanded="false" aria-controls="collapseProduct">
                                <div class="sb-nav-link-icon"><i class="fas fa-cubes"></i></div>
                                Products
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse <?= ($page == 'products-create.php') || ($page == 'products.php') ? 'collapse active':'collapsed'; ?>" 
                            id="collapseProduct" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= $page == 'products-create.php' ? 'active':''; ?>" href="products-create.php">Create Product</a>
                                    <a class="nav-link <?= $page == 'products.php' ? 'active':''; ?>" href="products.php">View Products</a>
                                </nav>
                            </div>
                            
                              
                            <!-- <div class="sb-sidenav-menu-heading">Manage Users</div> -->
                            <a class="nav-link <?= ($page == 'admins-create.php') || ($page == 'admins.php') ? 'collapse active':'collapsed'; ?>"
                            
                            href="#" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseAdmins" 
                            aria-expanded="false" aria-controls="collapseAdmins">

                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Admins/Staff
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse <?= ($page == 'admins-create.php') || ($page == 'admins.php') ? 'collapse active':'collapsed'; ?>"
                            id="collapseAdmins" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= $page == 'admins-create.php' ? 'active':''; ?>" href="admins-create.php">Add Admin</a>
                                    <a class="nav-link <?= $page == 'admins.php' ? 'active':''; ?>" href="admins.php">View Admins</a>
                                </nav>
                            </div>
                            <!-- <div class="sb-sidenav-menu-heading">Manage Customers & Suppliers</div> -->
                                <a class="nav-link <?= ($page == 'customers-create.php') || ($page == 'customers.php') ? 'collapse active':'collapsed'; ?>"
                                
                                href="#" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapseCustomers" 
                                aria-expanded="false" aria-controls="collapseCustomers">

                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Customers
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse <?= ($page == 'customers-create.php') || ($page == 'customers.php') ? 'collapse active':'collapsed'; ?>"
                                id="collapseCustomers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= $page == 'customers-create.php' ? 'active':''; ?>" href="customers-create.php">Add Customer</a>
                                    <a class="nav-link <?= $page == 'customers.php' ? 'active':''; ?>" href="customers.php">View Customers</a>
                                </nav>
                                </div>

                                <!-- supplier menu -->

                                <a class="nav-link <?= ($page == 'suppliers-create.php') || ($page == 'suppliers.php') ? 'collapse active':'collapsed'; ?>"
                             

                                href="#" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapseSuppliers" 
                                aria-expanded="false" aria-controls="collapseSuppliers">

                                <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                                Suppliers
                                
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse <?= ($page == 'suppliers-create.php') || ($page == 'suppliers.php') ? 'collapse active':'collapsed'; ?>"
                                id="collapseSuppliers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= $page == 'suppliers-create.php' ? 'active':''; ?>" href="suppliers-create.php">Add Supplier</a>
                                    <a class="nav-link <?= $page == 'suppliers.php' ? 'active':''; ?>" href="suppliers.php">View Suppliers</a>
                                </nav>

                            
                            </div>
                                <!-- reports & Analytics -->
                                 <a class="nav-link <?= $page == 'reports.php' ? 'active':''; ?>" href="reports.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                    Reports & Analytics
                                </a>
                                
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer" style="background: #0d4a5e ">
                        
                        <div class="small">Logged in as:</div>
                        <?= $_SESSION['loggedInUser']['name'] ?? 'User'; ?>
                    </div>
                </nav>
            </div>