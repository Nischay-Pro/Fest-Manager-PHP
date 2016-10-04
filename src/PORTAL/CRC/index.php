<?php 
session_start();
include("functions/functions.php");
$_SESSION['crc_id'];
if(!isset($_SESSION['crc_id'])){
  echo "redirected";
  echo "<script>window.open('login.php','_self')</script>";
}
else{
    //echo "<script>window.open('workshop.php','_self')</script>";
  // start crc work here
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>crc'16</title>

    <link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
<link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="../Controlz/css/style.css">
<script type="text/javascript" src="../../js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
<style type="text/css">
 .space{
    width:100%;
    height: 50px;
  }
</style>
</head>
<body>
<nav>
 <ul class="navigbar">
     <li><a href="event.php">Events</a></li>
     <li><a href="workshop.php">Workshops</a></li>
     <li><a href="registeredonlinedata.php">Registered Users</a></li>
     <li><a href="accomodation.php">Accomodation</a></li>
     <li style="float:right"><a href="logout.php">Log Out</a></li>
  </ul>
 </ul>
</nav>
<div class="space"></div>
<div class="container"><br>

  <div id="status"></div>
  <div> 
<table class="table table-bordered table-striped">
<thead>
      <tr>
      <th>Sr No</th>
        <th>Event Name</th>
        <th>Event Round</th>
        <th>Event Date</th>
        <th>Event Venue</th>
      </tr>
    </thead>
     <tbody>
  	<?php getevents();
  	?>
  </tbody>
</table>

</div>
</div>

</body>
</html>