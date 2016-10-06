<?php
session_start();
include("../functions/functions.php");
//echo "<script>window.open('workshop.php','_self')</script>";
//$con=mysqli_connect("localhost","root","060848","pearl_16");
if($_GET['action']=='registerEvent'){
$name = mysqli_real_escape_string($con,$_GET['name']);
$room = mysqli_real_escape_string($con,$_GET['room']);
$time = mysqli_real_escape_string($con,$_GET['time']);
$time = str_replace('/','-',$time);
$time = $time . ':00';
$cost = mysqli_real_escape_string($con,$_GET['cost']);
$club = $_SESSION['controlz_id'];
$check_user=mysqli_query($con,"SELECT * FROM event_workshops WHERE `name`='$name' AND isdelete='0'");
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
$userid = strtolower(mysqli_real_escape_string($con,$_GET['userid'])) . 'h';
$eventid = mysqli_real_escape_string($con,$_GET['workshopid']);
$iscoupon = mysqli_real_escape_string($con,$_GET['iscoupon']);
$tcost = mysqli_real_escape_string($con,$_GET['event-cost']);
$outsider = mysqli_real_escape_string($con,$_GET['outsider']);
$club = $_SESSION['controlz_id'];
$check_user=mysqli_query($con,"SELECT * FROM event_workshops_participants WHERE eventid='$eventid' AND is_delete='0' AND userid='$userid'");
$rows=mysqli_num_rows($check_user);
if($rows>0){
    	echo '{"message" : "User Already Added"}';
}
else{
    // "INSERT INTO event_workshops_participants(`userid`,`eventid`,`is_coupon`) VALUES('$userid','$eventid','$iscoupon')";
$run=mysqli_query($con,"INSERT INTO event_workshops_participants(`userid`,`eventid`,`is_coupon`) VALUES('$userid','$eventid','$iscoupon')");
  if($run){
      $loadevent=mysqli_query($con,"SELECT * FROM event_workshops WHERE isdelete='0' AND id='$eventid'");
      $cost = mysqli_fetch_array($loadevent);
      //while ($row = mysqli_fetch_row($loadevent)) {
      //  $cost = $row['cost'];
    //}
      if($iscoupon=='1'){
      $sql = "UPDATE event_credentials SET collection=collection+$tcost,coupons=coupons+1 WHERE organiser_id='$club'";
          $con->query($sql);
        $sql = "UPDATE couponusers SET couponused=1 WHERE bitsid='$userid'";
          $con->query($sql);
      }
      else{
      $sql = "UPDATE event_credentials SET collection=collection+$tcost WHERE organiser_id='$club'";
        $con->query($sql);
      }
      if($outsider=='1'){
      $sql = "UPDATE event_workshops SET current_count_general=current_count_general+1 WHERE id='$eventid'";
          $con->query($sql);
      }
      else{
      $sql = "UPDATE event_workshops SET current_count_bits=current_count_bits+1 WHERE id='$eventid'";
        $con->query($sql);
      }
    //echo '{"message" : "success"}';
      echo "<script>window.open('addusers.php','_self')</script>";
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
$userid = mysqli_real_escape_string($con,$_GET['userid']) . 'h';
$check_user=mysqli_query($con,"SELECT * FROM couponusers WHERE bitsid='$userid' AND couponused='0'");
$rows=mysqli_num_rows($check_user);
if($rows>0){
    	echo '{"message" : true}';
}
else{
    echo '{"message" : false}';
}

}
elseif($_GET['action']=='getDataWorkshop'){
    $userid = mysqli_real_escape_string($con,$_GET['id']);
    $query=mysqli_query($con,"SELECT * FROM event_workshops WHERE `id`='$userid'");
    $row=mysqli_fetch_array($query);
    $json[]= array(
        'cost_general' => $row['cost_general'],
        'cost_bits' => $row['cost_bits'],
        'max_count_general' => $row['max_count_general'],
        'max_count_bits' => $row['max_count_bits'],
        'current_count_bits' => $row['current_count_bits'],
        'current_count_general' => $row['current_count_general']
    );
    $jsonstring = json_encode($json);
 echo $jsonstring;
}
elseif($_GET['action']=='checkPaid'){
    $email = mysqli_real_escape_string($con,$_GET['email']);
    $workshopname = mysqli_real_escape_string($con,$_GET['work_name']);
    $query=mysqli_query($con,"SELECT * FROM online_payment WHERE `email`='$email' AND `ticket_name`='$workshopname'");
    $row=mysqli_fetch_array($query);
    if(mysqli_num_rows($query) != 0) {
    $json[]= array(
        'paid' => 'true'
    );
    $jsonstring = json_encode($json);
 echo $jsonstring;
    }
    else{
    $json[]= array(
        'paid' => 'false'
    );
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}
elseif($_GET['action']=='checkUserReal'){
    $user = mysqli_real_escape_string($con,$_GET['userid']);
    $query=mysqli_query($con,"SELECT * FROM users WHERE `pearl_id`='$user'");
    $row=mysqli_fetch_array($query);
    if(mysqli_num_rows($query) != 0) {
    $json[]= array(
        'exists' => 'true'
    );
    $jsonstring = json_encode($json);
 echo $jsonstring;
    }
    else{
    $json[]= array(
        'exists' => 'false'
    );
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
}
elseif($_GET['action']=='performPayTransfer'){
    $userid = mysqli_real_escape_string($con,$_GET['userid']);
    $email = mysqli_real_escape_string($con,$_GET['email']);
    $workshopname = mysqli_real_escape_string($con,$_GET['work_name']);
    $query=mysqli_query($con,"SELECT * FROM online_payment WHERE `email`='$email' AND `ticket_name`='$workshopname'");
    $row=mysqli_fetch_array($query);
    if(mysqli_num_rows($query) != 0) {
    $ticket_name=$row['ticket_name'];
    $query2=mysqli_query($con,"SELECT * FROM event_workshops WHERE `ticket_name`='$ticket_name'");
    $row2=mysqli_fetch_array($query2);
    $workshopid=$row2['id'];
    $run=mysqli_query($con,"INSERT INTO event_workshops_participants(`userid`,`eventid`,`is_coupon`) VALUES('$userid','$workshopid','0')");
    if($run){
        $json[]= array(
        'status' => 'true'
    );
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
    else{
           $json[]= array(
        'status' => 'false'
    );
        $jsonstring = json_encode($json);
        echo $jsonstring; 
    }
    }
    else{
           $json[]= array(
        'status' => 'false'
    );
        $jsonstring = json_encode($json);
        echo $jsonstring; 
    }
}
else{
	echo "Direct Access is denied";
}
?>