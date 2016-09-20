<?php
session_start();
$team_id=$_SESSION['team_id'];
    include("functions/functions.php");
    $pearl_id=mysqli_real_escape_string($con,$_POST['pearl_id']);
    $name=mysqli_real_escape_string($con,$_POST['name']);
    $phone=mysqli_real_escape_string($con,$_POST['phone']);
    $college=mysqli_real_escape_string($con,$_POST['college']);
    $email=mysqli_real_escape_string($con,$_POST['email']);
    $reg=mysqli_real_escape_string($con,$_POST['reg']);
    $accom=mysqli_real_escape_string($con,$_POST['accom']);
      //testing   echo $pearl_id.$name.$phone.$college.$email.$reg.$accom.$_SESSION['team_id'];
    if(strlen($phone)!=10){
        $response=array();
      echo 'Pls enter 10 digits';
      }
      else{
        $check_duplicate_query=mysqli_query($con,"SELECT * FROM users WHERE email='$email'");
        $rows=mysqli_num_rows($check_duplicate_query);
        if($rows==0){
          $register_participant_query=mysqli_query($con,"INSERT INTO users(pearl_id,name,email,phone,college,reg,accom,id_reg) VALUES('$pearl_id','$name','$email','$phone','$college','$reg','$accom','$team_id')");
          if($register_participant_query){
            if($reg!=1){
               $team_reg_collect_query=mysqli_query($con,"UPDATE dosh_credentials SET reg_collect=reg_collect+250 WHERE team_id='$team_id'");
               $response=array();
               echo 'Please collect Rs 250';
   
            }
            else{
              $response=array();
              echo 'User registered! DO NOT COLLECT RS 250!!!';
     
            }
          }
          else{
            $response=array();
            echo 'User data not inserted';
   
          }
      }

      else{
        $response=array();
        echo 'Duplicate Email Found';
      }
    }
  
  ?>