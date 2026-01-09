<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | Next Gen IT</title>
    <?php include('include/header.php') ?>
</head>

<body class="bg-dark">

    <?php include('include/navbar.php') ?>

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-8">

                <div class="card border-0 shadow-lg mt-custom">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-primary">Order Status</h3>
                            <p class="text-muted">ตรวจสอบสถานะคำสั่งซื้อของคุณ</p>
                        </div>

                        <form class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control"
                                    placeholder="กรอกหมายเลขคำสั่งซื้อ เช่น NGIT-2026XXXX">
                                <button class="btn btn-primary">ตรวจสอบ</button>
                            </div>
                        </form>

                        <div class="border rounded p-4 bg-light">

                            <div class="text-center mb-3">
                                <span class="badge bg-success fs-6 px-3 py-2">กำลังจัดส่ง</span>
                            </div>

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>หมายเลขคำสั่งซื้อ</span>
                                    <strong>NGIT-20260025</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>ชื่อลูกค้า</span>
                                    <strong>Somchai</strong>
                                </li>
                                
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>วันที่สั่งซื้อ</span>
                                    <strong>6 ม.ค. 2026</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Tracking</span>
                                    <strong class="text-primary">TH234982374TH</strong>
                                </li>
                                <li class="list-group-item">
                                    <div class="fw-semibold mb-2">รายการสินค้า</div>
                                    <div class="table-responsive">
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
                                </li>
                            </ul>

                            <div class="mt-4">
                                <div class="progress" style="height: 12px;">
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                                        style="width:75%"></div>
                                </div>

                                <div class="d-flex justify-content-between mt-2 small text-muted">
                                    <span>รับออเดอร์</span>
                                    <span>กำลังแพ็ค</span>
                                    <span>กำลังจัดส่ง</span>
                                    <span>ถึงแล้ว</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include('include/footer.php') ?>

</body>

</html>