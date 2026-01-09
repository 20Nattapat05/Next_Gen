<?php

require_once 'include/check_auth_admin.php';

require_once __DIR__ . '/function/admin/event_function.php';

$event = GetAllEvents();

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
                <div class="card shadow-sm" style="height: 244px; overflow-y: auto;">
                    <div class="card-body">
                        <h4>Event</h4>
                        <!-- add -->
                        <form action="router/manageevent.router.php" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="event_name" id=""
                                        placeholder="ชื่ออีเว้นท์">
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" name="event_discount" id=""
                                        placeholder="ลดราคา %" min="0" max="100">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-main w-100">+ เพิ่ม</button>
                                </div>
                            </div>
                        </form>
                        <!-- start-loop -->

                        <?php

                        if (!empty($event)) {
                            foreach ($event as $event_item) {

                        ?>
                        <div class="card my-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5 my-auto">
                                        <h6 class="mb-0"><?php echo htmlspecialchars($event_item['event_name']); ?></h6>
                                    </div>
                                    <div class="col-md-3 my-auto">
                                        <h6 class="mb-0"><?php echo htmlspecialchars($event_item['event_discount']); ?>%
                                        </h6>
                                    </div>
                                    <div class="col-md-2 my-auto">
                                        <h6 class="mb-0"><?php echo htmlspecialchars($event_item['total_products']); ?>
                                            รายการ</h6>
                                    </div>
                                    <div class="col-md-2">
                                        <form id="delete-form-<?php echo $event_item['event_id']; ?>"
                                            action="router/manageevent.router.php" method="post">
                                            <button type="button"
                                                onclick="confirmDelete(event, <?php echo $event_item['event_id']; ?>)"
                                                class="btn btn-sm btn-danger w-100">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                            <input type="hidden" name="delete_event_id"
                                                value="<?php echo $event_item['event_id']; ?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                            }
                        }

                        ?>
                        <!-- end-loop -->
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

    <?php if (isset($_SESSION['event_input_error'])): ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด',
        text: '<?php echo $_SESSION['event_input_error']; ?>',
        timer: 2000,
        showConfirmButton: false
    });
    </script>
    <?php
        unset($_SESSION['event_input_error']);
    endif; ?>

    <?php if (isset($_SESSION['event_success'])): ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'สำเร็จ',
        text: '<?php echo $_SESSION['event_success']; ?>',
        timer: 2000,
        showConfirmButton: false
    });
    </script>
    <?php
        unset($_SESSION['event_success']);
    endif; ?>

    <script>
    function confirmDelete(e, eventId) {
        e.preventDefault(); // หยุดการทำงานปกติของปุ่ม

        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "คุณต้องการลบงานกิจกรรมนี้ใช่หรือไม่",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'ใช่, ลบงานกิจกรรม',
            cancelButtonText: 'ยกเลิก',
            background: '#2b2b2b',
            color: '#ffffff',
            iconColor: '#f8bb86'
        }).then((result) => {
            if (result.isConfirmed) {
                // สั่งให้ฟอร์มที่มี ID นั้นๆ ทำการ Submit
                document.getElementById('delete-form-' + eventId).submit();
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
</body>



</html>