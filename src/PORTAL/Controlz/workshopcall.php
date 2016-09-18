<?php
session_start();
include("../functions/functions.php");
//echo "<script>window.open('workshop.php','_self')</script>";
$con=mysqli_connect("localhost","root","060848","pearl_16");
if($_GET['action']=='registerEvent'){
$name = mysqli_real_escape_string($con,$_GET['name']);
$room = mysqli_real_escape_string($con,$_GET['room']);
$time = mysqli_real_escape_string($con,$_GET['time']);
$cost = mysqli_real_escape_string($con,$_GET['cost']);
$club = mysqli_real_escape_string($con,$_GET['club']);
$check_user=mysqli_query($con,"SELECT * FROM event_workshops WHERE `name`='$name' AND club='$club' AND in_delete='0'");
$rows=mysqli_num_rows($check_user);
if($rows>0){
    	echo '{"message" : "exists"}';
}
else{
$run=mysqli_query($con,"INSERT INTO event_workshops(`name`,`room`,`time`,`cost`,`club`) VALUES('$name','$room','$time','$cost','$club')");
  if($run){
    echo '{"message" : "success"}'; 
  }
  else{
    echo '{"message" : "failure"}';
  }
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
$is_team = mysqli_real_escape_string($con,$_GET['isteam']);
$userid = mysqli_real_escape_string($con,$_GET['userid']);
$eventid = mysqli_real_escape_string($con,$_GET['eventid']);
$check_user=mysqli_query($con,"SELECT * FROM event_workshops_participants WHERE `is_team`='$is_team' AND is_delete='0' AND userid='$userid'");
$rows=mysqli_num_rows($check_user);
if($rows>0){
    	echo '{"message" : "exists"}';
}
else{
$run=mysqli_query($con,"INSERT INTO event_workshops_participants(`is_team`,`userid`,`eventid`) VALUES('$is_team','$userid','$eventid')");
  if($run){
	echo '{"message" : "success"}';
} else {
    echo '{"message" : "failure"}';
}
}
}
elseif($_GET['action']=='deleteUser'){
$id = mysqli_real_escape_string($con,$_GET['id']);
$eventid = mysqli_real_escape_string($con,$_GET['eventid']);
$sql = "UPDATE event_workshops_participants SET is_delete='1' WHERE id='$id' AND eventid='$eventid'";
if ($con->query($sql) === TRUE) {
    echo '{"message" : "success"}';
} else {
    echo '{"message" : "failure"}';
}
}
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


else{
	echo "Direct Access is denied";
}
?>
