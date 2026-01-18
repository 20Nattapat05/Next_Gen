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
                                <h2 class="mb-0"><?php echo htmlspecialchars($_SESSION['admin_fname'] . ' ' . $_SESSION['admin_sname'] ?? 'Admin'); ?>
                                </h2>
                                <h5><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'admin'); ?> <span class="mx-2">|</span> ผู้ดูแลระบบ</h5>
                                <hr>
                                <h5>อีเมล: <?php echo htmlspecialchars($_SESSION['admin_email'] ?? ''); ?></h5>
                                <?php else: ?>
                                <h2 class="mb-0"><?php echo htmlspecialchars($_SESSION['user_fullname'] ?? 'ผู้ใช้'); ?>
                                </h2>
                                <h5><?php echo htmlspecialchars($_SESSION['user_username'] ?? ''); ?> <span
                                        class="mx-2">|</span> ลูกค้า</h5>
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
                        <a href="#" class="btn btn-outline-success w-100 mb-1" data-bs-toggle="modal"
                            data-bs-target="#addAddressModal">จัดการที่อยู่</a>
                        <?php endif; ?>
                        <button class="btn btn-outline-primary w-100 my-1" data-bs-toggle="modal"
                            data-bs-target="#editProfileModal">
                            แก้ไขบัญชี
                        </button>
                        <button class="btn btn-outline-warning w-100 my-1" data-bs-toggle="modal"
                            data-bs-target="#changePasswordModal">
                            แก้ไขรหัสผ่าน
                        </button>
                        <button type="button" onclick="confirmLogout()"
                            class="btn btn-danger w-100 mt-1">ออกจากระบบ</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- แก้ไขข้อมูล Modal -->
        <div class="modal fade" id="editProfileModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h5 class="modal-title">แก้ไขข้อมูลบัญชี</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="editProfileForm">
                        <input type="hidden" name="action" value="update_info">
                        <div class="modal-body">
                            <?php if($isUser): ?>
                                <div class="mb-3">
                                    <label class="form-label">ชื่อ-นามสกุล</label>
                                    <input type="text" name="fullname" class="form-control"
                                        placeholder="กรอกชื่อ-นามสกุลใหม่" value="<?php echo htmlspecialchars($_SESSION['user_fullname'] ?? ''); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ชื่อผู้ใช้</label>
                                    <input type="text" name="username" class="form-control"
                                        placeholder="กรอกชื่อผู้ใช้ใหม่" value="<?php echo htmlspecialchars($_SESSION['user_username'] ?? ''); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">อีเมล</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="กรอกอีเมลใหม่" value="<?php echo htmlspecialchars($_SESSION['user_email'] ?? ''); ?>" required>
                                </div>
                            <?php else: ?>
                                <div class="mb-3">
                                    <label class="form-label">ชื่อผู้ใช้</label>
                                    <input type="text" name="username" class="form-control"
                                        placeholder="กรอกชื่อผู้ใช้ใหม่" value="<?php echo htmlspecialchars($_SESSION['admin_username'] ?? ''); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">อีเมล</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="กรอกอีเมลใหม่" value="<?php echo htmlspecialchars($_SESSION['admin_email'] ?? ''); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ชื่อจริง</label>
                                    <input type="text" name="fname" class="form-control"
                                        placeholder="กรอกชื่อจริงใหม่" value="<?php echo htmlspecialchars($_SESSION['admin_fname'] ?? ''); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">นามสกุล</label>
                                    <input type="text" name="sname" class="form-control"
                                        placeholder="กรอกนามสกุลใหม่" value="<?php echo htmlspecialchars($_SESSION['admin_sname'] ?? ''); ?>" required>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-success">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- เปลี่ยนรหัสผ่าน Modal -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h5 class="modal-title">เปลี่ยนรหัสผ่าน</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="changePasswordForm">
                        <input type="hidden" name="action" value="update_password">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>รหัสผ่านเดิม</label>
                                <input type="password" name="old_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>รหัสผ่านใหม่</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>ยืนยันรหัสผ่านใหม่</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-warning">เปลี่ยนรหัสผ่าน</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>




        

        <div class="modal fade" id="addAddressModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่มที่อยู่ใหม่</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="addAddressForm" action="/Next_Gen/router/add_address.router.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-2">
                                <label>ชื่อที่อยู่</label>
                                <input type="text" name="address_name" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label>ชื่อผู้รับ</label>
                                <input type="text" name="recipient_name" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label>เบอร์โทรผู้รับ</label>
                                <input type="text" name="recipient_phone" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label>รายละเอียดที่อยู่</label>
                                <textarea name="address_detail" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-2">
                                <label>รหัสไปรษณีย์</label>
                                <input type="text" name="postal_code" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-success">เพิ่มที่อยู่</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        <?php if (!$isAdmin): 
            require_once __DIR__ . '/function/user/address_function.php';
            $addresses = GetAddressesByUserId($_SESSION['user_id']);
        ?>
        <div class="row mt-3">
            <?php if (empty($addresses)): ?>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <p>ไม่มีที่อยู่ กรุณาเพิ่มที่อยู่</p>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <?php foreach ($addresses as $address): ?>
            <div class="col-md-3">
                <div class="card my-3">
                    <div class="card-body">
                        <h5><?php echo htmlspecialchars($address['address_name']); ?></h5>
                        <hr>
                        <h6>ผู้รับ: <?php echo htmlspecialchars($address['recipient_name']); ?></h6>
                        <h6>โทร: <?php echo htmlspecialchars($address['recipient_phone']); ?></h6>
                        <h6><?php echo htmlspecialchars($address['address_detail']); ?></h6>
                        <h6>รหัสไปรษณีย์: <?php echo htmlspecialchars($address['postal_code']); ?></h6>
                        <hr>
                        <a href="#" class="btn btn-danger btn-sm w-100" onclick="deleteAddressFromPage(<?php echo $address['address_id']; ?>)">ลบ</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (isset($_SESSION['success'])) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: '" . addslashes($_SESSION['success']) . "',
                    showConfirmButton: true
                });
            });
        </script>";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด',
                    text: '" . addslashes($_SESSION['error']) . "',
                    confirmButtonColor: '#d33'
                });
            });
        </script>";
        unset($_SESSION['error']);
    }
    ?>

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

    // Handle edit profile form
    document.getElementById('editProfileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('router/account.router.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network error: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: data.message,
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    location.reload();
                });
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด',
                    text: data.message,
                    confirmButtonColor: '#d33'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถสื่อสารกับเซิร์ฟเวอร์: ' + error.message,
                confirmButtonColor: '#d33'
            });
        });
    });

    // Handle change password form
    document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const newPassword = this.querySelector('[name="new_password"]').value;
        const confirmPassword = this.querySelector('[name="confirm_password"]').value;
        
        if (newPassword !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'ผิดพลาด',
                text: 'รหัสผ่านใหม่ไม่ตรงกัน',
                confirmButtonColor: '#d33'
            });
            return;
        }
        
        const formData = new FormData(this);
        
        fetch('router/account.router.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network error: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: data.message,
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    location.reload();
                });
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('changePasswordModal')).hide();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด',
                    text: data.message,
                    confirmButtonColor: '#d33'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถสื่อสารกับเซิร์ฟเวอร์: ' + error.message,
                confirmButtonColor: '#d33'
            });
        });
    });
    </script>

    <script>
    /*
    document.getElementById('addAddressForm').addEventListener('submit', function(e) {
        // Form submits naturally now
    });
    */

    

    

    function deleteAddressFromPage(addressId) {
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "คุณต้องการลบที่อยู่นี้ใช่หรือไม่",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'ใช่, ลบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('router/delete_address.router.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ address_id: addressId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('สำเร็จ', 'ลบที่อยู่แล้ว', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('ผิดพลาด', data.message, 'error');
                    }
                });
            }
        });
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
