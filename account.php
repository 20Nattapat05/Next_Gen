<?php

// Check if user or admin is logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = isset($_SESSION['admin_id']);
$isUser = isset($_SESSION['user_id']);

// Redirect to login if not logged in
if (!$isAdmin && !$isUser) {
    header('Location: /Next_Gen/login');
    exit();
}

// If admin, use admin navbar
$navbar_file = $isAdmin ? 'include/navbar_admin.php' : 'include/navbar.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next Gen IT</title>
    <?php include('include/header.php') ?>
    <style>
    .h-account {
        height: 180px;
    }

    @media only screen and (max-width: 768px) {
        .h-account {
            height: 350px;
        }
    }
    </style>
</head>

<body class="bg-dark">
    <?php include($navbar_file) ?>
    <div class="container">
        <div class="row mt-custom">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="assets/images/banner.jpg" alt="Profile"
                                    class="w-100 rounded-circle object-fit-cover h-account">
                            </div>
                            <div class="col-md-9 my-auto">
                                <?php if ($isAdmin): ?>
                                    <h2 class="mb-0"><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></h2>
                                    <h5>ผู้ดูแลระบบ</h5>
                                    <hr>
                                    <h5>บัญชี: admin</h5>
                                <?php else: ?>
                                    <h2 class="mb-0"><?php echo htmlspecialchars($_SESSION['user_fullname'] ?? 'ผู้ใช้'); ?></h2>
                                    <h5><?php echo htmlspecialchars($_SESSION['user_username'] ?? ''); ?> <span class="mx-2">|</span> ลูกค้า</h5>
                                    <hr>
                                    <h5>อีเมล: <?php echo htmlspecialchars($_SESSION['user_email'] ?? ''); ?></h5>
                                    <h5>สถานะ: <?php echo htmlspecialchars($_SESSION['user_status'] ?? 'ปกติ'); ?></h5>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <?php if (!$isAdmin): ?>
                            <a href="#" class="btn btn-outline-success w-100 mb-1">จัดการที่อยู่</a>
                        <?php endif; ?>
                        <a href="#" class="btn btn-outline-primary w-100 my-1">แก้ไขบัญชี</a>
                        <a href="#" class="btn btn-outline-warning w-100 my-1">แก้ไขรหัสผ่าน</a>
                        <button type="button" onclick="confirmLogout()" class="btn btn-danger w-100 mt-1">ออกจากระบบ</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card my-3">
                    <div class="card-body">
                        <h5>ที่อยู่ 1</h5>
                        <hr>
                        <h6>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Hic, neque!</h6>
                        <h6 class="fw-bold mt-3">รายละเอียดเพิ่มเติม</h6>
                        <h6>Lorem ipsum dolor</h6>
                        <hr>
                        <a href="#" class="btn btn-danger btn-sm w-100">ลบ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmLogout() {
    Swal.fire({
        title: 'ยืนยันการออกจากระบบ?',
        text: "คุณต้องการออกจากระบบ Next Gen IT ใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', 
        cancelButtonColor: '#6c757d', 
        confirmButtonText: 'ใช่, ออกจากระบบ',
        cancelButtonText: 'ยกเลิก',
        // ตกแต่งให้เข้ากับธีม Dark
        background: '#2b2b2b',
        color: '#ffffff',
        iconColor: '#f8bb86'
    }).then((result) => {
        if (result.isConfirmed) {
            // ส่งไปที่ไฟล์ Logout Router
            window.location.href = 'router/logout.router.php';
        }
    })
}
</script>

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

    <?php include('include/footer.php') ?>
</body>

</html>