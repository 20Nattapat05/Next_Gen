<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Next Gen IT</title>
    <?php include('include/header.php') ?>
</head>

<body class="bg-dark">

    <?php include('include/navbar.php') ?>

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100 mt-custom">
            <div class="col-md-6 col-lg-5">

                <div class="card border-0 shadow-lg">
                    <div class="card-body p-4 p-md-5">

                        <!-- หัวข้อ -->
                        <div class="text-center mb-4">
                            <div class="mb-2">
                                <i class="bi bi-person-plus-fill fs-1 text-main"></i>
                            </div>
                            <h4 class="fw-bold mb-0">สมัครสมาชิกใหม่</h4>
                            <small class="text-muted">สร้างบัญชีเพื่อใช้บริการ Next Gen IT</small>
                        </div>

                        <!-- ฟอร์มสมัครสมาชิก -->
                        <form action="router/register.router.php" method="post">
                            <!-- ชื่อ -->
                            <div class="mb-3">
                                <label for="fullname" class="form-label">ชื่อ–นามสกุล</label>
                                <input type="text" class="form-control" id="fullname" name="fullname"
                                    placeholder="เช่น สมชาย ใจดี">
                            </div>

                            <!-- อีเมล -->
                            <div class="mb-3">
                                <label for="email" class="form-label">อีเมล</label>
                                <input class="form-control" id="email" name="email"
                                    placeholder="name@example.com">
                            </div>

                            <!-- เบอร์โทร -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="0XXXXXXXXX">
                            </div>

                            <!-- ชื่อผู้ใช้ (ถ้าอยากให้มี) -->
                            <div class="mb-3">
                                <label for="username" class="form-label">ชื่อผู้ใช้</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="ตั้งชื่อผู้ใช้ของคุณ">
                            </div>

                            <!-- รหัสผ่าน -->
                            <div class="mb-3">
                                <label for="password" class="form-label">รหัสผ่าน</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="ตั้งรหัสผ่าน">
                                <small class="text-muted">
                                    อย่างน้อย 8 ตัวอักษร ผสมตัวเลข/ตัวอักษรให้ปลอดภัยขึ้น
                                </small>
                            </div>

                            <!-- ยืนยันรหัสผ่าน -->
                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">ยืนยันรหัสผ่าน</label>
                                <input type="password" class="form-control" id="password_confirm"
                                    name="password_confirm" placeholder="พิมพ์รหัสผ่านอีกครั้ง">
                            </div>

                            <button type="submit" class="btn btn-main w-100">
                                <i class="bi bi-person-check-fill me-1"></i> สมัครสมาชิก
                            </button>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <small class="text-muted">
                                มีบัญชีอยู่แล้ว?
                                <a href="login" class="text-main text-decoration-none fw-semibold">
                                    เข้าสู่ระบบ
                                </a>
                            </small>
                        </div>

                    </div>
                </div>

                <!-- ข้อความเล็กด้านล่าง -->
                <p class="text-center text-light small my-3">
                    สมัครสมาชิกเพื่อดูประวัติการสั่งซื้อ ติดตามสถานะออเดอร์ และรับสิทธิ์โปรโมชั่นพิเศษจากร้าน
                </p>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($_SESSION['register_error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: '<?php echo $_SESSION['register_error']; ?>',
                confirmButtonColor: '#d33'
            });
        </script>
        <?php unset($_SESSION['register_error']); ?>
    <?php endif; ?>



    <?php include('include/footer.php') ?>

</body>

</html>