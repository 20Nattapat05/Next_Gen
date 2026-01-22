<?php

require_once __DIR__ . '/function/user/cart_function.php';
require_once __DIR__ . '/function/user/order_function.php';
require_once __DIR__ . '/function/user/address_function.php';

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
$addresses = GetAddressesByUserId($user_id);

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
        <style>
        .section-title { color: #0d6efd; font-weight: 600; }
        .card-clean { background: #ffffff; border: none; box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
        .text-label { color: #6c757d; }
        .price { color: #0d6efd; font-weight: 700; }
        .address-card { transition: border-color .2s ease, box-shadow .2s ease; }
        .address-card.selected { border: 2px solid #0d6efd !important; box-shadow: 0 6px 16px rgba(13,110,253,.15); }
        </style>
        <div class="mb-4 mt-custom">
            <h3 class="section-title mb-0">| ชำระเงิน</h3>
            <small class="text-label">โปรดตรวจสอบรายละเอียดและเลือกวิธีการชำระเงิน</small>
        </div>

        <?php
        $insufficient = false;
        foreach ($cart_total['items'] as $it) {
            if (isset($it['available_qty']) && $it['quantity'] > $it['available_qty']) {
                $insufficient = true;
                break;
            }
        }
        ?>
        <?php if ($insufficient): ?>
        <div class="alert alert-warning card-clean">
            บางรายการสต็อกไม่พอ กรุณาลดจำนวนหรือเอาออกจากตะกร้า
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-8">
                <!-- Order Items Review -->
                <div class="mb-4">
                    <h5 class="section-title mb-3">รายการสินค้า</h5>
                    <?php foreach ($cart_total['items'] as $item): ?>
                    <div class="card card-clean mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-bold mb-1" style="color:#212529;">
                                        <?php echo htmlspecialchars($item['product_name']); ?></p>
                                    <small class="text-label">
                                        จำนวน: <?php echo $item['quantity']; ?> ชิ้น ×
                                        ฿<?php echo number_format($item['price_per_unit'], 2); ?>
                                    </small>
                                </div>
                                <div class="text-end">
                                    <p class="price mb-0">
                                        ฿<?php echo number_format($item['item_total'], 2); ?></p>
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
                    <h5 class="section-title mb-3">วิธีการชำระเงิน</h5>

                    <label class="card card-clean payment-card selected" style="cursor:pointer;">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <input type="radio" checked class="form-check-input">
                                <div class="ms-3">
                                    <h6 class="mb-0" style="color:#212529;">
                                        <i class="bi bi-qr-code me-2"></i>สแกนจ่าย (PromptPay)
                                    </h6>
                                    <small class="text-label">
                                        รองรับ Mobile Banking ทุกธนาคาร
                                    </small>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>

                <div class="mb-4">
                    <h5 class="section-title mb-3">ที่อยู่จัดส่ง</h5>

                    <div class="row">
                        <?php if (!empty($addresses)): ?>
                            <?php foreach ($addresses as $addr): ?>
                                <div class="col-md-6">
                                    <label class="card card-clean mb-3 address-card" style="cursor:pointer;">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <input type="radio" name="address_id" class="form-check-input address-radio" value="<?php echo intval($addr['address_id']); ?>">
                                                <div class="ms-3">
                                                    <p class="fw-bold mb-1" style="color:#212529;"><?php echo htmlspecialchars($addr['address_name']); ?></p>
                                                    <small class="text-label">
                                                        <?php echo htmlspecialchars($addr['recipient_name']); ?> (<?php echo htmlspecialchars($addr['recipient_phone']); ?>)<br>
                                                        <?php echo htmlspecialchars($addr['address_detail']); ?> <?php echo htmlspecialchars($addr['postal_code']); ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="alert alert-warning card-clean">
                                    ไม่มีที่อยู่จัดส่ง กรุณาเพิ่มที่อยู่ที่หน้า <a href="account" class="alert-link">บัญชีของฉัน</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>

            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card card-clean sticky-top" style="top: 100px;">
                    <div class="card-body">
                        <h5 class="section-title mb-3">สรุปการสั่งซื้อ</h5>

                        <div class="d-flex justify-content-between pb-2 border-bottom" style="opacity: 0.5;">
                            <span class="text-label">จำนวนสินค้า:</span>
                            <span class="fw-bold" style="color:#212529;"><?php echo $cart_total['item_count']; ?> รายการ</span>
                        </div>

                        <div class="d-flex justify-content-between py-2 border-bottom" style="opacity: 0.5;">
                            <span class="text-label">ราคาสินค้า:</span>
                            <span style="color:#212529;">฿<?php echo number_format($cart_total['subtotal'], 2); ?></span>
                        </div>

                        <?php if ($cart_total['total_discount'] > 0): ?>
                        <div class="d-flex justify-content-between py-2 border-bottom" style="opacity: 0.5;">
                            <span>ส่วนลด:</span>
                            <span>-฿<?php echo number_format($cart_total['total_discount'], 2); ?></span>
                        </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between pt-3 border-top" style="border-width: 2px !important;">
                            <span class="fw-bold" style="color:#212529; font-size: 1.2rem;">ยอดรวมทั้งสิ้น:</span>
                            <span class="price" style="font-size: 1.3rem;">฿<?php echo number_format($cart_total['grand_total'], 2); ?></span>
                        </div>

                        <button class="btn btn-primary w-100 mt-3 fw-bold" id="confirmBtn" onclick="confirmCheckout()" <?php echo $insufficient ? 'disabled' : ''; ?>>
                            <i class="bi bi-check-circle me-2"></i>ยืนยันการสั่งซื้อ
                        </button>

                        <a href="cart.php" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-arrow-left me-2"></i>กลับไปตะกร้า
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Address Section -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    // Enable confirm button when address selected
    const confirmBtn = document.getElementById('confirmBtn');
    const addressRadios = document.querySelectorAll('.address-radio');
    addressRadios.forEach(r => {
        r.addEventListener('change', function() {
            confirmBtn.disabled = false;
            document.querySelectorAll('.address-card').forEach(c => c.classList.remove('selected'));
            this.closest('.address-card').classList.add('selected');
        });
    });

    function confirmCheckout() {
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
                processCheckout();
            }
        });
    }

    function processCheckout() {
        const selected = document.querySelector('input[name="address_id"]:checked');
        if (!selected) {
            Swal.fire({icon: 'warning', title: 'เลือกที่อยู่', text: 'กรุณาเลือกที่อยู่จัดส่ง'});
            return;
        }
        const address_id = selected.value;
        fetch('router/order.router.php?action=create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'address_id=' + encodeURIComponent(address_id)
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
                        window.location.href = 'payment.php?order_id=' + data.order_id;
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
