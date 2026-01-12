<?php

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

session_start();

require_once __DIR__ . '/../function/auth/logout_function.php';

logout();

// Recreate session after logout to pass flag to login page
session_start();
$_SESSION['logout_success'] = "ออกจากระบบเรียบร้อยแล้ว";

// Redirect to login page
header("Location: ../login.php");
exit();

?>
