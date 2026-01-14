<?php

require_once __DIR__ . '/function/user/cart_function.php';
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
$cart_total = CalculateCartTotal($user_id);

// If cart is empty, redirect
if (empty($cart_total['items'])) {
    header('Location: /Next_Gen/cart.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ชำระเงิน | Next Gen IT</title>
    <?php include('include/header.php') ?>
</head>

<body class="bg-dark">

    <?php include('include/navbar.php') ?>

    <div class="container mt-4 mb-4">
        <!-- Header -->
        <div class="mb-4">
            <h3 class="text-main mb-0">| ชำระเงิน</h3>
            <small class="text-muted">โปรดตรวจสอบรายละเอียดและเลือกวิธีการชำระเงิน</small>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Order Items Review -->
                <div class="mb-4">
                    <h5 class="text-success mb-3">📦 รายการสินค้า</h5>
                    <?php foreach ($cart_total['items'] as $item): ?>
                        <div class="card bg-secondary mb-3" style="border: none;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-white fw-bold mb-1"><?php echo htmlspecialchars($item['product_name']); ?></p>
                                        <small class="text-muted">
                                            จำนวน: <?php echo $item['quantity']; ?> ชิ้น × 
                                            ฿<?php echo number_format($item['price_per_unit'], 2); ?>
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <p class="text-success fw-bold mb-0">฿<?php echo number_format($item['item_total'], 2); ?></p>
                                        <?php if ($item['item_discount'] > 0): ?>
                                            <small class="text-success">-฿<?php echo number_format($item['item_discount'], 2); ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Payment Method -->
                <div class="mb-4">
                    <h5 class="text-success mb-3">💳 วิธีการชำระเงิน</h5>

                    <div class="alert alert-warning" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <small>ขณะนี้รองรับ: โอนเงินผ่านธนาคารเท่านั้น</small>
                    </div>

                    <form id="paymentForm">
                        <!-- Bank Transfer -->
                        <label class="card bg-dark border-info mb-3" style="cursor: pointer;">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="payment_method" value="bank_transfer" checked class="form-check-input">
                                    <div class="ms-3">
                                        <h6 class="text-success mb-0"><i class="bi bi-bank me-2"></i>โอนเงินผ่านธนาคาร</h6>
                                        <small class="text-muted">กรุณาโอนเงินไปยังบัญชีธนาคารของเรา</small>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <!-- QR Code -->
                        <label class="card bg-dark border-info mb-3" style="cursor: pointer; opacity: 0.5; pointer-events: none;">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="payment_method" value="qr_code" disabled>
                                    <div class="ms-3">
                                        <h6 class="text-success mb-0"><i class="bi bi-qr-code me-2"></i>สแกน QR Code</h6>
                                        <small class="text-muted">(เร็วๆ นี้)</small>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <!-- Credit Card -->
                        <label class="card bg-dark border-info mb-3" style="cursor: pointer; opacity: 0.5; pointer-events: none;">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="payment_method" value="credit_card" disabled>
                                    <div class="ms-3">
                                        <h6 class="text-success mb-0"><i class="bi bi-credit-card me-2"></i>บัตรเครดิต/เดบิต</h6>
                                        <small class="text-muted">(เร็วๆ นี้)</small>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </form>

                    <div id="bankTransferInfo" class="card bg-dark border-info p-3">
                        <h6 class="text-success mb-2">📋 รายละเอียดการโอนเงิน</h6>
                        <p class="mb-1"><strong>ธนาคาร:</strong> <span class="text-muted">ธนาคารกรุงไทย</span></p>
                        <p class="mb-1"><strong>ชื่อบัญชี:</strong> <span class="text-muted">Next Gen IT Co., Ltd</span></p>
                        <p class="mb-1"><strong>เลขบัญชี:</strong> <span class="text-success">123-456-7890</span></p>
                        <p class="mb-0"><strong>อ้างอิง:</strong> <span class="text-muted">Order #[ระบบจะสร้างหลังยืนยัน]</span></p>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="mb-4">
                    <label class="d-flex align-items-center form-check" style="cursor: pointer;">
                        <input type="checkbox" id="agreeTerms" class="form-check-input">
                        <span class="ms-2 text-muted">
                            ฉันยอมรับ <a href="#" style="color: #0099cc; text-decoration: none;">เงื่อนไขและข้อตกลง</a>
                        </span>
                    </label>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card bg-dark border-info sticky-top" style="top: 100px;">
                    <div class="card-body">
                        <h5 class="text-success mb-3">📊 สรุปการสั่งซื้อ</h5>

                        <div class="d-flex justify-content-between pb-2 border-bottom border-info" style="opacity: 0.3;">
                            <span class="text-muted">จำนวนสินค้า:</span>
                            <span class="text-success"><?php echo $cart_total['item_count']; ?> รายการ</span>
                        </div>

                        <div class="d-flex justify-content-between py-2 border-bottom border-info" style="opacity: 0.3;">
                            <span class="text-muted">ราคาสินค้า:</span>
                            <span class="text-white">฿<?php echo number_format($cart_total['subtotal'], 2); ?></span>
                        </div>

                        <?php if ($cart_total['total_discount'] > 0): ?>
                            <div class="d-flex justify-content-between py-2 border-bottom border-info text-success" style="opacity: 0.3;">
                                <span>ส่วนลด:</span>
                                <span>-฿<?php echo number_format($cart_total['total_discount'], 2); ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between pt-3 border-top border-info" style="border-width: 2px !important;">
                            <span class="text-success fw-bold" style="font-size: 1.3rem;">ยอดรวมทั้งสิ้น:</span>
                            <span class="text-success fw-bold" style="font-size: 1.3rem;">฿<?php echo number_format($cart_total['grand_total'], 2); ?></span>
                        </div>

                        <button class="btn btn-primary w-100 mt-3 fw-bold" id="confirmBtn" onclick="confirmCheckout()" disabled>
                            <i class="bi bi-check-circle me-2"></i>ยืนยันการสั่งซื้อ
                        </button>

                        <a href="cart.php" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-arrow-left me-2"></i>กลับไปตะกร้า
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Enable button when terms are agreed
        document.getElementById('agreeTerms').addEventListener('change', function() {
            document.getElementById('confirmBtn').disabled = !this.checked;
        });

        // Highlight selected payment method
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.payment-method-card').forEach(card => {
                    card.classList.remove('selected');
                });
                this.closest('.payment-method-card').classList.add('selected');
            });
        });

        function confirmCheckout() {
            if (!document.getElementById('agreeTerms').checked) {
                Swal.fire({
                    icon: 'warning',
                    title: 'ยังไม่ยอมรับเงื่อนไข',
                    text: 'กรุณายอมรับเงื่อนไขและข้อตกลงก่อน',
                    confirmButtonColor: '#0099cc'
                });
                return;
            }

            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

            Swal.fire({
                title: 'ยืนยันการสั่งซื้อ',
                text: 'คุณต้องการสั่งซื้อสินค้าหรือไม่?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0099cc',
                cancelButtonColor: '#444',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then(result => {
                if (result.isConfirmed) {
                    processCheckout(paymentMethod);
                }
            });
        }

        function processCheckout(paymentMethod) {
            fetch('router/order.router.php?action=create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'payment_method=' + encodeURIComponent(paymentMethod)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'สั่งซื้อสำเร็จ!',
                        text: 'เลขที่คำสั่ง: #' + data.order_id,
                        confirmButtonColor: '#0099cc'
                    }).then(() => {
                        window.location.href = 'order_history.php?order_id=' + data.order_id;
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: data.message,
                        confirmButtonColor: '#0099cc'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด',
                    text: 'เกิดข้อผิดพลาดในการสั่งซื้อ',
                    confirmButtonColor: '#0099cc'
                });
            });
        }
    </script>

    <?php include('include/footer.php') ?>

</body>

</html>
