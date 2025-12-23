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
    <title>Login | Next Gen IT</title>
    <?php include('include/header.php') ?>
</head>

<body class="bg-dark">

    <?php include('include/navbar.php') ?>

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-5">

                <div class="card border-0 shadow-lg">
                    <div class="card-body p-4 p-md-5">

                        <!-- โลโก้ / ชื่อระบบ -->
                        <div class="text-center mb-4">
                            <div class="mb-2">
                                <i class="bi bi-pc-display fs-1 text-main"></i>
                            </div>
                            <h4 class="fw-bold mb-0">เข้าสู่ระบบ</h4>
                            <small class="text-muted">สำหรับสมาชิก Next Gen IT</small>
                        </div>

                        <!-- ฟอร์ม Login -->
                        <form action="router/login.router.php" method="post">

                            <div class="mb-3">
                                <label for="username" class="form-label">อีเมล หรือ ชื่อผู้ใช้</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="กรอกอีเมลหรือชื่อผู้ใช้" required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">รหัสผ่าน</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="กรอกรหัสผ่าน" required>
                            </div>

                            <button type="submit" class="btn btn-main w-100">
                                <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบ
                            </button>

                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <small class="text-muted">
                                ยังไม่มีบัญชี?
                                <a href="register" class="text-main text-decoration-none fw-semibold">
                                    สมัครสมาชิกใหม่
                                </a>
                            </small>
                        </div>

                    </div>
                </div>

                <!-- ข้อความเล็กด้านล่าง -->
                <p class="text-center text-light small mt-3 mb-0">
                    * ใช้บัญชีนี้ในการติดตามออเดอร์ ดูประวัติการสั่งซื้อ และรับสิทธิ์โปรโมชั่นพิเศษ
                </p>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($_SESSION['login_error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'เข้าสู่ระบบไม่สำเร็จ',
                text: '<?php echo $_SESSION['login_error']; ?>',
                confirmButtonColor: '#d33'
            });
        </script>
    <?php
        unset($_SESSION['login_error']);
    endif; ?>

    <?php include('include/footer.php') ?>


</body>

</html>