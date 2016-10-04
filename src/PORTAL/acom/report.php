<?php
session_start();
include("functions/functions.php");
// REPORT DELETE =0?
if(!isset($_SESSION['team_id'])){
  echo "<script>window.open('login.php','_self')</script>";
}
else{
  $team_id=$_SESSION['team_id'];
  $team_collection=mysqli_query($con,"SELECT * FROM dosh_credentials WHERE team_id='$team_id'");
  $result=mysqli_fetch_array($team_collection);
}
?>
<html>
<head>
  <title>Pending Refunds</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<script src="../js/jquery-1.11.3.min.js"></script>
<link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
<script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../js/jquery-ui-1.11.4.custom/jquery-ui.css">	
<script src="../js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
  <style type="text/css">
  	body { width:100%; }
.floatThead-floatContainer { left: inherit !important; }
.filters { background-color: aqua;}
.filterable { margin-top: 15px; }
.filterable .panel-heading .pull-right { margin-top: -20px; }
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
  padding:2em 0.5em;
  font-size:1.5em;
  }
  </style>
</head>
<body>
	<nav>
 <ul class="navigbar">
  <li><a href="../reg/index.php">Registration</a></li>
  <li><a href="../acom/index.php">Accommodation</a></li>
  <!--li><a href="report.php">Pending Refunds</a></li-->
  <li><a href="AcomExcel.php">Excel</a></li>
  <li><a href="#">Team</a></li>
  <ul style="float:right">
  <li ><a href="#">Team Collection:&nbsp;&nbsp;<?php echo $result['accom_collect']; ?></a></li>
  <li ><a href="logout.php">Log Out</a></li>
  </ul>
 </ul>
</nav>
<div class="space" style="height:8%;width:100%"></div>
	<div class="container">
    <div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary filterable">
				<div class="table-responsive">
					<table id="mytable" class="table table-striped">
						<thead class="filters">
							<tr>
								<th>Pearl_Id</th>
								<th>Name</th>
								<th>Contact No.</th>
								<th>Email</th>
								<th>Bhavan</th>
								<th>Refund Date</th>
							</tr>
						</thead>
						<tbody>
							<?php
									include("functions/functions.php");
									$query="Select Pearl_Id,Name,phone,email,Bhavan,DATE_FORMAT(EndDate,'%D %M') as 'RefundDate' from Accomodation Natural Join Users where dayofyear(curdate())>=dayofyear(enddate) and refund=0";
									$result=mysqli_query($con,$query);
									if(mysqli_num_rows($result)>0)
									{
										while($row=mysqli_fetch_assoc($result))
										{
											echo "<tr>";
											echo "<td>".$row['Pearl_Id']."</td>";
											echo "<td>".$row['Name']."</td>";
											echo "<td>".$row['phone']."</td>";
											echo "<td>".$row['email']."</td>";
											echo "<td>".$row['Bhavan']."</td>";
											echo "<td>".$row['RefundDate']."</td>";
											echo "</tr>";
										}	
									}
									?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	</div>
</body>
</html>