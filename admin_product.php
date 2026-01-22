<?php

require_once 'include/check_auth_admin.php';

// นำเข้าไฟล์ Function ให้ครบ
require_once __DIR__ . '/function/admin/product_type_function.php';
require_once __DIR__ . '/function/admin/event_function.php';
require_once __DIR__ . '/function/admin/product_function.php'; // เพิ่มไฟล์นี้เพื่อดึงสินค้า

$q = $_GET['q'] ?? null;
$cat = $_GET['category'] ?? null;
$sort = $_GET['sort'] ?? 'latest';

// ดึงข้อมูล
$product_type_item = getAllProductTypes();
$all_products = GetAllProduct($q, $cat, $sort);

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

        <form method="get" class="mb-4">
            <div class="row g-2">
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">หมวดหมู่ทั้งหมด</option>
                        <?php foreach ($product_type_item as $type): ?>
                            <option value="<?php echo $type['product_type_id']; ?>"
                                <?php echo ($cat == $type['product_type_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($type['product_type_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="latest" <?php echo ($sort == 'latest') ? 'selected' : ''; ?>>เรียงตามสินค้าใหม่ล่าสุด</option>
                        <option value="price_low" <?php echo ($sort == 'price_low') ? 'selected' : ''; ?>>ราคา: ต่ำ - สูง</option>
                        <option value="price_high" <?php echo ($sort == 'price_high') ? 'selected' : ''; ?>>ราคา: สูง - ต่ำ</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="search" name="q" class="form-control"
                            placeholder="ค้นหาชื่อสินค้า, ประเภท หรือโปรโมชั่น..."
                            value="<?php echo htmlspecialchars($q ?? ''); ?>">
                        <button class="btn btn-main" type="submit"><i class="bi bi-search"></i></button>
                        <?php if ($q || $cat): ?>
                            <a href="admin_product.php" class="btn btn-outline-light"><i class="bi bi-x-circle"></i> ล้างค่า</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">

            <?php if (isset($all_products) && !empty($all_products)): ?>
                <?php foreach ($all_products as $row): ?>

                    <div class="col-md-3 mb-4">
                        <div class="card border-0 shadow-sm h-100 card-product">
                            <div style="height: 240px; overflow: hidden;">
                                <img src="assets/images/product/<?php echo $row['product_picture']; ?>"
                                    class="w-100 h-100 object-fit-cover rounded-top"
                                    alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                            </div>
                            <div class="card-body">
                                <h6 class="fw-bold mb-1 text-truncate"><?php echo htmlspecialchars($row['product_name']); ?></h6>
                                <?php if ($row['product_price'] != $row['final_price']): ?>
                                    <p class="text-main fw-semibold mb-0">ราคา <?php echo number_format($row['final_price']); ?> บาท</p>
                                    <p class="text-muted small mb-0 text-decoration-line-through"><?php echo number_format($row['product_price']); ?> บาท</p>
                                <?php else: ?>
                                    <p class="text-main fw-semibold mb-1">ราคา <?php echo number_format($row['final_price']); ?> บาท</p>
                                <?php endif; ?>
                                <small class="text-muted d-block">คงเหลือ <?php echo $row['product_qty']; ?> ชิ้น</small>

                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-warning w-100 mt-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editProduct_<?php echo $row['product_id']; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="router/manageproduct.router.php" method="POST" onsubmit="return confirmDeleteProduct(event, '<?php echo $row['product_id']; ?>');" id="delete-form-<?php echo $row['product_id']; ?>">
                                            <input type="hidden" name="delete_product_id" value="<?php echo $row['product_id']; ?>">
                                            <button type="submit" class="btn btn-danger w-100 mt-3">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editProduct_<?php echo $row['product_id']; ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h1 class="modal-title fs-5">แก้ไขสินค้า</h1>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="router/manageproduct.router.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="update_product_id" value="<?php echo $row['product_id']; ?>">
                                        <input type="hidden" name="btn_update_product" value="1">

                                        <label>ชื่อสินค้า</label>
                                        <input type="text" class="form-control mb-2" name="product_name"
                                            value="<?php echo htmlspecialchars($row['product_name']); ?>" required>

                                        <label>ราคา</label>
                                        <input type="number" class="form-control mb-2" name="product_price"
                                            value="<?php echo $row['product_price']; ?>" required>

                                        <label>จำนวน</label>
                                        <input type="number" class="form-control mb-2" name="product_qty"
                                            value="<?php echo $row['product_qty']; ?>" required>

                                        <label>รายละเอียด</label>
                                        <textarea class="form-control mb-2" name="product_detail" rows="3"><?php echo htmlspecialchars($row['product_detail']); ?></textarea>

                                        <label>รูปภาพเดิม</label>
                                        <div class="mb-2 text-center">
                                            <img src="assets/images/product/<?php echo $row['product_picture']; ?>"
                                                class="img-fluid rounded" style="max-height: 150px;">
                                        </div>

                                        <label>เปลี่ยนรูปภาพ (ถ้ามี)</label>
                                        <input type="file" class="form-control mb-2" name="product_picture" accept="image/*">
                                        <label>ประเภท</label>
                                        <select class="form-select mb-2" name="product_type_id" required>
                                            <option value="" disabled>เลือกประเภท</option>
                                            <?php foreach ($product_type_item as $type): ?>
                                                <option value="<?php echo $type['product_type_id']; ?>"
                                                    <?php echo ($row['product_type_id'] == $type['product_type_id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($type['product_type_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <hr class="my-3">

                                        <label>โปรโมชั่น</label>
                                        <select class="form-select mb-2" name="event_id">
                                            <option value="">ไม่มี</option>
                                            <?php foreach (getAllEvents() as $event): ?>
                                                <option value="<?php echo $event['event_id']; ?>"
                                                    <?php echo ($row['event_id'] == $event['event_id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($event['event_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <button type="submit" class="btn btn-warning w-100">บันทึกการแก้ไข</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-white mt-5">
                    <h3>ไม่พบรายการสินค้า</h3>
                </div>
            <?php endif; ?>

        </div>
    </div>


    <div class="modal fade" id="AddProduct">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">เพิ่มรายการสินค้า</h1>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="router/manageproduct.router.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="add_product" value="add">

                        <label>ชื่อสินค้า <span class="text-danger">*</span></label>
                        <input type="text" class="form-control mb-2" name="product_name">

                        <label>ราคา <span class="text-danger">*</span></label>
                        <input type="number" class="form-control mb-2" name="product_price">

                        <label>จำนวน <span class="text-danger">*</span></label>
                        <input type="number" class="form-control mb-2" name="product_qty">

                        <label>รายละเอียด</label>
                        <textarea class="form-control mb-2" name="product_detail"></textarea>

                        <label>รูปภาพ <span class="text-danger">*</span></label>
                        <input type="file" class="form-control mb-2" name="product_picture" id="imgAddInput" accept="image/*">

                        <div class="text-center mb-2">
                            <img id="previewImgAdd" src="" class="img-fluid rounded shadow-sm d-none" style="max-height: 200px;">
                        </div>

                        <label>ประเภท <span class="text-danger">*</span></label>
                        <select class="form-select mb-2" name="product_type_id">
                            <option value="" selected disabled>-- เลือกประเภท --</option>
                            <?php foreach ($product_type_item as $item): ?>
                                <option value="<?php echo $item['product_type_id']; ?>"><?php echo htmlspecialchars($item['product_type_name']); ?></option>
                            <?php endforeach; ?>
                        </select>

                        <hr class="my-3">

                        <label>โปรโมชั่น</label>
                        <select class="form-select mb-2" name="event_id">
                            <option value="">ไม่มี</option>
                            <?php foreach (getAllEvents() as $event_item): ?>
                                <option value="<?php echo $event_item['event_id']; ?>"><?php echo htmlspecialchars($event_item['event_name']); ?></option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit" class="btn btn-main w-100">บันทึกสินค้า</button>
                    </form>
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
                text: <?php echo json_encode($_SESSION['product_type_success']); ?>,
                timer: 2000,
                showConfirmButton: false
            });
        </script>
        <?php unset($_SESSION['product_type_success']); ?>
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
        // ... (ส่วน Reset Form Add เหมือนเดิม) ...
        const addModal = document.getElementById('AddProduct');
        if (addModal) {
            addModal.addEventListener('hidden.bs.modal', function() {
                // Reset form Logic
                const form = this.querySelector('form');
                if (form) form.reset();
                if (previewImgAdd) {
                    previewImgAdd.src = '';
                    previewImgAdd.classList.add('d-none');
                }
            });
        }
    </script>

    <script>
        function confirmDeleteProduct(e, eventId) {
            e.preventDefault(); // หยุดการทำงานปกติของปุ่ม

            Swal.fire({
                title: 'ยืนยันการลบ?',
                text: "คุณต้องการลบสินค้านี้หรือไม่?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'ใช่, ลบเลย',
                cancelButtonText: 'ยกเลิก',
                background: '#2b2b2b',
                color: '#ffffff',
                iconColor: '#f8bb86'
            }).then((result) => {
                if (result.isConfirmed) {
                    // สั่งให้ฟอร์มที่มี ID นั้นๆ ทำการ Submit
                    document.getElementById('delete-form-' + eventId).submit();
                }
            })
        }
    </script>

    <script>
        const addTypeModal = document.getElementById('AddProductType');
        if (addTypeModal) {
            addTypeModal.addEventListener('hidden.bs.modal', function() {
                const form = this.querySelector('form');
                if (form) form.reset();
            });
        }
    </script>

    <?php include('include/footer.php') ?>
</body>

</html>