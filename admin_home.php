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
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-main mb-3">ยอดขายประจำวันนี้</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="bg-main py-2 text-light rounded text-center">100 ชิ้น</h5>
                            </div>
                            <div class="col-md-6">
                                <h5 class="bg-main py-2 text-light rounded text-center">600 บาท</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-secondary">
                                    <div class="card-body">
                                        <h5 class="mb-3">รายรับทั้งหมด</h5>
                                        <h6 class="bg-dark py-2 text-light rounded text-center">15000 บาท</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-secondary">
                                    <div class="card-body">
                                        <h5 class="mb-3">จำนวนผู้ใช้งาน</h5>
                                        <h6 class="bg-dark py-2 text-light rounded text-center">100 คน</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm" style="height: 244px; overflow-y: auto;">
                    <div class="card-body">
                        <h4>Event</h4>
                        <!-- add -->
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="" id="" placeholder="ชื่ออีเว้นท์">
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" name="" id="" placeholder="ลดราคา %">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-main w-100">+ เพิ่ม</button>
                                </div>
                            </div>
                        </form>
                        <!-- start-loop -->
                        <div class="card my-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5 my-auto">
                                        <h6 class="mb-0">ชื่ออีเว้นท์</h6>
                                    </div>
                                    <div class="col-md-3 my-auto">
                                        <h6 class="mb-0">ลดราคา %</h6>
                                    </div>
                                    <div class="col-md-3 my-auto">
                                        <h6 class="mb-0">100 รายการ</h6>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end-loop -->
                    </div>
                </div>
            </div>
        </div>

        <div class="card my-3" style="max-height: 350px; overflow-y: auto;">
            <div class="card-body">
                <h4 class="text-main mb-3">คูปอง</h4>
                <!-- add -->
                <div class="card shadow-sm my-2 bg-secondary">
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="" required placeholder="ชื่อคูปอง">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="" required placeholder="รหัสคูปอง">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="" required
                                        placeholder="ราคาที่ลด - บาท">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="" required placeholder="จำนวน">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success w-100">+ เพิ่มคูปอง</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- start-loop -->
                <div class="card shadow-sm my-2 card-admin">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 my-auto">
                                <h6 class="mb-0">ชื่อคูปอง</h6>
                            </div>
                            <div class="col-md-3 my-auto">
                                <h6 class="mb-0 fw-bold">รหัสคูปอง</h6>
                            </div>
                            <div class="col-md-3 my-auto">
                                <h6 class="mb-0">ราคาที่ลด - บาท</h6>
                            </div>
                            <div class="col-md-2 my-auto">
                                <h6 class="mb-0">จำนวน - คน</h6>
                            </div>
                            <div class="col-md-1 my-auto">
                                <h6 class="mb-0 bg-danger text-light py-2 rounded text-center">5</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end-loop -->
            </div>
        </div>

        <div class="row mt-3">
            <!-- ข้อความ -->
            <div class="col-md-6">
                <div class="card card-admin-home-hight h-100">
                    <div class="card-body">
                        <h4 class="text-main mb-3">รายงานปัญหาจากลูกค้า</h4>
                        <div class="accordion" id="accordionExample">
                            <!-- start-loop -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo">
                                        (หัวข้อ)
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <h6>เนื้อหา</h6>
                                        <hr>
                                        <h6 class="fw-bold">ชื่อ - นามสกุล</h6>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h6>Email: Lorem ipsum dolor sit amet.</h6>
                                            </div>
                                            <div class="col-md-4">
                                                <h6>Phone: 012-345-6789</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end-loop -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-admin-home-hight h-100">
                    <div class="card-body">
                        <h4 class="text-main mb-3">จัดการสมาชิก</h4>
                        <div class="input-group">
                            <input type="search" name="q" class="form-control" placeholder="ค้นหาสมาชิก...">
                            <button class="btn btn-main" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <div class="card shadow-sm my-2 card-admin">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 my-auto">
                                        <h6 class="mb-0">ชื่อ - สกุล</h6>
                                    </div>
                                    <div class="col-md-6 my-auto">
                                        <h6 class="mb-0">Loremipsum@gmail.com</h6>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#" class="btn btn-sm btn-main w-100">ระงับ</a>
                                        <!-- <a href="#" class="btn btn-sm btn-secondary w-100">ปลด</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('include/footer.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($_SESSION['login_success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'เข้าสู่ระบบสำเร็จ',
                text: 'ยินดีต้อนรับเข้าสู่ระบบ Next Gen IT',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    <?php
        unset($_SESSION['login_success']);
    endif; ?>


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
</body>



</html>