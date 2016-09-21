<?php
session_start();
include("functions/functions.php");
if($_GET['action']=='masterpassword'){
$password = mysqli_real_escape_string($con,$_GET['password']);
$teamid= $_SESSION['team_id']; 
$check_user=mysqli_query($con,"SELECT * FROM dosh_credentials WHERE `team_id`='$teamid' AND `team_masterpassword`='$password'");
if(mysqli_num_rows($check_user)>0){
    	echo '{"message" : "valid"}';
}
else{
    echo '{"message" : "invalid"}';
}
}
else{
    echo 'Direct Access is not allowed';
}
?>