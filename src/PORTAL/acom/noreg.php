<?php
session_start();
include("functions/functions.php");
if(!isset($_SESSION['team_id'])){
  echo "<script>window.open('../acom/login.php','_self')</script>";
}
else{
  $team_id=$_SESSION['team_id'];
  $team_collection=mysqli_query($con,"SELECT * FROM dosh_credentials WHERE team_id='$team_id'");
  $result=mysqli_fetch_array($team_collection);
}
?>
<head>
<script src="../js/jquery-1.11.3.min.js"></script>
<link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="css/acom.css">
<script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../js/jquery-ui-1.11.4.custom/jquery-ui.css">	
<script src="../js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script src="js/acom.js">
</script>
</head>
<body>
<nav>
 <ul class="navigbar">
  <li><a href="../reg/index.php">Registration</a></li>
  <li><a href="report.php">Pending Refunds</a></li>
  <li><a href="AcomExcel.php">Excel</a></li>
  <li><a href="#">Team</a></li>
  <ul style="float:right">
  <li ><a href="#">Team Collection:&nbsp;&nbsp;<?php echo $result['accom_collect']; ?></a></li>
  <li ><a href="logout.php">Log Out</a></li>
  </ul>
 </ul>
</nav>
<div class="space" style="height:12%;width:100%"></div>
<div class="container" >

<form>
<div id="acom-field">
	<div id="beforeacom">
		<label>Name</label><span id="name-error" class="accommodation-error"></span>
		<div><input type="text" name="name" id="name" class="demoInputBox" /></div>

		<label>Fest ID</label><span id="id-error" class="accommodation-error"></span>
		<div><input type="text" name="festId" id="festId" class="demoInputBox" /></div>

		<label>College</label><span id="clg-error" class="accommodation-error"></span>
		<div><input type="text" name="college" id="college" class="demoInputBox" /></div>	
		<label>Phone Number</label><span id="num-error" class="accommodation-error"></span>
		<div><input type="text" name="phone" id="phone" class="demoInputBox" /></div>
		<label>Email</label><span id="email-error" class="accommodation-error"></span>
		<div><input type="text" name="email" id="email" class="demoInputBox" /></div>

		<label>Start Date</label><span id="sdate-error" class="accommodation-error"></span>
		<div><input type="text" name="sdate" id="sdate" class="demoInputBox"/></div>
		<label>End Date</label><span id="edate-error" class="accommodation-error"></span>
		<div><input type="text" name="edate" id="edate" class="demoInputBox"/></div>
		<label>No of days</label><span id="noofdays-error" class="accommodation-error"></span>
		<div><input type="text" name="noofdays" id="noofdays" class="demoInputBox" readonly /></div>
		<label>In Campus/Off Campus</label><span class="accommodation-error"></span>
		<div>
			<select name="acomplace" id="place" class="demoInputBox">
			<option value =0>On Campus</option>
			<option value=1>Off Campus</option>
			</select>
		</div>
		<div class="bhavanclass">
		<label class="oncampus">Bhavan</label><span id="bhavan-error" class="accommodation-error"></span>
		<div>
			<select name="bhavan" id="bhavan" class="demoInputBox oncampus">
			</select>
		</div>
		</div>
		<div style="display:none;" class="outsideclass">
		<label class="ocampus">Off Campus</label><span class="accommodation-error"></span><br>
		
		
			<select name="offcampus" class="demoInputBox ocampus">
			</select>
		</div>
		<input class="btnAction" name="finish" type="button" id="noregsubmit" value="Finish">
	</div>
</div>
<div>
</div>
</label>
</div>
</div>
</form>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
       		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Done</button>
      </div>
    </div>
  </div>
</div>
</body>
