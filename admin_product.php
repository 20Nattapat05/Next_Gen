<?php

require_once 'include/check_auth_admin.php';

require_once __DIR__ . '/function/admin/product_type_function.php';

$product_type_item = getAllProductTypes();

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

        <!-- หัวข้อ -->
        <div class="row mt-custom mb-3">
            <div class="col-md-8">
                <h3 class="text-main mb-0">| รายการสินค้า</h3>
            </div>
            <div class="col-md-2">
                <a href="#" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#AddProductType">เพิ่มประเภทสินค้า</a>
            </div>
            <div class="col-md-2">
                <a href="#" class="btn btn-main w-100" data-bs-toggle="modal" data-bs-target="#AddProduct">เพิ่มสินค้า</a>
            </div>
        </div>

        <div class="modal fade" id="AddProductType" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-dark text-white">
                        <h1 class="modal-title fs-5"><i class="bi bi-tag-fill me-2"></i>จัดการประเภทสินค้า</h1>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">


                        <form action="router/manageproducttype.router.php" method="post" class="mb-4">
                            <input type="hidden" name="prod" value="add">
                            <div class="form-group">
                                <label class="form-label fw-bold text-primary">เพิ่มประเภทใหม่</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="product_type_name" placeholder="ชื่อประเภทสินค้า...">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-plus-lg"></i> บันทึก
                                    </button>
                                </div>
                            </div>
                        </form>



                        <hr>

                        <label class="form-label fw-bold mb-2">ประเภทสินค้าที่มีอยู่แล้ว</label>

                        <div class="list-group shadow-sm" style="max-height: 250px; overflow-y: auto;">

                            <?php
                            if (isset($product_type_item) && !empty($product_type_item)) {
                                foreach ($product_type_item as $id => $item) {
                            ?>
                                    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                        <div>
                                            <span class="badge bg-secondary text-dark me-2"><?php echo $id + 1; ?></span>
                                            <span class="fw-semibold"><?php echo htmlspecialchars($item['product_type_name']); ?></span>
                                        </div>
                                        <form action="router/manageproducttype.router.php" method="post">
                                            <input type="hidden" name="delete_product_type_id" value="<?php echo $item['product_type_id']; ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-sm border-0">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                <?php
                                }
                            } else {
                                ?>

                                <div class="text-center text-muted py-3">
                                    ไม่มีประเภทสินค้าในระบบ
                                </div>

                            <?php } ?>

                        </div>

                        <hr>

                        <div class="form-text mt-3 text-muted">
                            <i class="bi bi-info-circle"></i> หมายเหตุ : หากต้องการลบประเภทสินค้า กรุณาตรวจสอบให้แน่ใจว่าไม่มีสินค้าที่อยู่ในประเภทนั้นก่อน
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const addTypeModal = document.getElementById('AddProductType');
            if (addTypeModal) {
                addTypeModal.addEventListener('hidden.bs.modal', function() {
                    // ค้นหาฟอร์มด้านในแล้ว Reset ค่าทั้งหมด
                    const form = this.querySelector('form');
                    if (form) form.reset();
                });
            }
        </script>

        <!-- Modal -->
        <div class="modal fade" id="AddProduct">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">เพิ่มรายการสินค้า</h1>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="router/manageproduct.router.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add">

                            <label>ชื่อสินค้า <span class="text-danger">*</span></label>
                            <input type="text" class="form-control mb-2" name="product_name" required>

                            <label>ราคา <span class="text-danger">*</span></label>
                            <input type="number" class="form-control mb-2" name="product_price" required>

                            <label>จำนวน <span class="text-danger">*</span></label>
                            <input type="number" class="form-control mb-2" name="product_qty" required>

                            <label>รายละเอียด</label>
                            <textarea class="form-control mb-2" name="product_detail"></textarea>

                            <label>รูปภาพ <span class="text-danger">*</span></label>
                            <input type="file" class="form-control mb-2" name="product_picture" id="imgAddInput" accept="image/*" required>

                            <div class="text-center mb-2">
                                <img id="previewImgAdd" src="" class="img-fluid rounded shadow-sm d-none" style="max-height: 200px;">
                            </div>

                            <label>ประเภท <span class="text-danger">*</span></label>
                            <select class="form-select mb-2" name="product_type_id" required>
                                <option value="" selected disabled>-- เลือกประเภท --</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>

                            <hr class="my-3">

                            <label>โปรโมชั่น</label>
                            <select class="form-select mb-2" name="event_id">
                                <option value="0">ไม่มี</option>
                                <option value="1">event 1</option>
                                <option value="2">event 2</option>
                            </select>

                            <button type="submit" class="btn btn-main w-100">บันทึกสินค้า</button>
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
                            <h1 class="modal-title fs-5">แก้ไข</h1>
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
                                <input type="file" class="form-control mb-2" name="product_picture" id="imgEditInput" accept="image/*">
                                <div class="text-center mb-2">
                                    <img id="previewImgEdit" src="" class="img-fluid rounded shadow-sm d-none" style="max-height: 200px;">
                                </div>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($_SESSION['success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                // ลบ single quote '...' ออก แล้วใช้ json_encode แทน
                text: <?php echo json_encode($_SESSION['success']); ?>,
                timer: 2000,
                showConfirmButton: false
            });
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>



    <?php if (isset($_SESSION['product_type_success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                // ลบ single quote '...' ออก แล้วใช้ json_encode แทน
                text: <?php echo json_encode($_SESSION['product_type_success']); ?>,
                timer: 2000,
                showConfirmButton: false
            });
        </script>
        <?php unset($_SESSION['product_type_success']); ?>
    <?php endif; ?>



    <?php if (isset($_SESSION['error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: <?php echo json_encode($_SESSION['error']); ?>
            });
        </script>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>



    <?php if (isset($_SESSION['product_type_input_error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: <?php echo json_encode($_SESSION['product_type_input_error']); ?>
            });
        </script>
        <?php unset($_SESSION['product_type_input_error']); ?>
    <?php endif; ?>

    <script>
        const imgAddInput = document.getElementById('imgAddInput');
        const previewImgAdd = document.getElementById('previewImgAdd');

        if (imgAddInput) {
            imgAddInput.onchange = evt => {
                const [file] = imgAddInput.files;
                if (file) {
                    if (previewImgAdd.src.startsWith('blob:')) {
                        URL.revokeObjectURL(previewImgAdd.src);
                    }

                    previewImgAdd.src = URL.createObjectURL(file);
                    previewImgAdd.classList.remove('d-none');
                }
            };
        }

        const addModal = document.getElementById('AddProduct');
        if (addModal) {
            addModal.addEventListener('hidden.bs.modal', function() {
                if (previewImgAdd.src.startsWith('blob:')) {
                    URL.revokeObjectURL(previewImgAdd.src);
                }
                previewImgAdd.src = '';
                previewImgAdd.classList.add('d-none');
                this.querySelector('form').reset();
            });
        }
    </script>

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