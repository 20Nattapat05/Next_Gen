<?php
require_once 'include/check_auth_admin.php';
require_once __DIR__ . '/function/user/order_function.php';
require_once __DIR__ . '/config/dbconfig.php';
$conn = db();

// Fetch orders that are paid but not yet shipped
$orders = [];
try {
    $stmt = $conn->prepare("SELECT o.order_id, o.user_id, o.total_price, o.order_status, o.payment_status, o.created_at, u.user_fullname 
                            FROM order_tb o 
                            JOIN user_tb u ON o.user_id = u.user_id
                            WHERE o.payment_status = 'paid' AND o.order_status = 'pending'
                            ORDER BY o.created_at DESC");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $orders = [];
}

// Fetch order history
$history_date = isset($_POST['history_date']) ? $_POST['history_date'] : null;
$history_orders = GetAdminOrderHistory($history_date);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next Gen IT</title>
    <?php include('include/header.php') ?>
</head>

<body class="bg-dark">
    <?php include('include/navbar_admin.php') ?>
    <div class="container">
        <div class="row mt-custom">
            <div class="col-md-6">
                <div class="card" style="max-height: 630px; overflow-y: auto;">
                    <div class="card-body">
                        <h4>ออเดอร์เข้า</h4>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $ord): ?>
                                <div class="card shadow-sm my-2 card-admin">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-auto">
                                                <h6 class="mb-0"><?php echo htmlspecialchars($ord['user_fullname']); ?> (#<?php echo str_pad($ord['order_id'], 6, '0', STR_PAD_LEFT); ?>)</h6>
                                            </div>
                                            <div class="col-md-4 my-auto">
                                                <h6 class="mb-0"><?php echo number_format($ord['total_price'], 2); ?> บาท</h6>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#" class="btn btn-success w-100 btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal<?php echo $ord['order_id']; ?>">จัดสินค้า</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="card shadow-sm my-2 card-admin">
                                <div class="card-body text-center text-muted">ยังไม่มีออเดอร์เข้าที่ชำระแล้ว</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style="max-height: 630px; overflow-y: auto;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>ประวัติออเดอร์</h4>
                            </div>
                            <div class="col-md-4">
                                <form action="" method="post">
                                    <input type="date" name="history_date" class="form-control" onchange="this.form.submit()" value="<?php echo $history_date; ?>">
                                </form>
                            </div>
                        </div>
                        <?php if (!empty($history_orders)): ?>
                            <?php foreach ($history_orders as $h_ord): ?>
                                <div class="card shadow-sm my-2 card-admin">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 my-auto">
                                                <h6 class="mb-0"><?php echo htmlspecialchars($h_ord['user_fullname']); ?> (#<?php echo str_pad($h_ord['order_id'], 6, '0', STR_PAD_LEFT); ?>)</h6>
                                                <small class="text-muted">
                                                    <?php 
                                                    $status_map = [
                                                        'shipped' => 'จัดส่งแล้ว',
                                                        'delivered' => 'ได้รับสินค้าแล้ว', 
                                                        'cancelled' => 'ยกเลิก',
                                                        'confirmed' => 'ยืนยันแล้ว'
                                                    ];
                                                    echo isset($status_map[$h_ord['order_status']]) ? $status_map[$h_ord['order_status']] : $h_ord['order_status'];
                                                    ?>
                                                </small>
                                            </div>
                                            <div class="col-md-4 my-auto">
                                                <h6 class="mb-0"><?php echo number_format($h_ord['total_price'], 2); ?> บาท</h6>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#" class="btn btn-dark w-100 btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#historyModal<?php echo $h_ord['order_id']; ?>">เพิ่มเติม</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="card shadow-sm my-2 card-admin">
                                <div class="card-body text-center text-muted">ไม่พบประวัติออเดอร์</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Modals -->
        <?php foreach ($history_orders as $h_ord): 
            $h_items = GetOrderItems($h_ord['order_id']);
            $h_slipPath = 'assets/uploads/slips/order_' . $h_ord['order_id'];
            $h_slipUrl = null;
            foreach (['.jpg','.png','.webp'] as $ext) {
                if (file_exists(__DIR__ . '/assets/uploads/slips/order_' . $h_ord['order_id'] . $ext)) {
                    $h_slipUrl = $h_slipPath . $ext;
                    break;
                }
            }
        ?>
        <div class="modal fade" id="historyModal<?php echo $h_ord['order_id']; ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">ออเดอร์ #<?php echo str_pad($h_ord['order_id'], 6, '0', STR_PAD_LEFT); ?></h1>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <?php if ($h_slipUrl): ?>
                            <img src="<?php echo $h_slipUrl; ?>" alt="slip" class="rounded w-100 mb-3">
                        <?php endif; ?>
                        
                        <?php if (!empty($h_ord['tracking_number'])): ?>
                            <div class="alert alert-info">
                                <strong>เลขพัสดุ:</strong> <?php echo htmlspecialchars($h_ord['tracking_number']); ?>
                            </div>
                        <?php endif; ?>

                        <h6 class="mt-2">สินค้าที่สั่ง (<?php echo htmlspecialchars($h_ord['user_fullname']); ?>)</h6>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">สินค้า</th>
                                    <th scope="col">จำนวน</th>
                                    <th scope="col">ราคา</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($h_items as $it): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($it['product_name']); ?></td>
                                    <td><?php echo intval($it['quantity']); ?></td>
                                    <td><?php echo number_format(($it['price_per_unit'] - $it['discount_per_unit']) * $it['quantity'], 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="2">ยอดรวม</td>
                                    <td><?php echo number_format($h_ord['total_price'], 2); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div class="mt-3 text-center">
                            <span class="badge bg-secondary p-2">
                                สถานะ: <?php 
                                $status_map = [
                                    'shipped' => 'จัดส่งแล้ว',
                                    'delivered' => 'ได้รับสินค้าแล้ว', 
                                    'cancelled' => 'ยกเลิก',
                                    'confirmed' => 'ยืนยันแล้ว'
                                ];
                                echo isset($status_map[$h_ord['order_status']]) ? $status_map[$h_ord['order_status']] : $h_ord['order_status'];
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <?php foreach ($orders as $ord): 
            $items = GetOrderItems($ord['order_id']);
            $slipPath = 'assets/uploads/slips/order_' . $ord['order_id'];
            $slipUrl = null;
            foreach (['.jpg','.png','.webp'] as $ext) {
                if (file_exists(__DIR__ . '/assets/uploads/slips/order_' . $ord['order_id'] . $ext)) {
                    $slipUrl = $slipPath . $ext;
                    break;
                }
            }
        ?>
        <div class="modal fade" id="orderModal<?php echo $ord['order_id']; ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">ออเดอร์ #<?php echo str_pad($ord['order_id'], 6, '0', STR_PAD_LEFT); ?></h1>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <?php if ($slipUrl): ?>
                            <img src="<?php echo $slipUrl; ?>" alt="slip" class="rounded w-100">
                        <?php else: ?>
                            <div class="alert alert-warning">ยังไม่พบสลิปชำระเงิน</div>
                        <?php endif; ?>
                        <h6 class="mt-4">สินค้าที่สั่ง (<?php echo htmlspecialchars($ord['user_fullname']); ?>)</h6>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">สินค้า</th>
                                    <th scope="col">จำนวน</th>
                                    <th scope="col">ราคา</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $it): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($it['product_name']); ?></td>
                                    <td><?php echo intval($it['quantity']); ?></td>
                                    <td><?php echo number_format(($it['price_per_unit'] - $it['discount_per_unit']) * $it['quantity'], 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="2">ยอดรวม</td>
                                    <td><?php echo number_format($ord['total_price'], 2); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <form action="router/admin_confirm_order.router.php" method="post" class="mt-2">
                            <input type="hidden" name="order_id" value="<?php echo $ord['order_id']; ?>">
                            <button type="submit" class="btn btn-main btn-sm my-1 w-100">ยืนยันออเดอร์</button>
                        </form>
                        <form action="router/admin_cancel_order.router.php" method="post" class="mt-2">
                            <input type="hidden" name="order_id" value="<?php echo $ord['order_id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm my-1 w-100">ยกเลิกออเดอร์</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
</div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (isset($_SESSION['success'])) {
        echo "<script>Swal.fire({icon: 'success', title: 'สำเร็จ', text: '" . addslashes($_SESSION['success']) . "'});</script>";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo "<script>Swal.fire({icon: 'error', title: 'ผิดพลาด', text: '" . addslashes($_SESSION['error']) . "'});</script>";
        unset($_SESSION['error']);
    }
    ?>

    <script>
        function checkBackNavigation() {
            const navEntries = performance.getEntriesByType('navigation');
            if (navEntries.length > 0) {
                const navType = navEntries[0].type;
                if (navType === 'back_forward') {
                    window.location.reload();
                    return true;
                }
            }
            return false;
        }

        window.addEventListener('pageshow', function(event) {
            const isBack = event.persisted || checkBackNavigation();

            if (isBack) {
                window.location.reload();
            }
        });
        
    </script>

    <?php include('include/footer.php') ?>
</body>

</html>
