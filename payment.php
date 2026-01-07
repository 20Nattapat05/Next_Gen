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
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-5">

                <div class="card border-0 shadow-lg mt-custom">
                    <div class="card-body p-4 p-md-5">
                        <!-- โลโก้ / ชื่อระบบ -->
                        <div class="text-center mb-4">
                            <h4 class="fw-bold mb-0">กรุณาชำระเงิน</h4>
                        </div>

                        <img src="assets/images/qr-code.jpg" alt="slip" class="w-100 my-3 rounded">

                        <!-- ฟอร์ม Login -->
                        <form action="" method="post">

                            <div class="mb-3">
                                <label for="username" class="form-label">แนบรูปใบเสร็จชำระเงิน</label>
                                <input type="file" class="form-control" id="username" name="username" required>
                            </div>

                            <button type="submit" class="btn btn-main w-100">
                                <i class="bi bi-send me-1"></i> ส่ง
                            </button>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include('include/footer.php') ?>

</body>

</html>