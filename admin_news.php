<?php

require_once __DIR__ . '/include/check_auth_admin.php';
require_once __DIR__ . '/function/admin/content_function.php';

$data = GetContent();

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
        <div class="card mt-custom p-3">
            <div class="card-body">
                <h4>จัดการข่าวสาร</h4>


                <form action="router/content.router.php" method="post" enctype="multipart/form-data">
                    <select class="form-select mb-2" name="content_key" >
                        <option value="" disabled selected>-- เลือกตำแหน่งที่ต้องการเปลี่ยน --</option>
                        <option value="news_1">ข่าวที่ 1 (ใหญ่ซ้าย)</option>
                        <option value="news_2">ข่าวที่ 2 (เล็กขวาบน)</option>
                        <option value="news_3">ข่าวที่ 3 (เล็กขวาล่าง)</option>
                        <hr>
                        <option value="banner_1">Banner 1</option>
                        <option value="banner_2">Banner 2</option>
                        <option value="banner_3">Banner 3</option>
                    </select>

                    <label>รูปภาพ (ถ้าไม่เปลี่ยนไม่ต้องเลือก)</label>
                    <input type="file" class="form-control mb-2" name="image">

                    <label>หัวข้อ</label>
                    <input type="text" class="form-control mb-2" name="title"  placeholder="ใส่หัวข้อข่าว...">

                    <label>รายละเอียด (สำหรับ Modal)</label>
                    <textarea class="form-control mb-2" name="description" rows="4" placeholder="ใส่เนื้อหาข่าว..."></textarea>

                    <button type="submit" class="btn btn-main w-100">อัปเดตข้อมูล</button>
                </form>


            </div>
        </div>
        <div class="row">
            <!-- ข่าวเด่น -->
            <div class="col-md-6">
                <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#newsModal1">
                    <div class="card my-3 border-0 shadow-sm overflow-hidden zoom-card"
                        style="height: 500px; position: relative; cursor: pointer;">
                        <img src="assets/images/news/<?php echo $data['news_1']['content_image']; ?>"
                            class="card-img object-fit-cover"
                            style="height: 100%; filter: brightness(80%); transition: transform 0.4s ease;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end text-white p-4"
                            style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);">
                            <h3 class="fw-bold"><?php echo $data['news_1']['content_title']; ?></h3>
                            <p class="mb-0"><?php echo $data['news_1']['content_description']; ?></p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- ข่าวรอง -->
            <div class="col-md-6">
                <div class="row my-3">
                    <!-- ข่าววงการเทค -->
                    <div class="col-md-6 mb-3 mb-md-0">
                        <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#newsModal2">
                            <div class="card border-0 shadow-sm overflow-hidden zoom-card"
                                style="height: 242px; position: relative; cursor: pointer;">
                                <img src="assets/images/news/<?php echo $data['news_2']['content_image']; ?>"
                                    class="card-img object-fit-cover"
                                    style="height: 100%; filter: brightness(75%); transition: transform 0.4s ease;">
                                <div class="card-img-overlay d-flex flex-column justify-content-end text-white p-3"
                                    style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);">
                                    <h5 class="fw-semibold mb-1"><?php echo $data['news_2']['content_title']; ?></h5>
                                    <small><?php echo $data['news_2']['content_description']; ?></small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- ข่าวกิจกรรม -->
                    <div class="col-md-6">
                        <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#newsModal3">
                            <div class="card border-0 shadow-sm overflow-hidden zoom-card"
                                style="height: 242px; position: relative; cursor: pointer;">
                                <img src="assets/images/news/<?php echo $data['news_3']['content_image']; ?>"
                                    class="card-img object-fit-cover"
                                    style="height: 100%; filter: brightness(75%); transition: transform 0.4s ease;">
                                <div class="card-img-overlay d-flex flex-column justify-content-end text-white p-3"
                                    style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);">
                                    <h5 class="fw-semibold mb-1"><?php echo $data['news_3']['content_title']; ?></h5>
                                    <small><?php echo $data['news_3']['content_description']; ?></small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- การ์ดเดิม -->
                <a href="#" class="text-decoration-none">
                    <div class="card my-3 border-0 shadow-sm overflow-hidden zoom-card"
                        style="height: 242px; position: relative;">
                        <img src="https://images.unsplash.com/photo-1579389083078-4e7018379f7e?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            class="card-img object-fit-cover"
                            style="height: 100%; filter: brightness(80%); transition: transform 0.4s ease;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end text-white p-3"
                            style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);">
                            <h5 class="fw-semibold mb-1">แจ้งข่าวสารให้ผู้ดูแล</h5>
                            <small>พบเจอปัญหา หรือ ติดต่อสอบถามข้อมูลเพิ่มเติม</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- MODALS -->
        <!-- ข่าว 1 -->
        <div class="modal fade" id="newsModal1" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo $data['news_1']['content_title']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <img src="assets/images/news/<?php echo $data['news_1']['content_image']; ?>"
                            class="img-fluid rounded mb-3" style="height: 400px; width: 100%;" alt="ข่าวเด่น">
                        <p><?php echo $data['news_1']['content_description']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ข่าว 2 -->
        <div class="modal fade" id="newsModal2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo $data['news_2']['content_title']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <img src="assets/images/news/<?php echo $data['news_2']['content_image']; ?>"
                            class="img-fluid rounded mb-3" style="height: 400px; width: 100%;" alt="ข่าวเทคโนโลยี">
                        <p><?php echo $data['news_2']['content_description']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ข่าว 3 -->
        <div class="modal fade" id="newsModal3" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo $data['news_3']['content_title']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <img src="assets/images/news/<?php echo $data['news_3']['content_image']; ?>"
                            class="img-fluid rounded mb-3" style="height: 400px; width: 100%;" alt="กิจกรรม">
                        <p><?php echo $data['news_3']['content_description']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <?php if (isset($_SESSION['error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: '<?php echo $_SESSION['error']; ?>',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    <?php
        unset($_SESSION['error']);
    endif; ?>


    <?php if (isset($_SESSION['success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                text: '<?php echo $_SESSION['success']; ?>',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    <?php
        unset($_SESSION['success']);
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

    <?php include('include/footer.php') ?>

</body>

</html>