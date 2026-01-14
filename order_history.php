<?php

require_once __DIR__ . '/function/user/order_function.php';

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
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : null;

// Get orders
$limit = 10;
$offset = ($page - 1) * $limit;
$orders = GetOrders($user_id, $limit, $offset);
$order_count = GetOrderCount($user_id);
$total_pages = ceil($order_count / $limit);

// Get order detail if specified
$order_detail = null;
$order_items = null;
if ($order_id) {
    $order_detail = GetOrderDetail($order_id, $user_id);
    if ($order_detail) {
        $order_items = GetOrderItems($order_id);
    }
}

// Status colors
$status_colors = [
    'pending' => '#ffcc00',
    'confirmed' => '#0099cc',
    'shipped' => '#00ccff',
    'delivered' => '#00ff99',
    'cancelled' => '#ff6b6b'
];

$status_text = [
    'pending' => 'รอดำเนินการ',
    'confirmed' => 'ยืนยันแล้ว',
    'shipped' => 'จัดส่งแล้ว',
    'delivered' => 'ส่งถึงแล้ว',
    'cancelled' => 'ยกเลิกแล้ว'
];

$payment_colors = [
    'pending' => '#ffcc00',
    'paid' => '#00ff99',
    'failed' => '#ff6b6b'
];

$payment_text = [
    'pending' => 'รอการชำระเงิน',
    'paid' => 'ชำระแล้ว',
    'failed' => 'ชำระไม่สำเร็จ'
];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการสั่ง | Next Gen IT</title>
    <?php include('include/header.php') ?>
</head>

<body class="bg-dark">

    <?php include('include/navbar.php') ?>

    <div class="container mt-4 mb-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-main mb-0">| ประวัติการสั่ง</h3>
            <a href="products.php" class="btn btn-outline-info">
                <i class="bi bi-shop me-2"></i>ช้อปปิ้งต่อ
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Orders List -->
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="card bg-dark border-info mb-3 cursor-pointer" style="border: 2px solid; cursor: pointer;" 
                            onclick="selectOrder(<?php echo $order['order_id']; ?>)">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="text-success mb-1">#<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?></h6>
                                        <small class="text-muted"><?php echo date('d M Y H:i', strtotime($order['created_at'])); ?></small>
                                    </div>
                                    <div class="text-success fw-bold">฿<?php echo number_format($order['total_price'], 2); ?></div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <small class="text-info d-block mb-1">สถานะคำสั่ง</small>
                                        <div>
                                            <span class="badge" style="background-color: <?php echo $status_colors[$order['order_status']]; ?>; color: #000;">
                                                <?php echo $status_text[$order['order_status']]; ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <small class="text-info d-block mb-1">การชำระเงิน</small>
                                        <div>
                                            <span class="badge" style="background-color: <?php echo $payment_colors[$order['payment_status']]; ?>; color: #000;">
                                                <?php echo $payment_text[$order['payment_status']]; ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <small class="text-info d-block mb-1">จำนวนสินค้า</small>
                                        <div class="text-white"><?php echo count(GetOrderItems($order['order_id'])); ?> รายการ</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>" style="background-color: <?php echo ($i == $page) ? '#0099cc' : 'transparent'; ?>; border-color: #0099cc; color: <?php echo ($i == $page) ? '#fff' : '#0099cc'; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="card border-info text-center p-5">
                        <div class="card-body">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #0099cc; opacity: 0.5;"></i>
                            <h4 class="text-dark mt-3">ยังไม่มีประวัติการสั่ง</h4>
                            <p class="text-muted">คุณยังไม่ได้สั่งซื้อสินค้า</p>
                            <a href="products.php" class="btn btn-primary mt-3">
                                <i class="bi bi-shop me-2"></i>เริ่มช้อปปิ้ง
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Order Detail -->
            <div class="col-lg-4">
                <?php if ($order_detail && $order_items): ?>
                    <div class="card border-info sticky-top" style="top: 100px;">
                        <div class="card-body">
                            <h5 class="text-success mb-3">📋 รายละเอียดคำสั่ง</h5>

                            <div class="mb-3">
                                <small class="text-info d-block mb-1">เลขที่คำสั่ง</small>
                                <div class="text-white fw-bold">#<?php echo str_pad($order_detail['order_id'], 6, '0', STR_PAD_LEFT); ?></div>
                            </div>

                            <div class="mb-3">
                                <small class="text-info d-block mb-1">วันที่สั่ง</small>
                                <div class="text-muted"><?php echo date('d M Y H:i:s', strtotime($order_detail['created_at'])); ?></div>
                            </div>

                            <hr style="border-color: #0099cc; opacity: 0.3;">

                            <h6 class="text-success mb-2">🛍️ สินค้า</h6>
                            <div style="max-height: 300px; overflow-y: auto;">
                                <?php foreach ($order_items as $item): ?>
                                    <div class="card bg-secondary mb-2" style="border: none;">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <p class="text-white mb-1 fw-600" style="font-size: 0.95rem;">
                                                        <?php echo htmlspecialchars($item['product_name']); ?>
                                                    </p>
                                                    <small class="text-muted">
                                                        <?php echo $item['quantity']; ?> ชิ้น × ฿<?php echo number_format($item['price_per_unit'], 2); ?>
                                                    </small>
                                                </div>
                                                <div class="text-success fw-bold" style="font-size: 0.95rem;">
                                                    ฿<?php echo number_format(($item['price_per_unit'] - $item['discount_per_unit']) * $item['quantity'], 2); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <hr style="border-color: #0099cc; opacity: 0.3;">

                            <div class="d-flex justify-content-between align-items-center text-muted mb-3">
                                <span>รวมทั้งสิ้น:</span>
                                <span class="text-success fw-bold" style="font-size: 1.3rem;">
                                    ฿<?php echo number_format($order_detail['total_price'], 2); ?>
                                </span>
                            </div>

                            <a href="checkout.php" class="btn btn-primary w-100" style="display: none;">
                                <i class="bi bi-cart-check me-2"></i>สั่งซื้ออีกครั้ง
                            </a>
                        </div>
                    </div>
                <?php elseif ($order_detail === null && $order_id): ?>
                    <div class="card border-info">
                        <div class="card-body text-center text-muted">
                            ไม่พบข้อมูลคำสั่งซื้อ
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card border-info">
                        <div class="card-body text-center text-muted">
                            เลือกคำสั่งเพื่อดูรายละเอียด
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function selectOrder(orderId) {
            window.location.href = '?order_id=' + orderId;
        }
    </script>

    <?php include('include/footer.php') ?>

</body>

</html>
