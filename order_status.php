<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>คำสั่งซื้อของฉัน | Next Gen IT</title>

    <?php include('include/header.php'); ?>
</head>

<body class="bg-dark">

    <?php include('include/navbar.php'); ?>

    <div class="container py-5">
        <div class="row justify-content-center mt-custom">
            <div class="col-lg-10">

                <!-- ===== Header + Filter ===== -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold text-primary mb-0">คำสั่งซื้อของฉัน</h3>

                    <select id="orderFilter" class="form-select w-auto">
                        <option value="all">ทั้งหมด</option>
                        <option value="shipping">กำลังจัดส่ง</option>
                        <option value="delivered">ส่งแล้ว</option>
                    </select>
                </div>

                <!-- ===== Order List ===== -->
                <div class="order-list">

                    <!-- ================= ORDER 1 ================= -->
                    <div class="card shadow-sm mb-4 order-item" data-status="shipping">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <strong class="fs-5">NGIT-20260025</strong>
                                    <div class="text-muted small">วันที่สั่งซื้อ: 6 ม.ค. 2026</div>
                                </div>
                                <span class="badge bg-warning text-dark fs-6">กำลังจัดส่ง</span>
                            </div>

                            <!-- รายการสินค้า -->
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered table-sm align-middle text-center mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>สินค้า</th>
                                            <th>จำนวน</th>
                                            <th>ราคา/ชิ้น</th>
                                            <th>รวม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Gaming Keyboard RGB</td>
                                            <td>1</td>
                                            <td>1,290 ฿</td>
                                            <td>1,290 ฿</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Gaming Mouse</td>
                                            <td>1</td>
                                            <td>590 ฿</td>
                                            <td>590 ฿</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="4" class="text-end">ยอดรวมทั้งหมด</th>
                                            <th class="text-success">1,880 ฿</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Shipping -->
                            <div class="mb-3">
                                <strong>บริษัทขนส่ง:</strong>
                                <span class="badge bg-primary">Thailand Post</span><br>
                                <strong>Tracking:</strong>
                                <a href="#" class="text-primary text-decoration-none fw-semibold">
                                    TH234982374TH
                                </a>
                            </div>

                            <!-- Progress (3 Steps) -->
                            <div>
                                <div class="progress" style="height:12px;">
                                    <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated"
                                        style="width:100%"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2 small text-muted">
                                    <span>รับออเดอร์</span>
                                    <span>แพ็คสินค้า</span>
                                    <span>กำลังจัดส่ง</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ================= ORDER 2 ================= -->
                    <div class="card shadow-sm mb-4 order-item" data-status="delivered">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <strong class="fs-5">NGIT-20260018</strong>
                                    <div class="text-muted small">วันที่สั่งซื้อ: 1 ม.ค. 2026</div>
                                </div>
                                <span class="badge bg-success fs-6">ส่งแล้ว</span>
                            </div>

                            <div class="table-responsive mb-3">
                                <table class="table table-bordered table-sm align-middle text-center mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>สินค้า</th>
                                            <th>จำนวน</th>
                                            <th>ราคา/ชิ้น</th>
                                            <th>รวม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Gaming Headset</td>
                                            <td>1</td>
                                            <td>2,450 ฿</td>
                                            <td>2,450 ฿</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="4" class="text-end">ยอดรวมทั้งหมด</th>
                                            <th class="text-success">2,450 ฿</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div>
                                <strong>บริษัทขนส่ง:</strong>
                                <span class="badge bg-success">Kerry Express</span><br>
                                <strong>Tracking:</strong>
                                <a href="#" class="text-success text-decoration-none fw-semibold">
                                    KER123456789
                                </a>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <?php include('include/footer.php'); ?>

    <!-- ===== Filter Script ===== -->
    <script>
    const filter = document.getElementById('orderFilter');
    const orders = document.querySelectorAll('.order-item');

    filter.addEventListener('change', function() {
        const value = this.value;

        orders.forEach(order => {
            if (value === 'all' || order.dataset.status === value) {
                order.style.display = 'block';
            } else {
                order.style.display = 'none';
            }
        });
    });
    </script>

</body>

</html>