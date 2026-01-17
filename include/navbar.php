<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine user type
$isAdmin = isset($_SESSION['admin_id']);
$isUser = isset($_SESSION['user_id']);
$isGuest = !$isAdmin && !$isUser;

// Security: Prevent admin from using user navbar
if ($isAdmin) {
    header('Location: /Next_Gen/admin_home');
    exit();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow py-3 fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-banner" href="#">NEXT GEN IT</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link mx-1" href="/Next_Gen/">หน้าแรก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-1" href="products">รายการสินค้า</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-1" href="contact">ติดต่อเรา</a>
                </li>

                <?php if ($isUser): ?>
                <!-- Show cart and order history -->
                <li class="nav-item">
                    <a class="nav-link mx-1" href="cart.php">
                        <i class="bi bi-cart-fill"></i> ตะกร้า
                    </a>
                </li>

                <!-- Account button for logged in users -->
                <li class="nav-item">
                    <a class="btn btn-main ms-1" href="account"><i class="bi bi-person"></i> บัญชีของฉัน</a>
                </li>
                <?php elseif ($isGuest): ?>
                <!-- Login button for guests -->
                <li class="nav-item">
                    <a class="btn btn-main ms-1" href="login"><i class="bi bi-box-arrow-in-right"></i> เข้าสู่ระบบ</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>