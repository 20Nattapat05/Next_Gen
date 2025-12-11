<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next Gen IT</title>
    <?php include('include/header.php') ?>
    <style>
    .posit-account {
        top: -120px;
        left: 200px;
    }

    @media screen and (max-width: 768px) {
        .posit-account {
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
        }
    }
    </style>
</head>

<body class="bg-dark">
    <?php include('include/navbar_admin.php') ?>
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card mt-custom text-center pb-3 pt-5">
                    <center>
                        <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?auto=format&fit=crop&w=800&q=80"
                            class="object-fit-cover rounded-circle position-absolute posit-account"
                            style="height: 250px; width: 250px;">
                    </center>
                    <div class="card-body pt-5">
                        <h4 class="mt-3 mb-2 pt-5">Fullname Lastname</h4>
                        <h6 class="mb-3 text-muted">Status: Admin</h6>
                        <h5 class="mb-3">Email: </h5>
                        <h5 class="mb-5">Phone: </h5>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-warning w-100" data-bs-toggle="modal"
                                            data-bs-target="#editaccount">แก้ไขบัญชี</a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-primary w-100" data-bs-toggle="modal"
                                            data-bs-target="#editpassword">แก้ไขรหัสผ่าน</a>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-danger w-100 my-2">ออกจากระบบ</a>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editaccount">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">แก้ไขบัญชี</h1>
                        <button class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <label for="">ชื่อ</label>
                            <input type="text" class="form-control mb-2" name="" id="" required>
                            <label for="">นามสกุล</label>
                            <input type="text" class="form-control mb-2" name="" id="" required>
                            <label for="">Email</label>
                            <input type="text" class="form-control mb-2" name="" id="" required>
                            <label for="">Phone</label>
                            <input type="text" class="form-control mb-2" name="" id="" required>
                            <label for="">รูปภาพ</label>
                            <input type="file" class="form-control mb-2" name="" id="" required>
                            <button type="submit" class="btn btn-main w-100">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="editpassword">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">แก้ไขรหัสผ่าน</h1>
                        <button class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <label for="">รหัสผ่านเก่า</label>
                            <input type="text" class="form-control mb-2" name="" id="" required>
                            <label for="">รหัสผ่านใหม่</label>
                            <input type="text" class="form-control mb-2" name="" id="" required>
                            <label for="">ยืนยันรหัสผ่าน</label>
                            <input type="text" class="form-control mb-2" name="" id="" required>
                            <button type="submit" class="btn btn-main w-100">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include('include/footer.php') ?>
</body>

</html>