<?php
session_start();
include("../functions/functions.php");
if(!isset($_SESSION['controlz_id'])){
echo "<script>window.open('login.php','_self')</script>";
}
else{
// start controlz work here
}
?>
<html>
  <head>
    <title>Website</title>
    <link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
    <link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="../../css/sweetalert.css">
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="../../js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="../../js/sweetalert.min.js"></script>
    <script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
    .space{
    width:100%;
    height: 50px;
    }</style>
  </head>
  <body>
    <nav>
      <ul class="navigbar">
        <li><a href="index.php">Controlz Panel :P</a></li>
        <li><a href="workshop.php">Back to Workshop Dashboard</a></li>
        <li style="float:right"><a href="logout.php">Log Out</a></li>
      </ul>
    </nav>
    <div class="container" style="width:50%">
      <div class="space"></div>
      <form class="form-horizontal" action="workshopcall.php" role="form" method="GET" id="my-fucking-form">
        <input type="hidden" name="action" value="registerEvent">
        <div class="form-group">
          <label  class="col-sm-2 control-label"
          for="name">Workshop Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
            id="name" name="name" placeholder="Workshop Name"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"
          for="room" >Room Number</label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
            id="room" name="room" placeholder="Room Number"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"
          for="cost" >Workshop Cost</label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
            id="cost" name="cost" placeholder="Cost"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"
          for="time" >Workshop Time</label>
          <div class="col-sm-10">
            <input type="text" class="form-control"
            id="datetimepicker" name="time" placeholder="Workshop Time"/>
          </div>
        </div>
          <input class="btn btn-lg btn-success col-sm-6" style="margin-left:25vw" type="submit" value="Add Workshop" name="register" >

        </form>
    </div>
    
  </div>
  
</div>
<script type="text/javascript">
$(document).ready(function(){
$('#datetimepicker').click(function(){
$(this).datetimepicker({
lang:'en',
minDate:0,
maxDate:'17.10.2016',
formatDate:'d.m.Y',
allowTimes:[
'09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00'
]
});
});
});
var confirmDiag = function(){
swal({
title: 'Add Workshop?',
text: 'Do you wish to s. Sure?',
type: 'info',
showCancelButton: true,
closeOnConfirm: true,
disableButtonsOnConfirm: true,
confirmLoadingButtonColor: '#DD6B55'
}, function(isConfirm){
if(isConfirm){
document.getElementById('my-fucking-form').submit();
}
});
}
</script>
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/ >
<script src="js/jquery.js"></script>
<script src="js/jquery.datetimepicker.js"></script>

<?php
if(isset($_POST['register'])){
$Event_date=$_POST['Event_date'];
$Roundname=$_POST['Roundname'];
$Event_id=$_POST['Event_id'];
$Event_venue=$_POST['Event_venue'];
$timezone='GMT+5:30';
$Event_date.=$timezone;
$Event_date=strtotime($Event_date);
$run=mysqli_query($con,"INSERT INTO event_details(Event_id,Event_date,Roundname,Event_venue,updated_at) VALUES('$Event_id','$Event_date','$Roundname','$Event_venue','$Event_date')");
if($run){
//query pass

}
else{
// query failed
}
}
?>
</body>
<html>