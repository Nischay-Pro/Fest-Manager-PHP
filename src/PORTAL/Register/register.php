<?php
session_start();
include("sms.php");
$team_id=$_SESSION['team_id'];
    include("functions/functions.php");
    $fest_id=mysqli_real_escape_string($con,$_GET['fest_id']);
    $name=mysqli_real_escape_string($con,$_GET['name']);
    $phone=mysqli_real_escape_string($con,$_GET['phone']);
    $college=mysqli_real_escape_string($con,$_GET['college']);
    $email=mysqli_real_escape_string($con,$_GET['email']);
    $reg=mysqli_real_escape_string($con,$_GET['reg']);
    $accom=mysqli_real_escape_string($con,$_GET['accom']);
if($reg=='true'){
    $reg=1;
}
else{
    $reg=0;
}
if($accom=='true'){
    $accom=1;
}
else{
    $accom=0;
}
//echo "INSERT INTO users(pearl_id,name,email,phone,college,reg,accom,id_reg) VALUES('$fest_id','$name','$email','$phone','$college','$reg','$accom','$team_id')";
      //testing   
        $check_duplicate_query=mysqli_query($con,"SELECT * FROM users WHERE email='$email'");
        $rows=mysqli_num_rows($check_duplicate_query);
        if($rows==0){
          $register_participant_query=mysqli_query($con,"INSERT INTO users(pearl_id,name,email,phone,college,reg,accom,id_reg) VALUES('$fest_id','$name','$email','$phone','$college','$reg','$accom','$team_id')");
          if($register_participant_query){
            if($reg!=1){
               $team_reg_collect_query=mysqli_query($con,"UPDATE dosh_credentials SET reg_collect=reg_collect+250 WHERE team_id='$team_id'");
               $response=array();
                sendSMS('91' . $phone,'You have successfully registered. Please pay 250 rupees.');
               echo '{"title":"User Registration Successful","message": "User has been registered successfully. Please collect Rs 250.","type": "success","status": "200"}';
            }
            else{
              $response=array();
                    sendSMS('91' . $phone,'You have successfully registered.');
               echo '{"title":"User Registration Successful","message": "User has been registered successfully. Do not collect Rs 250.","type": "success","status": "200"}';
     
            }
          }
          else{
            $response=array();
               echo '{"title":"User Registration Failure","message": "Unable to insert data. Critical Error.","type": "error","status": "200"}';
   
          }
      }

      else{
        $response=array();
               echo '{"title":"Duplicate Email Found","message": "Duplicate Email Detected.","type": "error","status": "200"}';
      }
  
  ?>