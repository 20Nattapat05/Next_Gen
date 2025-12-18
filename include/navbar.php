<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow py-3 fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-banner" href="#">NEXT GEN IT</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link mx-1" href="/Nextgen_it/">หน้าแรก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-1" href="products">รายการสินค้า</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-1" href="contact">ติดต่อเรา</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-1" href="#" data-bs-toggle="modal" data-bs-target="#cart">ตะกร้า</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-main ms-1" href="login">เข้าสู่ระบบ</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade" id="cart" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">🛒 ตะกร้าสินค้า</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>สินค้า</th>
                            <th>ราคา</th>
                            <th>จำนวน</th>
                            <th>รวม</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>เสื้อยืด</td>
                            <td>250</td>
                            <td>
                                <span class="badge bg-main">1</span>
                            </td>
                            <td>250</td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger">ลบ</button>
                            </td>
                        </tr>

                        <tr>
                            <td>กางเกงยีนส์</td>
                            <td>890</td>
                            <td>
                                <span class="badge bg-main">2</span>
                            </td>
                            <td>1780</td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger">ลบ</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <!-- Footer -->
            <div class="modal-footer justify-content-between">
                <h5 class="mb-0">รวมทั้งหมด: <strong>2,030</strong> บาท</h5>
                <button class="btn btn-success">ชำระเงิน</button>
            </div>

        </div>
    </div>
</div>