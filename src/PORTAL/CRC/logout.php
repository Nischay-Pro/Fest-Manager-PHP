<?php
session_start();
if(!isset($_SESSION['crc_id'])){
  echo "<script>window.open('login.php','_self')</script>";
}
else{
  session_destroy();
  echo "<script>window.open('login.php','_self')</script>";
  }
?>
