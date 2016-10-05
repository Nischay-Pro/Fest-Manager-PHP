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
    //echo '{"message" : "success"}'; 
    echo "<script>window.open('workshop.php','_self')</script>";
  }
  else{
    echo '{"message" : "failure"}';
  }
}
elseif($_GET['action']=='deleteEvent'){
$name = mysqli_real_escape_string($con,$_GET['name']);
$club = $_SESSION['controlz_id'];
$sql = "UPDATE event_workshops SET isdelete='1' WHERE name='$name' AND club='$club'";
if ($con->query($sql) === TRUE) {
    //echo '{"message" : "success"}';
  echo "<script>window.open('workshop.php','_self')</script>";
} else {
    echo '{"message" : "failure"}';
}
}
elseif($_GET['action']=='registerUser'){
$userid = strtolower(mysqli_real_escape_string($con,$_GET['userid']));
$eventid = mysqli_real_escape_string($con,$_GET['Event_id']);
$iscoupon = mysqli_real_escape_string($con,$_GET['iscoupon']);
$outsider = mysqli_real_escape_string($con,$_GET['outsider']);
$club = $_SESSION['controlz_id'];
$check_user=mysqli_query($con,"SELECT * FROM event_participants WHERE event_id='$eventid' AND isdelete='0' AND pearl_id='$userid'");
$rows=mysqli_num_rows($check_user);
if($rows>0){
    	echo '{"message" : "User Already Added"}';
}
else{
    // "INSERT INTO event_workshops_participants(`userid`,`eventid`,`is_coupon`) VALUES('$userid','$eventid','$iscoupon')";
$run=mysqli_query($con,"INSERT INTO event_participants(`pearl_id`,`event_id`,`uploaded_by`) VALUES('$userid','$eventid','$club')");
  if($run){
      if($outsider=='1'){
      $sql = "UPDATE atmos_events SET current_count_general=current_count_general+1 WHERE event_id='$eventid'";
          
          $con->query($sql);
      }
      else{
      $sql = "UPDATE atmos_events SET current_count_bits=current_count_bits+1 WHERE event_id='$eventid'";
        $con->query($sql);
      }
      //while ($row = mysqli_fetch_row($loadevent)) {
      //  $cost = $row['cost'];
    //}
    //echo '{"message" : "success"}';
      echo "<script>window.open('addusersevent.php','_self')</script>";
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
$sql = "UPDATE atmos_events SET round=round+1 WHERE id='$id' AND eventid='$eventid' AND is_delete='0'";
$sql2 = "UPDATE event_participants SET round_at=round_at+1 WHERE id='$id' AND event_id='$eventid'";
if ($con->query($sql) === TRUE && $con->query($sql2) === TRUE) {
    echo '{"message" : "success"}';
} else {
    echo '{"message" : "failure"}';
}
}
elseif($_GET['action']=='setRanking'){
$id = mysqli_real_escape_string($con,$_GET['id']);
$eventid = mysqli_real_escape_string($con,$_GET['eventid']);
$rank = mysqli_real_escape_string($con,$_GET['rank']);
$sql = "UPDATE event_participants SET ranking='$rank' WHERE id='$id' AND eventid='$eventid' AND is_delete='0'";
if ($con->query($sql) === TRUE) {
    echo '{"message" : "success"}';
} else {
    echo '{"message" : "failure"}';
}
}
elseif($_GET['action']=='checkCouponUser'){
$userid = mysqli_real_escape_string($con,$_GET['userid']);
$check_user=mysqli_query($con,"SELECT * FROM couponusers WHERE bitsid='$userid' AND couponused='0'");
$rows=mysqli_num_rows($check_user);
if($rows>0){
    	echo '{"message" : true}';
}
else{
    echo '{"message" : false}';
}

}
elseif($_GET['action']=='getDataEvent'){
    $userid = mysqli_real_escape_string($con,$_GET['id']);
    $query=mysqli_query($con,"SELECT * FROM atmos_events WHERE `event_id`='$userid'");
    $row=mysqli_fetch_array($query);
    $json[]= array(
        'event_id' => $row['event_id'],
        'max_count_general' => $row['max_count_general'],
        'max_count_bits' => $row['max_count_bits'],
        'current_count_bits' => $row['current_count_bits'],
        'current_count_general' => $row['current_count_general']
    );
    $jsonstring = json_encode($json);
    echo $jsonstring;
}
else{
	echo "Direct Access is denied";
}

?>