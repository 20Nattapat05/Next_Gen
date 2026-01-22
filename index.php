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

$data = GetContent();
$random_products = GetRandomProducts(3);

// Check if user just logged in
$showLoginAlert = isset($_SESSION['user_login_success']) && $_SESSION['user_login_success'];
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
    <?php include('include/navbar.php') ?>

    <div class="container">
        <div id="carouselExample" class="carousel slide mt-custom" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/images/news/<?php echo $data['banner_1']['content_image']; ?>" alt="banner"
                        class="w-100 rounded object-fit-cover" style="height: 700px;">
                </div>
                <div class="carousel-item">
                    <img src="assets/images/news/<?php echo $data['banner_2']['content_image']; ?>" alt="banner2"
                        class="w-100 rounded object-fit-cover" style="height: 700px;">
                </div>
                <div class="carousel-item">
                    <img src="assets/images/news/<?php echo $data['banner_3']['content_image']; ?>" alt="banner3"
                        class="w-100 rounded object-fit-cover" style="height: 700px;">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="card my-4 shadow-lg border-0">
            <div class="card-body py-4">
                <div class="row text-center align-items-center">
                    <div class="col-md-4 my-auto">
                        <a href="order_history" class="h5 mb-0 fw-semibold text-decoration-none">
                            <i class="bi bi-receipt text-primary me-1"
                                style="transform: rotate(-30deg); display: inline-block;"></i> ประวัติการสั่ง</a>
                    </div>
                    <div class="col-md-4 border-start border-end">
                        <h4 class="mb-0 fw-bold text-main" id="realtime"></h4>
                    </div>
                    <div class="col-md-4 my-auto">
                        <a href="#" class="h5 mb-0 fw-semibold text-decoration-none">
                            <i class="bi bi-tags-fill text-danger me-1"></i>
                            สินค้าเข้าร่วมแคมเปญ</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- ข่าวเด่น -->
            <div class="col-md-6">
                <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#newsModal1">
                    <div class="card my-3 border-0 shadow-sm overflow-hidden zoom-card"
                        style="height: 500px; position: relative; cursor: pointer;">
                        <img src="assets/images/news/<?php echo $data['news_1']['content_image']; ?>"
                            class="card-img object-fit-cover"
                            style="height: 100%; filter: brightness(80%); transition: transform 0.4s ease;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end text-white p-4"
                            style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);">
                            <h3 class="fw-bold"><?php echo $data['news_1']['content_title']; ?></h3>
                            <p class="mb-0"><?php echo $data['news_1']['content_description']; ?></p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- ข่าวรอง -->
            <div class="col-md-6">
                <div class="row my-3">
                    <!-- ข่าววงการเทค -->
                    <div class="col-md-6 mb-3 mb-md-0">
                        <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#newsModal2">
                            <div class="card border-0 shadow-sm overflow-hidden zoom-card"
                                style="height: 242px; position: relative; cursor: pointer;">
                                <img src="assets/images/news/<?php echo $data['news_2']['content_image']; ?>"
                                    class="card-img object-fit-cover"
                                    style="height: 100%; filter: brightness(75%); transition: transform 0.4s ease;">
                                <div class="card-img-overlay d-flex flex-column justify-content-end text-white p-3"
                                    style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);">
                                    <h5 class="fw-semibold mb-1"><?php echo $data['news_2']['content_title']; ?></h5>
                                    <small><?php echo $data['news_2']['content_description']; ?></small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- ข่าวกิจกรรม -->
                    <div class="col-md-6">
                        <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#newsModal3">
                            <div class="card border-0 shadow-sm overflow-hidden zoom-card"
                                style="height: 242px; position: relative; cursor: pointer;">
                                <img src="assets/images/news/<?php echo $data['news_3']['content_image']; ?>"
                                    class="card-img object-fit-cover"
                                    style="height: 100%; filter: brightness(75%); transition: transform 0.4s ease;">
                                <div class="card-img-overlay d-flex flex-column justify-content-end text-white p-3"
                                    style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);">
                                    <h5 class="fw-semibold mb-1"><?php echo $data['news_3']['content_title']; ?></h5>
                                    <small><?php echo $data['news_3']['content_description']; ?></small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- การ์ดเดิม -->
                <a href="contact" class="text-decoration-none">
                    <div class="card my-3 border-0 shadow-sm overflow-hidden zoom-card"
                        style="height: 242px; position: relative;">
                        <img src="https://images.unsplash.com/photo-1579389083078-4e7018379f7e?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            class="card-img object-fit-cover"
                            style="height: 100%; filter: brightness(80%); transition: transform 0.4s ease;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end text-white p-3"
                            style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);">
                            <h5 class="fw-semibold mb-1">แจ้งข่าวสารให้ผู้ดูแล</h5>
                            <small>พบเจอปัญหา หรือ ติดต่อสอบถามข้อมูลเพิ่มเติม</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- MODALS -->
        <!-- ข่าว 1 -->
        <div class="modal fade" id="newsModal1" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo $data['news_1']['content_title']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <img src="assets/images/news/<?php echo $data['news_1']['content_image']; ?>"
                            class="img-fluid rounded mb-3" alt="ข่าวเด่น">
                        <p><?php echo $data['news_1']['content_description']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ข่าว 2 -->
        <div class="modal fade" id="newsModal2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo $data['news_2']['content_title']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <img src="assets/images/news/<?php echo $data['news_2']['content_image']; ?>"
                            class="img-fluid rounded mb-3" alt="ข่าวเทคโนโลยี">
                        <p><?php echo $data['news_2']['content_description']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ข่าว 3 -->
        <div class="modal fade" id="newsModal3" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo $data['news_3']['content_title']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <img src="assets/images/news/<?php echo $data['news_3']['content_image']; ?>"
                            class="img-fluid rounded mb-3" alt="กิจกรรม">
                        <p><?php echo $data['news_3']['content_description']; ?></p>
                    </div>
                </div>
            </div>
        </div>


        <section class="my-5">
            <div class="row align-items-center g-4">
                <!-- ฝั่งข้อความ -->
                <div class="col-md-5">
                    <h4 class="text-main mb-3">| ทำไมลูกค้าถึงเลือก Next Gen IT</h4>
                    <ul class="list-unstyled text-light mb-4">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            ราคาย่อมเยา เหมาะกับนักเรียน–นักศึกษา
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            มีบริการหลังการขายและรับประกันสินค้า
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            ให้คำปรึกษาสเปกคอมฟรีก่อนซื้อ
                        </li>
                    </ul>

                    <div class="d-flex flex-wrap gap-3">
                        <div>
                            <h3 class="text-main fw-bold mb-0">4.8</h3>
                            <small class="text-light">
                                <i class="bi bi-star-fill text-warning"></i> จาก 5 คะแนน
                            </small>
                        </div>
                        <div class="vr d-none d-md-block"></div>
                        <div>
                            <h3 class="text-main fw-bold mb-0">500+</h3>
                            <small class="text-light">ลูกค้าที่ไว้วางใจเรา</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card border-0 shadow-lg overflow-hidden bg-dark-subtle position-relative h-100">
                        <div class="row g-0 h-100">
                            <div class="col-md-6">
                                <img src="assets/images/banner.jpg" alt="หน้าร้าน Next Gen IT"
                                    class="img-fluid h-100 w-100 object-fit-cover">
                            </div>
                            <div class="col-md-6 d-flex flex-column justify-content-between p-3 p-md-4">
                                <div>
                                    <span class="badge bg-success mb-2">Next Gen IT</span>
                                    <h5 class="fw-bold text-main mb-2">บริการเป็นกันเอง แบบเพื่อนแนะนำเพื่อน</h5>
                                    <p class="text-light-50 small mb-3">
                                        ทีมงานสายไอทีตัวจริง พร้อมช่วยแนะนำสเปกคอม อุปกรณ์
                                        และการใช้งานให้เหมาะกับงบของคุณ
                                    </p>
                                </div>

                                <div class="d-flex align-items-center">
                                    <img src="assets/images/banner.jpg" alt="เพนกวิ้นมาสคอต Next Gen IT"
                                        class="rounded-circle me-3"
                                        style="width: 56px; height: 56px; object-fit: cover;">
                                    <div>
                                        <div class="fw-semibold text-main mb-1">เพนกวิ้น Next Gen</div>
                                        <small class="text-light-50">
                                            “เน้นของคุ้ม ใช้งานได้จริง บริการไม่ทิ้งลูกค้า”
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <span
                            class="position-absolute top-0 end-0 m-3 badge rounded-pill bg-success-subtle text-success">
                            เปิดให้บริการทุกวัน
                        </span>
                    </div>
                </div>
            </div>
        </section>


        <h4 class="text-main my-4">| รายการสินค้าใหม่</h4>
        <div class="row">
            <?php if (!empty($random_products)): ?>
            <?php foreach ($random_products as $product): ?>
            <?php
                    // --- ส่วนคำนวณ Logic ---
                    $original_price = $product['product_price'];
                    $final_price = $product['final_price'];
                    $has_discount = ($original_price != $final_price);
                    $stock = $product['product_qty'];
                    ?>
            <div class="col-md-4 mb-4">
                <div class="card card-product border-0 shadow-sm h-100 text-dark overflow-hidden">

                    <?php if (!empty($product['event_name'])): ?>
                    <span class="position-absolute top-0 start-0 m-2 badge rounded-pill bg-danger shadow-sm"
                        style="z-index: 1;">
                        <i class="bi bi-tag-fill me-1"></i> <?php echo $product['event_name']; ?>
                    </span>
                    <?php endif; ?>


                    <img src="assets/images/product/<?php echo $product['product_picture'] ?>"
                        class="w-100 object-fit-cover" style="height: 300px;"
                        alt="<?php echo $product['product_name']; ?>">


                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold mb-1 text-truncate"><?php echo $product['product_name']; ?></h5>

                        <p class="text-muted small mb-3 text-truncate-2">
                            <?php echo $product['product_detail'] ?: 'ไม่มีรายละเอียดสินค้าในขณะนี้'; ?>
                        </p>

                        <div class="mt-auto">
                            <div class="mb-2">
                                <?php if ($has_discount): ?>
                                <h5 class="text-main d-inline fw-bold mb-0">
                                    ฿<?php echo number_format($final_price, 2); ?></h5>
                                <small
                                    class="text-muted text-decoration-line-through ms-2">฿<?php echo number_format($original_price, 2); ?></small>
                                <?php else: ?>
                                <h5 class="text-main fw-bold mb-0">฿<?php echo number_format($original_price, 2); ?>
                                </h5>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-3">
                                <small class="text-muted">
                                    <i class="bi bi-box-seam me-1"></i> คงเหลือ:
                                    <span class="<?php echo $stock <= 5 ? 'text-danger fw-bold' : ''; ?>">
                                        <?php echo $stock; ?> ชิ้น
                                    </span>
                                </small>
                            </div>

                            <?php if ($isUser): ?>
                            <a href="cart_action.php?action=add&id=<?php echo $product['product_id']; ?>"
                                class="btn btn-main w-100 fw-bold">
                                <i class="bi bi-cart-plus me-2"></i> เพิ่มลงตะกร้า
                            </a>
                            <?php else: ?>
                            <button onclick="location.href='login.php';"
                                class="btn btn-outline-secondary w-100 fw-bold">
                                <i class="bi bi-lock-fill me-2"></i> เข้าสู่ระบบเพื่อสั่งซื้อ
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include('include/footer.php') ?>
    <script>
    // Show welcome alert if user just logged in
    <?php if ($showLoginAlert): ?>
    Swal.fire({
        icon: 'success',
        title: 'ยินดีต้อนรับ!',
        html: 'สวัสดีคุณ <strong><?php echo htmlspecialchars($_SESSION['user_fullname']); ?></strong><br>เข้าสู่ระบบสำเร็จ',
        confirmButtonText: 'เริ่มช้อปปิ้ง',
        confirmButtonColor: '#0d6efd',
        allowOutsideClick: false
    });
    <?php unset($_SESSION['user_login_success']); ?>
    <?php endif; ?>

    function updateTime() {
        const now = new Date();
        const options = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        document.getElementById("realtime").textContent = now.toLocaleTimeString('th-TH', options);
    }
    setInterval(updateTime, 1000);
    updateTime();
    </script>
</body>

</html>