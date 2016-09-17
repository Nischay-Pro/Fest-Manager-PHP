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
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Controlz'16</title>
    <link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
<link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="../../js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
<style type="text/css">
 .space{
    width:100%;
    height: 50px;
  }
  .events:hover{
    cursor: pointer;
    }
    </style>
<script>

$(document).ready(function(){
	$('.back').hide();
$('.events').click(function(){
  var id=$(this).attr('id');
  $.post('participantajax.php' , {field_userid:id}, function(data){
            $('.tables').hide();
            $('.results').html(data);
            $('.back').show();
        });
});
$('.back').click(function(){
            $('.tables').show();
            $('.results').html('');
            $('.back').hide();
});
	
});

</script>

</head>
<body>
<nav>
 <ul class="navigbar">
  <li><a href="index.php">Controlz Panel :P</a></li>
  <li><a href="addevent.php">Add Event</a></li>
  <li><a href="sendnotif.php">Send Notification</a></li>
  <li><a href="#">Participants</a></li>
  <li><a href="#">Team</a></li>
  <li style="float:right"><a href="logout.php">Log Out</a></li>
  </ul>
 </ul>
</nav>
<div class="space"></div>
<div class="container"><br>

  <div id="status"></div>
  <div class="tabledata"> 
<table class="tables table table-bordered table-striped table-active">
<thead>
      <tr>
      <th>Sr No</th>
        <th>Event Name</th>
        
      </tr>
    </thead>
     <tbody>
  	<?php getIndiEvents();
  	?>
  </tbody>
</table>
<div class="results">

</div>
<button class='back btn btn-lg btn-success'>Back</button>
</div>
</div>

</body>
</html>

