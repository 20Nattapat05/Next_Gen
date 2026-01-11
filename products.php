<?php

    session_start();

    require_once __DIR__ . '/function/admin/product_function.php';

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

                <!-- เลือกหมวดหมู่ -->
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">หมวดหมู่ทั้งหมด</option>
                        <option value="mobile">อุปกรณ์มือถือ</option>
                        <option value="pc">อุปกรณ์คอมพิวเตอร์</option>
                        <option value="gaming">Gaming Gear</option>
                        <option value="network">Network</option>
                        <option value="sale">ของลดราคา</option>
                    </select>
                </div>

                <!-- เลือกการเรียงลำดับ -->
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="latest">เรียงตามสินค้าใหม่ล่าสุด</option>
                        <option value="price_asc">ราคาต่ำ → สูง</option>
                        <option value="price_desc">ราคาสูง → ต่ำ</option>
                        <option value="popular">ขายดี</option>
                        <option value="rating">คะแนนรีวิวสูง</option>
                    </select>
                </div>

                <!-- ช่องค้นหา -->
                <div class="col-md-6">
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

            <!-- สินค้า 1 -->
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100 card-product">
                    <img src="assets/images/banner.jpg" class="w-100 object-fit-cover rounded-top"
                        style="height: 240px;" alt="ฟิล์มกระจก iPhone 14 Pro Max">
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">ฟิล์มกระจก iPhone 14 Pro Max</h6>
                        <p class="text-main fw-semibold mb-1">ราคา 150 บาท</p>
                        <small class="text-muted d-block">ขายแล้ว 230 ชิ้น</small>

                        <!-- ดาวคะแนน -->
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="text-warning small">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <small class="text-muted">4.5 ★</small>
                        </div>

                        <!-- ลิงก์ไปหน้ารายละเอียด -->
                        <a href="product-detail.php?id=1" class="btn btn-main w-100 mt-3">
                            ดูรายละเอียด
                        </a>
                    </div>
                </div>
            </div>

            <!-- สินค้า 2 -->
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100 card-product position-relative">

                    <!-- Badge เข้าร่วมแคมเปญ -->
                    <span class="position-absolute top-0 end-0 m-2 badge bg-danger shadow-sm">
                        เข้าร่วมแคมเปญ
                    </span>

                    <img src="assets/images/banner.jpg" class="w-100 object-fit-cover rounded-top"
                        style="height: 240px;">
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">ฟิล์มกระจก iPhone 14 Pro Max</h6>
                        <p class="text-main fw-semibold mb-1">ราคา 150 บาท</p>
                        <small class="text-muted d-block">ขายแล้ว 230 ชิ้น</small>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="text-warning small">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <small class="text-muted">4.5 ★</small>
                        </div>

                        <a href="product-detail.php?id=1" class="btn btn-main w-100 mt-3">
                            ดูรายละเอียด
                        </a>
                    </div>
                </div>
            </div>

            <!-- สินค้า 3 -->
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100 card-product">
                    <img src="assets/images/banner.jpg" class="w-100 object-fit-cover rounded-top"
                        style="height: 240px;" alt="เมาส์เกมมิ่ง RGB 7200DPI">
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">เมาส์เกมมิ่ง RGB 7200DPI</h6>
                        <p class="text-main fw-semibold mb-1">ราคา 450 บาท</p>
                        <small class="text-muted d-block">ขายแล้ว 120 ชิ้น</small>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="text-warning small">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                            </div>
                            <small class="text-muted">4.0 ★</small>
                        </div>

                        <a href="product-detail.php?id=3" class="btn btn-main w-100 mt-3">
                            ดูรายละเอียด
                        </a>
                    </div>
                </div>
            </div>

            <!-- สินค้า 4 -->
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100 card-product position-relative">

                    <!-- Badge เข้าร่วมแคมเปญ -->
                    <span class="position-absolute top-0 end-0 m-2 badge bg-danger shadow-sm">
                        เข้าร่วมแคมเปญ
                    </span>

                    <img src="assets/images/banner.jpg" class="w-100 object-fit-cover rounded-top"
                        style="height: 240px;">
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">ฟิล์มกระจก iPhone 14 Pro Max</h6>
                        <p class="text-main fw-semibold mb-1">ราคา 150 บาท</p>
                        <small class="text-muted d-block">ขายแล้ว 230 ชิ้น</small>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="text-warning small">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <small class="text-muted">4.5 ★</small>
                        </div>

                        <a href="product-detail.php?id=1" class="btn btn-main w-100 mt-3">
                            ดูรายละเอียด
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php include('include/footer.php') ?>

</body>

</html>