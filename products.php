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

// Get search and filter parameters
$search = isset($_GET['q']) ? htmlspecialchars(trim($_GET['q'])) : '';
$product_type_id = isset($_GET['type']) ? intval($_GET['type']) : null;

// Get products based on search and filter
$all_products = GetProducts($search, $product_type_id);

// Get product types for dropdown
$product_types = GetProductTypes();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | Next Gen IT</title>
    <?php include('include/header.php') ?>
    <style>
        .modal-content {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            border: 1px solid #444;
        }

        #productDetailModal .modal-header {
            border-bottom: 2px solid #00cc18;
            padding: 1.5rem;
        }

        #productDetailModal .modal-title {
            color: #00cc18;
            font-weight: 700;
        }

        #productDetailModal .modal-body {
            padding: 1.5rem;
        }

        #productDetailModal h5 {
            color: #ffffff;
        }

        #productDetailModal h6 {
            color: #99ccff;
            font-weight: 600;
        }

        #productDetailModal p {
            color: #e0e0e0;
        }

        #productName {
            color: #ffffff;
            border-bottom: 2px solid #00cc18;
            padding-bottom: 1rem;
        }

        #productPrice {
            color: #00ff99;
            font-size: 1.5rem !important;
        }

        #productType, #productEvent {
            color: #99ccff;
            font-weight: 500;
        }

        #productDetail {
            background-color: rgba(0, 0, 0, 0.3);
            padding: 1rem;
            border-left: 3px solid #00cc18;
            border-radius: 4px;
            color: #d0d0d0;
            line-height: 1.6;
        }

        #productDetailModal .modal-footer {
            border-top: 1px solid #444;
            padding: 1rem 1.5rem;
        }

        #productDetailModal .alert-info {
            background-color: rgba(0, 153, 204, 0.1);
            border: 1px solid #00cc18;
            color: #99ccff;
        }

        #productDetailModal .alert-info a {
            color: #00ff99;
            font-weight: 600;
        }

        #productImage {
            border: 2px solid #00cc18;
            box-shadow: 0 0 20px rgba(0, 153, 204, 0.5);
        }
    </style>
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

                <!-- ช่องค้นหา -->
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="search" name="q" class="form-control" placeholder="ค้นหาสินค้า..."
                            aria-label="ค้นหาสินค้า" value="<?php echo $search; ?>">
                            <?php
                                if (!empty($search) || !empty($product_type_id)){
                            ?>
                            <a href="products" class="btn btn-secondary"><i class="bi bi-x-circle"></i></a>
                            <?php }?>
                        <button class="btn btn-main" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Filter ประเภทสินค้า -->
                <div class="col-md-4">
                    <select name="type" class="form-select" onchange="this.form.submit()">
                        <option value="">ทุกประเภท</option>
                        <?php foreach ($product_types as $type): ?>
                            <option value="<?php echo $type['product_type_id']; ?>" 
                                <?php echo ($product_type_id == $type['product_type_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($type['product_type_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>
        </form>

        <!-- สินค้า -->
        <div class="row">
            <?php if (!empty($all_products)): ?>
                <?php foreach ($all_products as $product): ?>
                    <?php
                    $original_price = $product['product_price'];
                    $discount = $product['event_discount'] ?? 0;
                    $final_price = $original_price - $discount;
                    $has_discount = ($discount > 0);
                    $stock = $product['product_qty'];
                    ?>
                    <div class="col-md-3 mb-4">
                        <div class="card border-0 shadow-sm h-100 card-product position-relative overflow-hidden">

                            <?php if (!empty($product['event_name'])): ?>
                                <!-- Badge เข้าร่วมแคมเปญ -->
                                <span class="position-absolute top-0 end-0 m-2 badge bg-danger shadow-sm" style="z-index: 1;">
                                    <i class="bi bi-tag-fill me-1"></i> <?php echo $product['event_name']; ?>
                                </span>
                            <?php endif; ?>

                            <img src="assets/images/product/<?php echo $product['product_picture'] ?>"
                                class="w-100 object-fit-cover"
                                style="height: 240px;"
                                alt="<?php echo $product['product_name']; ?>">
                            
                            <div class="card-body d-flex flex-column">
                                <h6 class="fw-bold mb-1 text-truncate"><?php echo $product['product_name']; ?></h6>
                                
                                <!-- ราคา -->
                                <div class="mb-2">
                                    <?php if ($has_discount): ?>
                                        <p class="text-main fw-semibold mb-0">฿<?php echo number_format($final_price, 2); ?></p>
                                        <small class="text-muted text-decoration-line-through">฿<?php echo number_format($original_price, 2); ?></small>
                                    <?php else: ?>
                                        <p class="text-main fw-semibold mb-0">฿<?php echo number_format($original_price, 2); ?></p>
                                    <?php endif; ?>
                                </div>

                                <!-- สถานะสินค้า -->
                                <small class="text-muted d-block mb-2">
                                    <i class="bi bi-box-seam me-1"></i>
                                    <span class="<?php echo $stock <= 5 ? 'text-danger fw-bold' : ''; ?>">
                                        คงเหลือ <?php echo $stock; ?> ชิ้น
                                    </span>
                                </small>

                                <div class="mt-auto">
                                    <?php if ($isUser): ?>
                                        <button class="btn btn-main w-100 btn-sm" data-bs-toggle="modal" 
                                            data-bs-target="#addToCartModal"
                                            onclick="prepareAddToCart(<?php echo $product['product_id']; ?>, '<?php echo htmlspecialchars($product['product_name']); ?>')">
                                            เพิ่มลงตะกร้า <i class="bi bi-cart-plus"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-outline-info w-100 btn-sm" data-bs-toggle="modal" 
                                            data-bs-target="#productDetailModal"
                                            onclick="loadProductDetail(<?php echo $product['product_id']; ?>)">
                                            <i class="bi bi-eye"></i> ดูรายละเอียด
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        ไม่มีสินค้าในขณะนี้
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Product Detail Modal -->
    <div class="modal fade" id="productDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="productTitle">รายละเอียดสินค้า</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="productImage" src="" alt="สินค้า" class="w-100 rounded" style="max-height: 300px; object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <h5 id="productName" class="fw-bold mb-3"></h5>
                            
                            <div class="mb-3">
                                <h6 class="text-muted">ราคา</h6>
                                <p id="productPrice" class="text-main fw-semibold fs-5 mb-0"></p>
                                <p id="productOriginalPrice" class="text-muted text-decoration-line-through small"></p>
                            </div>

                            <div class="mb-3">
                                <h6 class="text-muted">ประเภท</h6>
                                <p id="productType" class="mb-0"></p>
                            </div>

                            <div class="mb-3">
                                <h6 class="text-muted">คงเหลือ</h6>
                                <p id="productStock" class="mb-0"></p>
                            </div>

                            <div class="mb-3">
                                <h6 class="text-muted">โปรโมชั่น</h6>
                                <p id="productEvent" class="mb-0">-</p>
                            </div>

                            <div class="alert alert-info mt-3 mb-0">
                                <small>กรุณา <a href="login.php" class="text-decoration-none">เข้าสู่ระบบ</a> เพื่อสั่งซื้อสินค้า</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div>
                        <h6 class="text-muted">รายละเอียดสินค้า</h6>
                        <p id="productDetail"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    function loadProductDetail(productId) {
        // ค้นหาข้อมูลสินค้า
        const products = <?php echo json_encode($all_products); ?>;
        const product = products.find(p => p.product_id == productId);

        if (!product) {
            Swal.fire({
                icon: 'error',
                title: 'ผิดพลาด',
                text: 'ไม่พบสินค้า',
                confirmButtonColor: '#d33'
            });
            return;
        }

        // คำนวณราคา
        const originalPrice = parseFloat(product.product_price);
        const discount = parseFloat(product.event_discount || 0);
        const finalPrice = originalPrice - discount;

        // อัปเดต modal
        document.getElementById('productTitle').textContent = product.product_name;
        document.getElementById('productImage').src = 'assets/images/product/' + product.product_picture;
        document.getElementById('productName').textContent = product.product_name;
        
        if (discount > 0) {
            document.getElementById('productPrice').textContent = '฿' + finalPrice.toFixed(2);
            document.getElementById('productOriginalPrice').textContent = '฿' + originalPrice.toFixed(2);
        } else {
            document.getElementById('productPrice').textContent = '฿' + originalPrice.toFixed(2);
            document.getElementById('productOriginalPrice').textContent = '';
        }

        document.getElementById('productType').textContent = product.product_type_name || '-';
        
        const stock = parseInt(product.product_qty);
        const stockText = stock <= 5 ? 
            '<span class="text-danger fw-bold">คงเหลือ ' + stock + ' ชิ้น</span>' : 
            'คงเหลือ ' + stock + ' ชิ้น';
        document.getElementById('productStock').innerHTML = stockText;

        document.getElementById('productEvent').textContent = product.event_name ? 
            product.event_name + ' (-฿' + discount.toFixed(2) + ')' : '-';

        document.getElementById('productDetail').textContent = product.product_detail || 'ไม่มีรายละเอียด';
    }

    // Add to Cart Modal
    let currentProductId = null;

    function prepareAddToCart(productId, productName) {
        currentProductId = productId;
        document.getElementById('addToCartModalLabel').textContent = productName;
        document.getElementById('addQuantity').value = 1;
    }

    function addToCart() {
        const quantity = parseInt(document.getElementById('addQuantity').value);

        if (quantity <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'ผิดพลาด',
                text: 'กรุณากรอกจำนวนสินค้า',
                confirmButtonColor: '#0099cc'
            });
            return;
        }

        const formData = new FormData();
        formData.append('quantity', quantity);

        fetch(`router/cart.router.php?action=add&id=${currentProductId}`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: data.message,
                    confirmButtonColor: '#0099cc',
                    timer: 2000
                });
                bootstrap.Modal.getInstance(document.getElementById('addToCartModal')).hide();
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
                text: 'เกิดข้อผิดพลาดในการเพิ่มสินค้า',
                confirmButtonColor: '#0099cc'
            });
        });
    }
    </script>

    <!-- Add to Cart Modal -->
    <div class="modal fade" id="addToCartModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light" style="border: 1px solid #0099cc; border-radius: 12px;">
                <div class="modal-header" style="background: linear-gradient(90deg, #0099cc 0%, #00ccff 100%); border: none; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title" id="addToCartModalLabel" style="color: #ffffff; font-weight: 700;">เพิ่มลงตะกร้า</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 2rem;">
                    <div class="mb-3">
                        <label for="addQuantity" class="form-label" style="color: #99ccff; font-weight: 600;">จำนวน</label>
                        <input type="number" class="form-control" id="addQuantity" min="1" max="999" value="1"
                            style="background-color: #1a1a1a; border-color: #0099cc; color: #00ff99; font-weight: 700; text-align: center;">
                    </div>
                    <small class="text-muted">ระบุจำนวนสินค้าที่ต้องการเพิ่มลงตะกร้า</small>
                </div>
                <div class="modal-footer" style="background: rgba(0, 153, 204, 0.08); border-top: 2px solid #0099cc;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-main" onclick="addToCart()">
                        <i class="bi bi-cart-plus me-2"></i>เพิ่มลงตะกร้า
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include('include/footer.php') ?>

</body>

</html>