<?php
include "includes_web/header.php";
include "includes_web/navbar.php";
include "config/dbcon.php";
include "config/function.php";

$allowedCategories = [
    'phone chargers',
    'phone cables',
    'phone earbuds',
    'phone handsfrees',
    'phone tempered glasses',
    'phone back covers',
    'phone otgs'
];

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$selectedCategory = isset($_GET['category']) ? trim($_GET['category']) : '';

$whereClauses = ["(deleted_at IS NULL OR deleted_at = '')"];

// Restrict to only phone spare related categories
$escapedAllowedCategories = array_map(function($cat) use ($conn) {
    return mysqli_real_escape_string($conn, $cat);
}, $allowedCategories);
$whereClauses[] = "cat_name IN ('" . implode("','", $escapedAllowedCategories) . "')";

// --- Use safe category filter if provided ---
if ($selectedCategory !== '' && in_array($selectedCategory, $allowedCategories)) {
    $whereClauses[] = "cat_name = '" . mysqli_real_escape_string($conn, $selectedCategory) . "'";
}

if ($searchTerm !== '') {
    $searchEscaped = mysqli_real_escape_string($conn, $searchTerm);
    $whereClauses[] = "prod_name LIKE '%$searchEscaped%'";
}

$whereSql = '';
if (count($whereClauses) > 0) {
    $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
}

$query = "SELECT * FROM products $whereSql ORDER BY cat_name ASC, prod_name ASC";
$result = mysqli_query($conn, $query);

$groupedProducts = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cat = strtolower(trim($row['cat_name']));
        if (!isset($groupedProducts[$cat])) {
            $groupedProducts[$cat] = [];
        }
        $groupedProducts[$cat][] = $row;
    }
}

function safeImagePath($path) {
    $default = 'src_web/img/featured1.jpg';
    if (empty($path)) {
        return $default;
    }

    // Ensure path is resolved from this file's folder
    $fullPath = __DIR__ . '/' . $path;
    if (file_exists($fullPath)) {
        return $path;
    }
    return $default;
}
?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Phone Accessories</li>
    </ol>
    </nav>
</div>

<div class="container mt-4">
    <h1>Phone Accessories</h1>

    <form method="GET" class="row gy-2 gx-2 align-items-end mb-4">
        <div class="col-md-5">
            <label class="form-label">Search product name</label>
            <input type="text" name="search" value="<?= htmlspecialchars($searchTerm) ?>" class="form-control" placeholder="Search by product name">
        </div>
        <div class="col-md-4">
            <label class="form-label">Category</label>
            <select name="category" class="form-select">
                <option value="">All Phone Categories</option>
                <?php foreach ($allowedCategories as $catOption): ?>
                    <option value="<?= htmlspecialchars($catOption) ?>" <?= ($selectedCategory === $catOption ? 'selected' : '') ?>><?= ucfirst($catOption) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="phone_spare_parts.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <?php if (!empty($groupedProducts)): ?>
        <?php foreach ($allowedCategories as $catName): ?>
            <?php if (!empty($groupedProducts[$catName])): ?>
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h4 class="mb-0"><?= ucfirst($catName) ?> (<?= count($groupedProducts[$catName]) ?>)</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <?php foreach ($groupedProducts[$catName] as $product): ?>
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="card h-100 shadow-sm">
                                        <a href="product_details.php?id=<?= intval($product['id']) ?>" class="text-decoration-none text-dark">
                                            <?php $image = safeImagePath($product['image']); ?>
                                            <img src="<?= htmlspecialchars($image) ?>" class="card-img-top" style="object-fit:cover;height:170px" alt="<?= htmlspecialchars($product['prod_name']) ?>">
                                            <div class="card-body p-2">
                                                <h6 class="card-title mb-1"><?= htmlspecialchars($product['prod_name']) ?></h6>
                                                <p class="card-text mb-1"><small><?= htmlspecialchars($product['description'] ?? '') ?></small></p>
                                                <p class="mb-0"><strong>Rs. <?= number_format((float)$product['sale_price'], 2) ?></strong></p>
                                                <p class="mb-0"><small>Qty: <?= intval($product['quantity']) ?></small></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info">No phone spare parts found for this filter.</div>
    <?php endif; ?>
</div>

<?php include "includes_web/footer.php"; ?>
