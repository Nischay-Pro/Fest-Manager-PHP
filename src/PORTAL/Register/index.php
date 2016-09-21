<?php
session_start();
include("../functions/functions.php");
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
    <script type="text/javascript" src="../../js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../../js/sweetalert.min.js"></script>
    <script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <style type="text/css">
    .space{
    width:100%;
    height: 50px;
    }</style>
  </head>
  <body>
    <nav>
      <ul class="navigbar">
        <li><a href="#">Home</a></li>
        <li><a href="../acom/index.php">Accomodation</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="abcd.php" target="_blank">Generate Excel</a></li>
        <ul style="float:right">
          <li><a href="#">Team Collection:&nbsp;&nbsp;<?php echo $result['reg_collect']; ?></a></li>
          <li><a href="logout.php">Log Out</a></li>
        </ul>
      </ul>
    </nav>
    <div class="container" style="width:50%">
      <div class="space"></div>
      <form class="form-horizontal" action="workshopcall.php" role="form" method="GET" id="my-fucking-form">
        <input type="hidden" name="action" value="registerEvent">
        <div class="form-group">
          <label  class="col-sm-4 control-label"
          for="name">Participant ID</label>
          <div class="col-sm-8">
            <input type="text" class="form-control"
            id="name" name="name" placeholder="Workshop Name"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label"
          for="room" >Participant Name</label>
          <div class="col-sm-8">
            <input type="text" class="form-control"
            id="room" name="room" placeholder="Room Number"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label"
          for="cost" >College Name</label>
          <div class="col-sm-8">
            <input type="text" class="form-control"
            id="cost" name="cost" placeholder="Cost"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label"
          for="time" >Phone Number</label>
          <div class="col-sm-8">
            <input type="text" class="form-control"
            id="datetimepicker" name="time" placeholder="Workshop Time"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label"
          for="time" >Email</label>
          <div class="col-sm-8">
            <input type="text" class="form-control"
            id="datetimepicker" name="time" placeholder="Workshop Time"/>
          </div>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-lg btn-primary col-sm-4" name="register">Clear</button>
            <button type="button" class="btn btn-lg btn-success col-sm-8" name="register" >Add Participant</button>
        </div>
      </form>
    </div>
    
  </div>
  <script type="text/javascript">
</div>
</body>
</html>