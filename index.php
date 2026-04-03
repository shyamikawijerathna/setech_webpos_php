<?php include("includes_web/header.php"); 
      include("includes_web/navbar.php");    
      include("config/dbcon.php");
      include("config/function.php");

     
    ?>

    <main>
        <!--Breadcrumbs -->
        <div class="container mt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                </ol>
            </nav>
        </div>
<!-- carousel -->
        <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="3"></button>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="4"></button>
            </div>

            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="3000">
                    <a href="phone_spare_parts.php">
                    <img src="src_web/img/Banner_phone_display1.png" class="d-block w-100" alt="Slide 1">
                    
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <a href="desktop_pc_accessories.php">
                    <img src="src_web/img/Banner_desktop_Accessories.png" class="d-block w-100" alt="Slide 2">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <a href="laptop_accessories.php">
                    <img src="src_web/img/Banner_laptop_accessories.png" class="d-block w-100" alt="Slide 3">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <a href="phone_spare_parts.php">
                    <img src="src_web/img/Banner_batteries.png" class="d-block w-100" alt="Slide 4">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <a href="phone_accessories.php">
                    <img src="src_web/img/Banner_cables_accessories.png" class="d-block w-100" alt="Slide 5">
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>


        <section class="container py-3 text-center">
            <div class="row g-3 align-items-stretch">
                <div class="col-md-4 mb-4">
                    <div class="card h-90 shadow-sm">
                        <img src="src_web/img/Saleimgone.jpg" class="card-img-top" alt="Phone Accessories">
                        <div class="card-body">
                            <a href="phone_spare_parts.php" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-90 shadow-sm">
                        <img src="src_web/img/Saleimgtwo.jpg" style="height:265px;" class="card-img-top" alt="Desktop Accessories">
                        <div class="card-body">
                            <h5 class="card-title">Special Offer - Brand New / Used</h5>
                            <p class="card-text">Build Your Dream PC with our exclusive deals. Limited time offer!</p>
                            <a href="desktop_pc_accessories.php" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>

                 <div class="col-md-4 mb-4">
                    <div class="card h-90 shadow-sm">
                        <img src="src_web/img/Saleimgthree.jpg" style="height:265px;"class="card-img-top" alt="Laptop Accessories">
                        <div class="card-body">
                            <h5 class="card-title">Special Offer - Brand New / Used</h5>
                            <p class="card-text">Buy Your Dream Laptop with our exclusive deals. Limited time offer!</p>
                            <a href="laptop_used.php" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <div class="container-fluid" style="height: 100px; background-color: #6be47b;">
                    <div class="row h-100 align-items-center text-center">
                        
                        <div class="col-4 d-flex flex-column align-items-center justify-content-center border-end border-white">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2d5a27" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/></svg>
                            <span class="fw-bold text-dark" style="font-size: 0.9rem;">Certified Warranty</span>
                        </div>

                        <div class="col-4 d-flex flex-column align-items-center justify-content-center border-end border-white">
                            <svg  width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2d5a27" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1"><rect x="1" y="3" width="15" height="13"/><polyline points="16 8 20 8 23 11 23 16 16 16"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                            <span class="fw-bold text-dark" style="font-size: 0.9rem;">Fast Shipping with COD</span>
                        </div>

                        <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                            <svg  width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2d5a27" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l2.27-2.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <span class="fw-bold text-dark" style="font-size: 0.9rem;">Best After Service</span>
                        </div>

                    </div>
        </div>

             <!-- Fetch Today's Deal products (by category name) -->
  <?php    $todayDealCategory = 'Today Deals';
      $safeTodayDealCategory = mysqli_real_escape_string($conn, $todayDealCategory);
      $todayDealProducts = mysqli_query($conn, "SELECT * FROM products WHERE cat_name = '$safeTodayDealCategory' AND status = 1 AND (deleted_at IS NULL OR deleted_at = '') ORDER BY id DESC LIMIT 6");

      ?>
        <div class="container py-5">
            <h2 class="text-right mb-4">Today's Deal</h2>
            <div class="row">
                <?php if($todayDealProducts && mysqli_num_rows($todayDealProducts) > 0): ?>
                    <?php while($deal = mysqli_fetch_assoc($todayDealProducts)): ?>
                        <?php
                            $imagePath = !empty($deal['image']) && file_exists($deal['image']) ? $deal['image'] : 'src_web/img/featured1.jpg';
                            $productTitle = htmlspecialchars($deal['prod_name']);
                            $productPrice = number_format((float)$deal['sale_price'], 2);
                        ?>
                        <div class="col-md-2 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="<?= $imagePath; ?>" class="card-img-top" alt="<?= $productTitle; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $productTitle; ?></h5>
                                    <p class="card-text">Rs. <?= $productPrice; ?></p>
                                    <a href="product_details.php?id=<?= $deal['id']; ?>" class="btn btn-outline-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">No products found in the Today Deal category. Please add products with category <strong>Today Deal</strong> in admin.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="container-fluid" style="height: 350px; background-color: #e6dc54;">
                    <div class="row h-100 align-items-center justify-content-center">
                        
                        <div class="col-md-8 d-flex justify-content-around align-items-center">
                            <img src="src_web/img/ram.jpg" alt="Product 1" class="img-fluid" style="max-height: 200px;">
                            <img src="src_web/img/ssd.jpg" alt="Product 2" class="img-fluid" style="max-height: 200px;">
                            <img src="src_web/img/ps.jpg" alt="Product 3" class="img-fluid" style="max-height: 200px;">
                        </div>

                        <div class="col-md-2 text-center">
                            <a href="desktop_pc_accessories.php" class="btn btn-dark btn-md px-4 py-3 fw-bold rounded-pill shadow">
                                SHOP NOW
                            </a>
                        </div>

                    </div>
                </div>

                              <!-- Fetch Trending products (by category name) -->
                    <?php    $trendingCategory = 'Trending on';
                    $safeTrendingCategory = mysqli_real_escape_string($conn, $trendingCategory);
                    $trendingProducts = mysqli_query($conn, "SELECT * FROM products WHERE cat_name = '$safeTrendingCategory' AND status = 1 AND (deleted_at IS NULL OR deleted_at = '') ORDER BY id DESC LIMIT 6");

                    ?>


                <div class="container py-5">
                        <h2 class="text-right mb-4">Trending Products</h2>
                        <div class="row">
                            <?php if($trendingProducts && mysqli_num_rows($trendingProducts) > 0): ?>
                                <?php while($trend = mysqli_fetch_assoc($trendingProducts)): ?>
                                    <?php
                                        $imagePath = !empty($trend['image']) && file_exists($trend['image']) ? $trend['image'] : 'src_web/img/featured1.jpg';
                                        $productTitle = htmlspecialchars($trend['prod_name']);
                                        $productPrice = number_format((float)$trend['sale_price'], 2);
                                    ?>
                                    <div class="col-md-2 mb-4">
                                        <div class="card h-100 shadow-sm">
                                            <img src="<?= $imagePath; ?>" class="card-img-top" alt="<?= $productTitle; ?>">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $productTitle; ?></h5>
                                                <p class="card-text">Rs. <?= $productPrice; ?></p>
                                                <a href="product_details.php?id=<?= $trend['id']; ?>" class="btn btn-outline-primary">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="col-12">
                                    <div class="alert alert-info">No products found in the Today Deal category. Please add products with category <strong>Today Deal</strong> in admin.</div>
                                </div>
                            <?php endif; ?>
                        </div>
                </div>     


            
    </main>


  <?php  include("includes_web/footer.php");  ?>