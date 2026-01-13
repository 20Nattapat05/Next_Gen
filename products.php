<?php

require_once __DIR__ . '/function/shared/common_function.php';

// Initialize session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine user type and check permissions
$isAdmin = isset($_SESSION['admin_id']);
$isUser = isset($_SESSION['user_id']);
$isGuest = !$isAdmin && !$isUser;

// Prevent admin from accessing user page
if ($isAdmin) {
    header('Location: /Next_Gen/admin_home');
    exit();
}

// Get all products
$all_products = GetAllProducts();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | Next Gen IT</title>
    <?php include('include/header.php') ?>
</head>

<body class="bg-dark">

    <?php include('include/navbar.php') ?>

    <div class="container">

        <!-- หัวข้อ -->
        <div class="d-flex justify-content-between align-items-center mb-4 mt-custom">
            <h3 class="text-main mb-0">| รายการสินค้า</h3>
        </div>

        <!-- Filter + Search + Sort -->
        <form method="get" class="mb-4">
            <div class="row g-2">

                <!-- ช่องค้นหา -->
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="search" name="q" class="form-control" placeholder="ค้นหาสินค้า..."
                            aria-label="ค้นหาสินค้า">
                        <button class="btn btn-main" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

            </div>
        </form>

        <!-- สินค้า -->
        <div class="row">
            <?php if (!empty($all_products)): ?>
                <?php foreach ($all_products as $product): ?>
                    <?php
                    $original_price = $product['product_price'];
                    $discount = $product['event_discount'] ?? 0;
                    $final_price = $original_price - $discount;
                    $has_discount = ($discount > 0);
                    $stock = $product['product_qty'];
                    ?>
                    <div class="col-md-3 mb-4">
                        <div class="card border-0 shadow-sm h-100 card-product position-relative overflow-hidden">

                            <?php if (!empty($product['event_name'])): ?>
                                <!-- Badge เข้าร่วมแคมเปญ -->
                                <span class="position-absolute top-0 end-0 m-2 badge bg-danger shadow-sm" style="z-index: 1;">
                                    <i class="bi bi-tag-fill me-1"></i> <?php echo $product['event_name']; ?>
                                </span>
                            <?php endif; ?>

                            <img src="assets/images/product/<?php echo $product['product_picture'] ?>"
                                class="w-100 object-fit-cover"
                                style="height: 240px;"
                                alt="<?php echo $product['product_name']; ?>">
                            
                            <div class="card-body d-flex flex-column">
                                <h6 class="fw-bold mb-1 text-truncate"><?php echo $product['product_name']; ?></h6>
                                
                                <!-- ราคา -->
                                <div class="mb-2">
                                    <?php if ($has_discount): ?>
                                        <p class="text-main fw-semibold mb-0">฿<?php echo number_format($final_price, 2); ?></p>
                                        <small class="text-muted text-decoration-line-through">฿<?php echo number_format($original_price, 2); ?></small>
                                    <?php else: ?>
                                        <p class="text-main fw-semibold mb-0">฿<?php echo number_format($original_price, 2); ?></p>
                                    <?php endif; ?>
                                </div>

                                <!-- สถานะสินค้า -->
                                <small class="text-muted d-block mb-2">
                                    <i class="bi bi-box-seam me-1"></i>
                                    <span class="<?php echo $stock <= 5 ? 'text-danger fw-bold' : ''; ?>">
                                        คงเหลือ <?php echo $stock; ?> ชิ้น
                                    </span>
                                </small>

                                <div class="mt-auto">
                                    <?php if ($isUser): ?>
                                        <a href="cart_action.php?action=add&id=<?php echo $product['product_id']; ?>"
                                            class="btn btn-main w-50 float-end btn-sm">
                                            เพิ่มลงตะกร้า <i class="bi bi-cart-plus"></i>
                                        </a>
                                    <?php else: ?>
                                        <button onclick="location.href='login.php';" class="btn btn-outline-secondary w-50 btn-sm">
                                            <i class="bi bi-lock-fill"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        ไม่มีสินค้าในขณะนี้
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include('include/footer.php') ?>

</body>

</html>