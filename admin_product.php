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

        <!-- หัวข้อ -->
        <div class="row mt-custom mb-3">
            <div class="col-md-10">
                <h3 class="text-main mb-0">| รายการสินค้า</h3>
            </div>
            <div class="col-md-2">
                <a href="#" class="btn btn-main w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">+
                    เพิ่มสินค้า</a>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Modal title</h1>
                        <button class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <label for="">ชื่อสินค้า</label>
                            <input type="text" class="form-control mb-2" name="" id="" required>
                            <label for="">ราคา</label>
                            <input type="number" class="form-control mb-2" name="" id="" required>
                            <label for="">รายละเอียด</label>
                            <textarea class="form-control mb-2" name="" id="" required></textarea>
                            <label for="">รูปภาพ</label>
                            <input type="file" class="form-control mb-2" name="" id="" required>
                            <label for="">ประเภท</label>
                            <select class="form-select mb-2" name="" id="" required>
                                <option value="">1</option>
                                <option value="">2</option>
                            </select>
                            <hr class="my-3">
                            <label for="">โปรโมชั่น</label>
                            <select class="form-select mb-2" name="" id="" required>
                                <option value="">ไม่มี</option>
                                <option value="">event 1</option>
                                <option value="">event 2</option>
                            </select>
                            <button type="submit" class="btn btn-main w-100">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
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
                        <div class="row">
                            <div class="col-md-6">
                                <a href="#" class="btn btn-warning w-100 mt-3" data-bs-toggle="modal" data-bs-target="#edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="#" class="btn btn-danger w-100 mt-3">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="edit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">แก้ไข title</h1>
                            <button class="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post">
                                <label for="">ชื่อสินค้า</label>
                                <input type="text" class="form-control mb-2" name="" id="" required>
                                <label for="">ราคา</label>
                                <input type="number" class="form-control mb-2" name="" id="" required>
                                <label for="">รายละเอียด</label>
                                <textarea class="form-control mb-2" name="" id="" required></textarea>
                                <label for="">รูปภาพ</label>
                                <input type="file" class="form-control mb-2" name="" id="" required>
                                <label for="">ประเภท</label>
                                <select class="form-select mb-2" name="" id="" required>
                                    <option value="">1</option>
                                    <option value="">2</option>
                                </select>
                                <hr class="my-3">
                                <label for="">โปรโมชั่น</label>
                                <select class="form-select mb-2" name="" id="" required>
                                    <option value="">ไม่มี</option>
                                    <option value="">event 1</option>
                                    <option value="">event 2</option>
                                </select>
                                <button type="submit" class="btn btn-main w-100">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php include('include/footer.php') ?>
</body>

</html>