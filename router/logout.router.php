<?php

  session_start();

  require_once __DIR__ . '/../function/auth/logout_function.php';

  logout();

  session_start();
  $_SESSION['logout_success'] = true;
  echo "<script>
      window.location.replace('/Next_Gen/login');
  </script>";
  exit();
  
?>
