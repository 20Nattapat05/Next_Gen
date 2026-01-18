<?php

require_once __DIR__ . '/function/user/cart_function.php';

// Initialize session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /Next_Gen/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_total = CalculateCartTotal($user_id);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตะกร้าสินค้า | Next Gen IT</title>
    <?php include('include/header.php') ?>
</head>

<body class="bg-dark">

    <?php include('include/navbar.php') ?>

    <div class="container mt-4 mb-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-main mb-0">| ตะกร้าสินค้า</h3>
            <a href="products.php" class="btn btn-outline-info">
                <i class="bi bi-arrow-left me-2"></i>กลับไปช้อปปิ้ง
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Cart Items -->
                <?php if ($cart_total['item_count'] > 0): ?>
                    <?php foreach ($cart_total['items'] as $item): ?>
                        <div class="card mb-3" style="border: 2px solid #0099cc; background-color: #ffffff;">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="assets/images/product/<?php echo htmlspecialchars($item['picture']); ?>"
                                            alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                            class="img-fluid rounded" style="max-width: 120px; height: 120px; object-fit: cover; border: 2px solid #0099cc;">
                                    </div>
                                    <div class="col-md-5">
                                        <div>
                                            <h5 class="mb-2 fw-bold" style="color: #1a1a1a;"><?php echo htmlspecialchars($item['product_name']); ?></h5>
                                            <p class="mb-1" style="color: #555;">ราคาต่อชิ้น: <span class="fw-bold" style="color: #0099cc;">฿<?php echo number_format($item['price_per_unit'], 2); ?></span></p>
                                            <?php if ($item['discount_per_unit'] > 0): ?>
                                                <p><span class="badge bg-danger">ลด ฿<?php echo number_format($item['discount_per_unit'], 2); ?></span></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="text-center">
                                            <span class="badge bg-info text-dark" style="font-size: 1rem;">
                                                <?php echo $item['quantity']; ?> ชิ้น
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <p class="fw-bold mb-2" style="color: #0099cc; font-size: 1.1rem;">฿<?php echo number_format($item['item_total'], 2); ?></p>
                                        <button class="btn btn-sm btn-outline-danger btn-remove"
                                            data-cart-id="<?php echo $item['cart_id']; ?>">
                                            <i class="bi bi-trash"></i> ลบ
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="card border-info text-center p-5">
                        <div class="card-body">
                            <i class="bi bi-cart-x" style="font-size: 4rem; color: #0099cc; opacity: 0.5;"></i>
                            <h4 class="text-dark mt-3">ตะกร้าว่าง</h4>
                            <p class="text-muted">ไม่มีสินค้าในตะกร้าของคุณ</p>
                            <a href="products.php" class="btn btn-primary mt-3">
                                <i class="bi bi-shop me-2"></i>ไปช้อปปิ้ง
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card border-info sticky-top" style="top: 100px;">
                    <div class="card-body">
                        <h5 class="text-success mb-3">สรุปการสั่งซื้อ</h5>

                        <div class="d-flex justify-content-between pb-2 border-bottom border-info" style="opacity: 0.3;">
                            <span class="text-muted">จำนวนสินค้า:</span>
                            <span class="text-success" id="item-count"><?php echo $cart_total['item_count']; ?> รายการ</span>
                        </div>

                        <div class="d-flex justify-content-between py-2 border-bottom border-info" style="opacity: 0.3;">
                            <span class="text-muted">ราคาสินค้า:</span>
                            <span class="text-white" id="subtotal">฿<?php echo number_format($cart_total['subtotal'], 2); ?></span>
                        </div>

                        <?php if ($cart_total['total_discount'] > 0): ?>
                            <div class="d-flex justify-content-between py-2 border-bottom border-info text-success" style="opacity: 0.3;">
                                <span>ส่วนลด:</span>
                                <span>-฿<?php echo number_format($cart_total['total_discount'], 2); ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between pt-3 border-top border-info" style="border-width: 2px !important;">
                            <span class="text-success fw-bold" style="font-size: 1.3rem;">ยอดรวมทั้งสิ้น:</span>
                            <span class="text-success fw-bold" id="grand-total" style="font-size: 1.3rem;">฿<?php echo number_format($cart_total['grand_total'], 2); ?></span>
                        </div>

                        <?php if ($cart_total['item_count'] > 0): ?>
                            <button class="btn btn-primary w-100 mt-3 fw-bold" onclick="proceedToCheckout()">
                                <i class="bi bi-credit-card me-2"></i>ดำเนินการชำระเงิน
                            </button>
                            <button class="btn btn-outline-secondary w-100 mt-2 fw-bold" onclick="clearAllCart()">
                                <i class="bi bi-trash me-2"></i>ลบตะกร้าทั้งหมด
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        // Remove item
        document.querySelectorAll('.btn-remove').forEach(btn => {
            btn.addEventListener('click', function() {
                const cartId = this.dataset.cartId;
                removeCartItem(cartId);
            });
        });

        // จำนวนสินค้าในตะกร้าจะเพิ่มเมื่อกดเพิ่มสินค้าจากหน้ารายการสินค้าเท่านั้น

        function removeCartItem(cartId) {
            Swal.fire({
                title: 'ยืนยันการลบ',
                text: 'คุณต้องการลบสินค้านี้จากตะกร้าใช่หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b6b',
                cancelButtonColor: '#444',
                confirmButtonText: 'ลบ',
                cancelButtonText: 'ยกเลิก'
            }).then(result => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('cart_id', cartId);

                    fetch('router/cart.router.php?action=remove', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ผิดพลาด',
                                text: data.message,
                                confirmButtonColor: '#0099cc'
                            });
                        }
                    });
                }
            });
        }

        function clearAllCart() {
            Swal.fire({
                title: 'ยืนยันการลบ',
                text: 'คุณต้องการลบสินค้าทั้งหมดในตะกร้าใช่หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b6b',
                cancelButtonColor: '#444',
                confirmButtonText: 'ลบทั้งหมด',
                cancelButtonText: 'ยกเลิก'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch('router/cart.router.php?action=clear')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ผิดพลาด',
                                    text: data.message,
                                    confirmButtonColor: '#0099cc'
                                });
                            }
                        });
                }
            });
        }

        function proceedToCheckout() {
            window.location.href = 'checkout.php';
        }
    </script>

    <?php include('include/footer.php') ?>

</body>

</html>
