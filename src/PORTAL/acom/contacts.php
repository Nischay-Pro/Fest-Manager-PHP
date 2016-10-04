<?php
session_start();
include("functions/functions.php");
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
  <title>Important Contacts</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<script src="../js/jquery-1.11.3.min.js"></script>
<link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
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
								<th>Name</th>
								<th>Contact No.</th>
						</thead>
						<tbody>
							<tr>
								<td>Aditya Taank</td>
								<td>8185092055</td>
							</tr>
							<tr>
								<td>Deepak Gupta </td>
								<td>7730090396</td>
							</tr>
							<tr>
								<td>Monil Shah</td>
								<td>9553305670</td>
							</tr>
							<tr>
								<td>Ayush Beria</td>
								<td>9553324287</td>
							</tr>
							<tr>
								<td>Harshit Agarwal</td>
								<td>9912249068</td>
							</tr>
							<tr>
								<td>Saif Ali</td>
								<td>8096834915</td>
							</tr>
							<tr>
								<td>Ankit Babbar</td>
								<td>8501925941</td>
							</tr>
							<tr>
								<td>Saumya Gattani</td>
								<td>8184988310</td>
							</tr>
							<tr>
								<td>Madhav Singh Gurjar</td>
								<td>9603668171</td>
							</tr>
							<tr>
								<td>Harshit Srivastava</td>
								<td>7729090111</td>
							</tr>
							<tr>
								<td>Aayush Agarwal</td>
								<td>9542972480</td>
							</tr>
							<tr>
								<td>Hemang Korant</td>
								<td>8465049847</td>
							</tr>

							<tr>
								<td>M Binu Valencia</td>
								<td>9603187172</td>
							</tr>

							<tr>
								<td>Tirthankar Saha</td>
								<td>7729076444</td>
							</tr>
							<tr>
								<td>Mohit Tunwal</td>
								<td>8187076498</td>
							</tr>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	</div>


</body>
</html>