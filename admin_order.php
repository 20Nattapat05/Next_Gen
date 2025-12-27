<?php

require_once 'include/check_auth_admin.php';

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
        <div class="row mt-custom">
            <div class="col-md-6">
                <div class="card" style="max-height: 630px; overflow-y: auto;">
                    <div class="card-body">
                        <h4>ออเดอร์เข้า</h4>
                        <div class="card shadow-sm my-2 card-admin">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 my-auto">
                                        <h6 class="mb-0">Full Name</h6>
                                    </div>
                                    <div class="col-md-4 my-auto">
                                        <h6 class="mb-0">500 บาท</h6>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#" class="btn btn-dark w-100 btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#order">เพิ่มเติม</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style="max-height: 630px; overflow-y: auto;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>ประวัติออเดอร์</h4>
                            </div>
                            <div class="col-md-4">
                                <form action="" method="post">
                                    <input type="date" class="form-control">
                                </form>
                            </div>
                        </div>
                        <div class="card shadow-sm my-2 card-admin">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 my-auto">
                                        <h6 class="mb-0">Full Name</h6>
                                    </div>
                                    <div class="col-md-4 my-auto">
                                        <h6 class="mb-0">500 บาท</h6>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#" class="btn btn-dark w-100 btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#history">เพิ่มเติม</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="history">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">แก้ไข title</h1>
                        <button class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="assets/images/slip.jpg" alt="slip" class="rounded w-100">
                        <h6 class="mt-4">สินค้าที่สั่ง (ชื่อคนสั่ง)</h6>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">สินค้า</th>
                                    <th scope="col">ราคา</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Otto</td>
                                    <td>300</td>
                                </tr>
                                <tr>
                                    <td>Thornton</td>
                                    <td>200</td>
                                </tr>
                                <tr>
                                    <td>ยอดรวม</td>
                                    <td>500</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="order">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">แก้ไข title</h1>
                        <button class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="assets/images/slip.jpg" alt="slip" class="rounded w-100">
                        <h6 class="mt-4">สินค้าที่สั่ง (ชื่อคนสั่ง)</h6>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">สินค้า</th>
                                    <th scope="col">ราคา</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Otto</td>
                                    <td>300</td>
                                </tr>
                                <tr>
                                    <td>Thornton</td>
                                    <td>200</td>
                                </tr>
                                <tr>
                                    <td>ยอดรวม</td>
                                    <td>500</td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="#" class="btn btn-danger btn-sm my-1 w-100">ยกเลิกออเดอร์</a>
                        <a href="#" class="btn btn-main btn-sm my-1 w-100">ยืนยันออเดอร์</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


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

        window.addE
    </script>

    <?php include('include/footer.php') ?>
</body>

</html>