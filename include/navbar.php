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
                <li class="nav-item">
                    <a class="nav-link mx-1" href="order_history.php">
                        <i class="bi bi-receipt"></i> ประวัติการสั่ง
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

<div class="modal fade" id="cart">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🛒 ตะกร้าสินค้า</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>สินค้า</th>
                            <th>ราคา</th>
                            <th>จำนวน</th>
                            <th>รวม</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>เสื้อยืด</td>
                            <td>250</td>
                            <td>
                                <span class="badge bg-main">1</span>
                            </td>
                            <td>250</td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger">ลบ</button>
                            </td>
                        </tr>

                        <tr>
                            <td>กางเกงยีนส์</td>
                            <td>890</td>
                            <td>
                                <span class="badge bg-main">2</span>
                            </td>
                            <td>1780</td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger">ลบ</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <h5 class="mb-0">รวมทั้งหมด: <strong>2,000</strong> บาท</h5>
                <button class="btn btn-success">ชำระเงิน</button>
            </div>

        </div>
    </div>
</div>