<?php
session_start();
include("functions/functions.php");
if(!isset($_SESSION['team_id'])){
	echo "<script>window.open('login.php','_self')</script>";
}
else{
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
			background: red !important;
		}
		#reg_list {
			font-family: 'Slabo 27px', serif;
			font-size: 30px;
			position: relative;
			top: 0px;
			left: 100px;
		}
		#gencsv_butt{
			font-family: 'Slabo 27px', serif;
			position: absolute;
			top: 60px;
			right: 100px;
			width: 200px;
			padding: 0px;
			background-color: black;
			color: white;
			font-size: 20px;
			border-width: 0px;
			border-radius: 5px;
		}

	</style>
</head>
<body>
    <nav>
      <ul class="navigbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="../acom/index.php">Accomodation</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="abcd.php" target="_blank">Generate Excel</a></li>
        <ul style="float:right">
          <li><a href="#">Team Collection:&nbsp;&nbsp;<?php echo $result['reg_collect']; ?></a></li>
          <li><a href="logout.php">Log Out</a></li>
        </ul>
      </ul>
    </nav>
<div class="space"></div>
<div id='reg_list'>Registered Users</div>
<div class="container"><br>

	<div id="status"></div>
	<div>
		<table class="table table-bordered table-striped">
			<thead>
			<tr>
				<th>Sr No</th>
				<th>Atmos_Id</th>
				<th>Name</th>
				<th>Email</th>
				<th>College</th>
				<th>Phone</th>
				<th>Created</th>
			</tr>
			</thead>
			<tbody>
			<?php 
    $con=mysqli_connect("localhost","root","060848","atmos");
    $query="SELECT * FROM users";
    $result = mysqli_query($con,$query);
    $i = 1;
    while ($row=mysqli_fetch_assoc($result))
    {
        echo "<tr>";
        echo "<td>".$i."</td>";
        echo "<td>".$row['pearl_id']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['college']."</td>";
        echo "<td>".$row['phone']."</td>";
        echo "<td>".$row['updated_at']."</td>";
        echo "</tr>";
        $i = $i+1;
    }
			?>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>

