<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | Next Gen IT</title>
    <?php include('include/header.php') ?>
</head>

<body class="bg-dark">

    <?php include('include/navbar.php') ?>

    <div class="container">

        <!-- หัวข้อหลัก -->
        <h3 class="text-main mt-custom fw-semibold ">| ติดต่อ Next Gen IT</h3>
        <p class="text-light mb-4">
            สอบถามสินค้า จองคิวซ่อมเครื่อง ขอคำปรึกษาสเปกคอม หรือนัดรับของที่หน้าร้าน
            ส่งข้อความถึงเราได้ผ่านแบบฟอร์มหรือช่องทางติดต่อด้านขวา
        </p>

        <div class="row g-4">

            <!-- ข้อมูลติดต่อ + แผนที่ -->
            <div class="col-md-5">
                <div class="card border-0 shadow-lg mb-3 py-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">ข้อมูลติดต่อร้าน</h5>

                        <div class="mb-4 d-flex">
                            <div class="me-3 mt-1">
                                <i class="bi bi-geo-alt-fill text-main fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-semibold">ที่ตั้งร้าน</h6>
                                <p class="mb-0 text-muted">
                                    85 ซอย จันทคามวิถี ตำบลวัดใหม่ อำเภอเมืองจันทบุรี จันทบุรี 2200
                                </p>
                            </div>
                        </div>

                        <div class="mb-4 d-flex">
                            <div class="me-3 mt-1">
                                <i class="bi bi-telephone-fill text-main fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-semibold">โทรศัพท์</h6>
                                <p class="mb-0 text-muted">
                                    098 981 2451<br>
                                    <small class="text-light-50">โทรได้ทุกวัน 10.00 – 20.00 น.</small>
                                </p>
                            </div>
                        </div>

                        <div class="mb-4 d-flex">
                            <div class="me-3 mt-1">
                                <i class="bi bi-clock-fill text-main fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-semibold">เวลาทำการ</h6>
                                <p class="mb-0 text-muted">
                                    จันทร์ – อาทิตย์ : 10.00 – 20.00 น.
                                    <br><small class="text-light-50">* อาจมีการปรับเวลาในช่วงวันหยุดพิเศษ</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-md-7">
                <!-- แผนที่ -->
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-0">
                        <!-- ใส่ Google Maps Embed จริงทีหลัง -->
                        <div style="height: 400px; border-radius: .5rem; overflow: hidden;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3893.813307265919!2d102.09674967507006!3d12.594552587687215!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310481be90117411%3A0x525d5f3daa94d821!2z4Lin4Li04LiX4Lii4Liy4Lil4Lix4Lii4LmA4LiX4LiE4LiZ4Li04LiE4LiI4Lix4LiZ4LiX4Lia4Li44Lij4Li1IOC4quC4luC4suC4muC4seC4meC4geC4suC4o-C4reC4suC4iuC4teC4p-C4qOC4tuC4geC4qeC4suC4oOC4suC4hOC4leC4sOC4p-C4seC4meC4reC4reC4gQ!5e0!3m2!1sth!2sth!4v1763124906307!5m2!1sth!2sth"
                                class="w-100" style="height: 400px; border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include('include/footer.php') ?>

</body>

</html>