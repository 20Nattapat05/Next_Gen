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
        <div class="card mt-custom p-3">
            <div class="card-body">
                <h4>จัดการข่าวสาร</h4>
                <form action="" method="post">
                    <select class="form-select mb-2" name="" id="">
                        <option value="">ข่าวที่ 1</option>
                        <option value="">ข่าวที่ 2</option>
                        <option value="">ข่าวที่ 3</option>
                        <option value="">Banner 1</option>
                        <option value="">Banner 2</option>
                        <option value="">Banner 3</option>
                    </select>
                    <!-- Banner มีแต่รูป -->
                    <label for="">รูปภาพ</label>
                    <input type="file" class="form-control mb-2" name="" required>
                    <label for="">หัวข้อ</label>
                    <input type="text" class="form-control mb-2" name="" required>
                    <label for="">รายละเอียด</label>
                    <textarea class="form-control mb-2" name="" required></textarea>
                    <button type="submit" class="btn btn-main w-100">บันทึก</button>
                </form>
            </div>
        </div>
        <div class="row">
            <!-- ข่าวเด่น -->
            <div class="col-md-6">
                <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#newsModal1">
                    <div class="card my-3 border-0 shadow-sm overflow-hidden zoom-card"
                        style="height: 500px; position: relative; cursor: pointer;">
                        <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?auto=format&fit=crop&w=800&q=80"
                            class="card-img object-fit-cover"
                            style="height: 100%; filter: brightness(80%); transition: transform 0.4s ease;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end text-white p-4"
                            style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);">
                            <h3 class="fw-bold">ข่าวเด่นวันนี้</h3>
                            <p class="mb-0">AI รุ่นใหม่กำลังเปลี่ยนโลกธุรกิจและการศึกษา</p>
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
                                <img src="https://images.unsplash.com/photo-1555949963-aa79dcee981c?auto=format&fit=crop&w=400&q=80"
                                    class="card-img object-fit-cover"
                                    style="height: 100%; filter: brightness(75%); transition: transform 0.4s ease;">
                                <div class="card-img-overlay d-flex flex-column justify-content-end text-white p-3"
                                    style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);">
                                    <h5 class="fw-semibold mb-1">เทคโนโลยีใหม่มาแรง</h5>
                                    <small>รู้ทันนวัตกรรมที่กำลังเปลี่ยนโลกในปีนี้</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- ข่าวกิจกรรม -->
                    <div class="col-md-6">
                        <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#newsModal3">
                            <div class="card border-0 shadow-sm overflow-hidden zoom-card"
                                style="height: 242px; position: relative; cursor: pointer;">
                                <img src="https://images.unsplash.com/photo-1522199710521-72d69614c702?auto=format&fit=crop&w=400&q=80"
                                    class="card-img object-fit-cover"
                                    style="height: 100%; filter: brightness(75%); transition: transform 0.4s ease;">
                                <div class="card-img-overlay d-flex flex-column justify-content-end text-white p-3"
                                    style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);">
                                    <h5 class="fw-semibold mb-1">กิจกรรมและเวิร์กช็อป</h5>
                                    <small>ร่วมเรียนรู้เทคโนโลยีล้ำสมัยกับผู้เชี่ยวชาญ</small>
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
                        <h5 class="modal-title">AI รุ่นใหม่กำลังเปลี่ยนโลกธุรกิจและการศึกษา</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?auto=format&fit=crop&w=800&q=80"
                            class="img-fluid rounded mb-3" alt="ข่าวเด่น">
                        <p>AI กำลังเข้ามามีบทบาทสำคัญในหลายอุตสาหกรรม ทั้งภาคธุรกิจ การศึกษา และภาครัฐ
                            การพัฒนาโมเดลใหม่ทำให้ระบบสามารถเรียนรู้ได้เร็วขึ้น
                            ตอบสนองความต้องการเฉพาะด้านได้ดียิ่งขึ้น...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ข่าว 2 -->
        <div class="modal fade" id="newsModal2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">เทคโนโลยีใหม่มาแรงในปีนี้</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <img src="https://images.unsplash.com/photo-1555949963-aa79dcee981c?auto=format&fit=crop&w=800&q=80"
                            class="img-fluid rounded mb-3" alt="ข่าวเทคโนโลยี">
                        <p>ปีนี้เทคโนโลยีอย่าง Quantum Computing, Generative AI
                            และอุปกรณ์สวมใส่กำลังกลายเป็นเทรนด์หลักที่ทุกบริษัทต้องจับตามอง...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ข่าว 3 -->
        <div class="modal fade" id="newsModal3" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">กิจกรรมและเวิร์กช็อปเทคโนโลยี</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <img src="https://images.unsplash.com/photo-1522199710521-72d69614c702?auto=format&fit=crop&w=800&q=80"
                            class="img-fluid rounded mb-3" alt="กิจกรรม">
                        <p>มาร่วมกิจกรรม Hackathon และ Workshop เพื่อเรียนรู้เทคโนโลยีใหม่ๆ พร้อมพบปะผู้เชี่ยวชาญในวงการ
                            พร้อมของรางวัลมากมาย!</p>
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

    </script>

    <?php include('include/footer.php') ?>

</body>

</html>