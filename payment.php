<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/function/user/order_function.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: /Next_Gen/login');
    exit();
}
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
if ($order_id <= 0) {
    header('Location: /Next_Gen/order_history.php');
    exit();
}
$order = GetOrderDetail($order_id, $_SESSION['user_id']);
$amount = $order ? floatval($order['total_price']) : 0.0;
$status = $order ? $order['payment_status'] : 'pending';
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ชำระเงิน | Next Gen IT</title>
    <?php include('include/header.php') ?>
</head>
<body class="bg-dark">
    <?php include('include/navbar.php') ?>

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-5">

                <div class="card border-0 shadow-lg mt-custom">
                    <div class="card-body p-4 p-md-5">
                        <!-- โลโก้ / ชื่อระบบ -->
                        <div class="text-center mb-4">
                            <h4 class="fw-bold mb-0">กรุณาชำระเงิน</h4>
                        </div>

                        <?php if ($order): ?>
                        <div class="d-flex justify-content-between align-items-center p-3 rounded mb-3" style="background:#f8f9fa;">
                            <span class="text-muted">ยอดที่ต้องชำระ</span>
                            <span class="fw-bold" style="color:#0d6efd; font-size:1.3rem;">฿<?php echo number_format($amount, 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-2 rounded mb-3" style="background:#f8f9fa;">
                            <span class="text-muted">สถานะการชำระเงิน</span>
                            <span class="badge <?php echo ($status === 'paid') ? 'bg-success' : (($status === 'failed') ? 'bg-danger' : 'bg-warning text-dark'); ?>">
                                <?php echo ($status === 'paid') ? 'ชำระแล้ว' : (($status === 'failed') ? 'ชำระไม่สำเร็จ' : 'รอการชำระ'); ?>
                            </span>
                        </div>
                        <?php endif; ?>

                        <img src="assets/images/qr-code.jpg" alt="slip" class="w-100 my-3 rounded">

                        <form action="router/payment_upload.router.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">

                            <div class="mb-3">
                                <label class="form-label">แนบรูปใบเสร็จชำระเงิน</label>
                                <input type="file" class="form-control" name="slip" accept="image/*" required>
                            </div>

                            <button type="submit" class="btn btn-main w-100"><i class="bi bi-send me-1"></i> ส่ง</button>

                        </form>

                    </div>
                </div>

            </div>
        </div>
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
    <?php include('include/footer.php') ?>

</body>

</html>
