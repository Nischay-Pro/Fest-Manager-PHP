<?php
session_start();
include("../functions/functions.php");
//echo "<script>window.open('workshop.php','_self')</script>";
$con=mysqli_connect("localhost","root","060848","pearl_16");
if($_GET['action']=='registerEvent'){
$name = mysqli_real_escape_string($con,$_GET['name']);
$room = mysqli_real_escape_string($con,$_GET['room']);
$time = mysqli_real_escape_string($con,$_GET['time']);
$time = str_replace('/','-',$time);
$time = $time . ':00';
$cost = mysqli_real_escape_string($con,$_GET['cost']);
$club = $_SESSION['controlz_id'];
$check_user=mysqli_query($con,"SELECT * FROM event_workshops WHERE `name`='$name' AND `club`='$club' AND isdelete='0'");
$rows=mysqli_num_rows($check_user);
if($rows>0){
    	echo '{"message" : "exists"}';
}
else
    $test = "INSERT INTO event_workshops(`name`,`room`,`time`,`cost`,`club`) VALUES('$name','$room','$time','$cost','$club')";
    echo $test;
$run=mysqli_query($con,"INSERT INTO event_workshops(`name`,`room`,`time`,`cost`,`club`) VALUES('$name','$room','$time','$cost','$club')");
  if($run){
    echo '{"message" : "success"}'; 
  }
  else{
    echo '{"message" : "failure"}';
  }
}
elseif($_GET['action']=='deleteEvent'){
$name = mysqli_real_escape_string($con,$_GET['name']);
$club = mysqli_real_escape_string($con,$_GET['club']);
$sql = "UPDATE event_workshops SET isdelete='1' WHERE name='$name' AND club='$club'";
if ($con->query($sql) === TRUE) {
    echo '{"message" : "success"}';
} else {
    echo '{"message" : "failure"}';
}
}
elseif($_GET['action']=='registerUser'){
$userid = mysqli_real_escape_string($con,$_GET['userid']);
$eventid = mysqli_real_escape_string($con,$_GET['eventid']);
$iscoupon = mysqli_real_escape_string($con,$_GET['iscoupon']);
$check_user=mysqli_query($con,"SELECT * FROM event_workshops_participants WHERE eventid='$eventid' AND is_delete='0' AND userid='$userid'");
$rows=mysqli_num_rows($check_user);
if($rows>0){
    	echo '{"message" : "exists"}';
}
else{
$run=mysqli_query($con,"INSERT INTO event_workshops_participants(`userid`,`eventid`,`is_coupon`) VALUES($userid','$eventid','$iscoupon')");
  if($run){
	echo '{"message" : "success"}';
} else {
    echo '{"message" : "failure"}';
}
}
}
elseif($_GET['action']=='deleteUser'){
$userid = mysqli_real_escape_string($con,$_GET['userid']);
$eventid = mysqli_real_escape_string($con,$_GET['eventid']);
$sql = "UPDATE event_workshops_participants SET is_delete='1' WHERE userid='$userid' AND eventid='$eventid'";
if ($con->query($sql) === TRUE) {
    echo '{"message" : "success"}';
} else {
    echo '{"message" : "failure"}';
}
}

//Scrap Code Below
elseif($_GET['action']=='upgradeRound'){
$id = mysqli_real_escape_string($con,$_GET['id']);
$eventid = mysqli_real_escape_string($con,$_GET['eventid']);
$sql = "UPDATE event_workshops_participants SET round=round+1 WHERE id='$id' AND eventid='$eventid' AND is_delete='0'";
if ($con->query($sql) === TRUE) {
    echo '{"message" : "success"}';
} else {
    echo '{"message" : "failure"}';
}
}
elseif($_GET['action']=='setRanking'){
$id = mysqli_real_escape_string($con,$_GET['id']);
$eventid = mysqli_real_escape_string($con,$_GET['eventid']);
$rank = mysqli_real_escape_string($con,$_GET['rank']);
$sql = "UPDATE event_workshops_participants SET ranking='$rank' WHERE id='$id' AND eventid='$eventid' AND is_delete='0'";
if ($con->query($sql) === TRUE) {
    echo '{"message" : "success"}';
} else {
    echo '{"message" : "failure"}';
}
}
elseif($_GET['action']=='checkCouponUser'){
$userid = mysqli_real_escape_string($con,$_GET['userid']);
$check_user=mysqli_query($con,"SELECT * FROM couponusers WHERE bitsid='$userid' AND couponused='0' AND userid='$userid'");
$rows=mysqli_num_rows($check_user);
if($rows>0){
    	echo '{"message" : "coupon available"}';
}
else{
    echo '{"message" : "coupon used"}';
}

}
else{
	echo "Direct Access is denied";
}
?>