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
<link type="text/css" rel="stylesheet" href="../../css/sweetalert.css">
<script type="text/javascript" src="../../js/sweetalert.min.js"></script>
<script type="text/javascript" src="../../js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
<style type="text/css">
 .space{
    width:100%;
    height: 50px;
  }
  .danger{
    background: red;
  }

  </style>
<script>
$(document).ready(function(){
	
    $(function(){
	//acknowledgement message
    var message_status = $("#status");
    $("td[contenteditable=true]").blur(function(){
        var field_userid = $(this).attr("id") ;
        var value = $(this).text() ;
        $.post('ajax.php' , field_userid + "=" + value, function(data){
            if(data != '')
			{
				message_status.show();
				message_status.text(data);
				//hide the message
				setTimeout(function(){message_status.hide()},3000);
			}
        });
    });
});
	
});

function editMe(row){
  swal({
  title: 'Delete this workshop?',
  text: 'Let the people live. Say yas.',
  type: 'warning',
  showCancelButton: true,
  closeOnConfirm: true,
  disableButtonsOnConfirm: true,
  confirmLoadingButtonColor: '#DD6B55'
}, function(isConfirm){
  if(isConfirm){
    var val = document.getElementById('EventName:'+row.id).innerHTML;
    document.getElementById('my-fucking-name').value=val;
    document.getElementById('my-fucking-form').submit();
  }
});
}

</script>

</head>
<body>
<nav>
 <ul class="navigbar">
  <li><a href="addworkshop.php">Add Workshop</a></li>
  <li><a href="workshopusers.php">Add User To Workshop</a></li>
  <li><a href="#">Team</a></li>
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
        <th>Workshop Name</th>
        <th>Workshop Time</th>
        <th>Workshop Room</th>
        <th>Workshop Cost</th>
      </tr>
    </thead>
     <tbody>
  	<?php getworkshops();
  	?>
  </tbody>
</table>



</div>
</div>

<form class="form-horizontal" action="workshopcall.php" role="form" method="GET" id="my-fucking-form">
    <input type="hidden" name="action" value="deleteEvent"/>
    <input type="hidden" name="name" value="" id="my-fucking-name"/>
</form>

</body>
</html>

