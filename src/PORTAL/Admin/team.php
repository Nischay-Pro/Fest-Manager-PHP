<?php 
session_start();
if(!isset($_SESSION['admin_id'])){
  echo "<script>window.open('login.php','_self')</script>";
}
else{
  // start admin work here
  $con=mysqli_connect("localhost","root","","pearl_16");
   
  function getTeamCollection(){
    $con=mysqli_connect("localhost","root","","pearl_16");
    $query=mysqli_query($con,"SELECT * FROM dosh_credentials");
    while($result=mysqli_fetch_array($query)){
      $team_id=$result['team_id'];
      $reg_collect=$result['reg_collect'];
      $accom_collect=$result['accom_collect'];
      echo "<tr>
      <td >$team_id</td>
      <td contenteditable='true' id='reg_collect:$team_id'>$reg_collect</td>
      <td contenteditable='true' id='accom_collect:$team_id'>$accom_collect</td>
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
        $.post('teamajax.php' , field_userid + "=" + value, function(data){
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
  <li><a href="index.php">Dosh Registration</a></li>
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
      <th>Team Id</th>
        <th>reg_collect</th>
        <th>accom_collect</th>
      </tr>
    </thead>
     <tbody>
    <?php getTeamCollection();
    ?>
  </tbody>
</table>

</div>
</div>

</body>
</html>

