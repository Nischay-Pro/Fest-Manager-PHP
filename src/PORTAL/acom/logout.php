<?php
session_start();
if(!isset($_SESSION['team_id'])){
  echo "<script>window.open('../reg/login.php','_self')</script>";
}
else{
  session_destroy();
  echo "<script>window.open('../reg/login.php','_self')</script>";
  }
?>
