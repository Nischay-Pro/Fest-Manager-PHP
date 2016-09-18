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
<script type="text/javascript" src="../../js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <style type="text/css">
 .space{
    width:100%;
    height: 50px;
  }</style>
</head>
<body>
<body>
<nav>
 <ul class="navigbar">
 <li><a href="index.php">Controlz Panel :P</a></li>
  <li><a href="#">Add Event</a></li>
  <li><a href="sendnotif.php">Send Notification</a></li>
  <li><a href="participants.php">Participants</a></li>
  <li><a href="#">Team</a></li>
  <li style="float:right"><a href="logout.php">Log Out</a></li>
  </ul>
 </ul>
</nav>
<div class="container" style="width:50%">
<div class="space"></div>
<form class="form-horizontal" action="addevent.php" role="form" method="POST">
                  <div class="form-group">
                    <label  class="col-sm-2 control-label"
                              for="sel1">Workshop Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"
                            id="Roundname" name="Roundname" placeholder="Event ROund"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"
                          for="Roundname" >Workshop Round</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"
                            id="Roundname" name="Roundname" placeholder="Event ROund"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"
                          for="Event_venue" >Venue</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"
                            id="Event_venue" name="Event_venue" placeholder="venue"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"
                          for="Event_date" >Workshop Time</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"
                            id="datetimepicker" name="Event_date" placeholder="Event Time"/>
                    </div>
                  </div>
                                   
      </div>
      
        <input class="btn btn-lg btn-success" type="submit" value="Add Event" name="register" >
      </div>
      </form>
      </div>
<script type="text/javascript">
$(document).ready(function(){
	$('#datetimepicker').click(function(){
	$(this).datetimepicker({
  lang:'en',
		minDate:0,
		maxDate:'15.10.2016',
		formatDate:'d.m.Y',
		allowTimes:[
  '09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00'
  ]
});
});
	});
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