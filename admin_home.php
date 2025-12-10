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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-main mb-3">วันนี้</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="bg-main py-2 text-light rounded text-center">100 ชิ้น</h5>
                            </div>
                            <div class="col-md-6">
                                <h5 class="bg-main py-2 text-light rounded text-center">600 บาท</h5>
                            </div>
                        </div>
                    </div>
                </div>
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
</body>

</html>