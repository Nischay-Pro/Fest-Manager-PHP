<?php
session_start();
include("functions/functions.php");
$con=mysqli_connect("localhost","root","060848","pearl_16");
if(!isset($_SESSION['team_id'])){
echo "<script>window.open('login.php','_self')</script>";
}
else{
$team_id=$_SESSION['team_id'];
$team_collection=mysqli_query($con,"SELECT * FROM dosh_credentials WHERE team_id='$team_id'");
$result=mysqli_fetch_array($team_collection);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Registration</title>
    <link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
    <link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="../../css/sweetalert.css">
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <link type="text/css" rel="stylesheet" href="../../css/toastr.min.css">
    <script type="text/javascript" src="../../js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../../js/toastr.min.js"></script>
    <script type="text/javascript" src="../../js/sweetalert.min.js"></script>
    <script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
    <style type="text/css">
    .space{
    width:100%;
    height: 100px;
    }</style>
  </head>
  <body>
    <nav>
      <ul class="navigbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="../acom/index.php">Accomodation</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="abcd.php" target="_blank">Generate Excel</a></li>
        <li><a href="view.php">View Registered Users</a></li>
        <ul style="float:right">
          <li><a href="#">Team Collection:&nbsp;&nbsp;<?php echo $result['reg_collect']; ?></a></li>
          <li><a href="logout.php">Log Out</a></li>
        </ul>
      </ul>
    </nav>
    <div class="container" style="width:50%">
      <div class="space"></div>
      <div class="form-group">
        <button class="btn btn-lg btn-primary col-sm-12" name="register" onclick="checkOnline()">Registered Online?</button>  
      </div>
      <form class="form-horizontal" action="register.php" role="form" method="POST" id="my-fucking-form">
        <input type="hidden" name="action" value="registerEvent">
        <div class="form-group">
          <label  class="col-sm-4 control-label"
          for="name">Participant ID</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="fest_id" name="fest_id" placeholder="ATM####"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label"
          for="room" >Participant Name</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="name" name="name" placeholder="Participant's Name"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label"
          for="cost" >College Name</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="college" name="college" placeholder="Participant's College"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label"
          for="time" >Phone Number</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="10 digit phone number"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label"
          for="time" >Email</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="email" name="email" placeholder="username@domain.com"/>
          </div>
        </div>
        <div class="form-group">
          <div class="checkbox col-sm-6">
            <label><input type="checkbox" id="reg" name="reg" >Free Registration</label>
          </div>
          <div class="checkbox col-sm-6">
            <label><input type="checkbox" id="accom" name="accom" >Free Accomodation</label>
          </div>
        </div>
      </form>
      <div class="form-group">
        <button class="btn btn-lg btn-primary col-sm-4" name="register" onclick="clearData()">Clear</button>
        <button class="btn btn-lg btn-success col-sm-8" name="register" id="register-button" onclick="register()">Add Participant</button>
      </div>
    </div>
    <script type="text/javascript" src="js/index.js"></script>
  </body>
</html>