<?php 
session_start();
if(!isset($_SESSION['admin_id'])){
  echo "<script>window.open('login.php','_self')</script>";
}
else{
  // start admin work here
  $con=mysqli_connect("localhost","root","","pearl_16");
  if(isset($_GET['delete'])){
    $pearl_id=mysqli_real_escape_string($con,$_GET['delete']);
    $query=mysqli_query($con,"DELETE FROM users WHERE pearl_id='$pearl_id'");
    if($query){
      echo "<script>window.open('index.php','_self');</script>";
    }
    else{
      echo "<script>window.open('index.php','_self');</script>";
    }
  }
  
  function getRegistered(){
    $con=mysqli_connect("localhost","root","","pearl_16");
    $query=mysqli_query($con,"SELECT * FROM users WHERE pearl_id LIKE 'PLH%'");
    while($result=mysqli_fetch_array($query)){
      $pearl_id=$result['pearl_id'];
      $name=$result['name'];
      $email=$result['email'];
      $phone=$result['phone'];
      $reg=$result['reg'];
      $accom=$result['accom'];
      $id_reg=$result['id_reg'];
      echo "<tr>
      <td id='pearl_id:$pearl_id'>$pearl_id</td>
      <td contenteditable='true' id='name:$pearl_id'>$name</td>
      <td contenteditable='true' id='email:$pearl_id'>$email</td>
      <td contenteditable='true' id='phone:$pearl_id'>$phone</td>
      <td contenteditable='true' id='reg:$pearl_id'>$reg</td>
      <td contenteditable='true' id='accom:$pearl_id'>$accom</td>
      <td contenteditable='true' id='id_reg:$pearl_id'>$id_reg</td>
      <td ><a href='index.php?delete=$pearl_id'>Delete</a></td>
      </tr>";
    }
  }
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
  .navigbar{
  font-family: 'Slabo 27px', serif;
  width:100%;
  color:white;
  background:black;
  height:5%;
  position:fixed;
}
.navigbar li{
  font-family: 'Slabo 27px', serif;
  list-style:none;
  display: inline-block;
}
.navigbar li a{
  font-family: 'Slabo 27px', serif;
  text-decoration: none;
  color:white;
  padding:1em 0.5em;
  font-size:1.5em;
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
        $.post('maindeskajax.php' , field_userid + "=" + value, function(data){
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

</script>

</head>
<body>
<nav>
 <ul class="navigbar">
  <li><a href="team.php">Team Collection</a></li>
  <li><a href="accom.php">Accommodation</a></li>
  <li><a href="participants.php">Participants</a></li>
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
      <th>Reg Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Registration</th>
        <th>Accomodation</th>
        <th>Team Registered</th>
        <th>Delete</th>
      </tr>
    </thead>
     <tbody>
  	<?php getRegistered();
  	?>
  </tbody>
</table>

</div>
</div>

</body>
</html>

