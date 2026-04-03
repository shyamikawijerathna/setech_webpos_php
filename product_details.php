<?php include "includes_web/header.php"; ?>
<?php include "includes_web/navbar.php"; ?>
<?php include "config/dbcon.php"; ?>
<?php include "config/function.php"; ?>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = null;

if ($id > 0) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ? AND (deleted_at IS NULL OR deleted_at = '') LIMIT 1");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    }
    mysqli_stmt_close($stmt);
}
?>

<!--Breadcrumbs -->
<div class="container mt-4">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Product Details</li>
    </ol>
    </nav>
</div>

<section class="section">
    <?php if ($product): ?>
        <h2 style="margin-left:200px;"><?= htmlspecialchars($product['prod_name']) ?></h2>

        <div style="display:flex; gap:40px; flex-wrap:wrap; margin-left:50px; justify-content:center; max-width:calc(100% - 100px);">
            <?php
                // Ensure path resolution from current directory
                $defaultImage = 'src_web/img/featured1.jpg';
                $imagePath = $defaultImage;
                if (!empty($product['image'])) {
                    $storedPath = $product['image'];
                    $absolutePath = __DIR__ . '/' . $storedPath;
                    if (file_exists($absolutePath)) {
                        $imagePath = $storedPath;
                    }
                }
            ?>
            <img src="<?= $imagePath ?>" style="width:350px; border-radius:12px;" alt="<?= htmlspecialchars($product['prod_name']) ?>">

            <div>
                <h3>Price: Rs.<?= number_format((float)$product['sale_price'], 2) ?></h3>
                <p><strong>Category:</strong> <?= htmlspecialchars($product['cat_name']) ?></p>
                <p style="max-width:500px;"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

                <h6>Cash on Delivery( COD ) Available for limited products only.Contact us for more details.</h6>

                <a class="btn btn-primary" style="margin-top:20px;" href="cart.php?id=<?= $product['id'] ?>">Add to Cart</a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">Product not found or invalid ID.</div>
    <?php endif; ?>
</section>


