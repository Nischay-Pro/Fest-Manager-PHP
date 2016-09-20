<?php
session_start();
$team_id=$_SESSION['team_id'];
    include("../functions/functions.php");
    $pearl_id=mysqli_real_escape_string($con,$_POST['pearl_id']);
    $name=mysqli_real_escape_string($con,$_POST['name']);
    $phone=mysqli_real_escape_string($con,$_POST['phone']);
    $college=mysqli_real_escape_string($con,$_POST['college']);
    $email=mysqli_real_escape_string($con,$_POST['email']);
      //testing   echo $pearl_id.$name.$phone.$college.$email.$reg.$accom.$_SESSION['team_id'];
    if(strlen($phone)!=10){
        $response=array();
      echo 'Pls enter 10 digits';
      }
      else{
        $query=mysqli_query($con,"UPDATE users SET name='$name',phone='$phone',college='$college',email='$email' WHERE pearl_id='$pearl_id'");
        if($query){
          echo 'User data updated';
        }
        else{
          echo 'User data not updated';
        }
    }
  
  ?>