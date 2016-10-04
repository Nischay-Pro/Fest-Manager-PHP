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
<ul id="accommodation-step">
<li id="pid" class="highlight">Validation</li>
<li id="acom">Accommodation</li>
<li id="update" style="display:none;">Update</li>
</ul>
<form name="frmaccommodation" id="accommodation-form" method="post">
<div id="pid-field">
	<input style="display:none">
<input type="password" style="display:none">
<label>Atmos ID</label><span id="pearlid-error" class="accommodation-error"></span>
<div><input type="text" name="pearlid" id="pearlid" class="demoInputBox" /></div>
</div>
<div id="acom-field" style="display:none;">
	<div id="beforeacom">
		<label>Name</label>
		<div><input type="text" name="name" id="name" class="demoInputBox" readonly /></div>
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
		<input class="btnAction" type="button" name="finish" id="finish" value="Finish" style="display:none;"><br>
	</div>
</div>
<div>
<input class="btnAction" type="button" name="validate" id="validate" value="Validate">

<div id="rearly" style="display:none;">
	<label>Name</label>
	<div><input type="text" name="rname" id="rname" class="demoInputBox" readonly /></div>
	<label>Start Date</label>
	<div><input type="text" name="usdate" id="usdate" class="demoInputBox" readonly /></div>
	<label>End Date</label>
	<div><input type="text" name="uedate" id="uedate" class="demoInputBox" readonly /></div	>
	<label>Original No of days</label>
	<div><input type="text" name="oldnoofdays" id="oldnoofdays" class="demoInputBox" readonly /></div>
	<div id="ref">
		<input class="btnAction" type="button" name="refund" id="refund" value="Refund">
		<hr width="100%">
		<label>New No of days</label><span id="onod-error" class="accommodation-error"></span>
		<div><input type="text" name="newnoofdays" id="newnoofdays" class="demoInputBox"/></div>
		<input class="btnAction" type="button" name="refundearly" id="increasestay" value="Increase Stay" >
		<input class="btnAction" type="button" name="refundearly" id="refundearly" value="Refund Early" >
		<br>
	</div>
	<input class="btnAction" type="button" name="cancel" id="cancel" value="Cancel Acommodation">
</div> 
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm
            </div>
            <div class="modal-body">
                Are you Sure you Want to Cancel The Accomodation??
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <a class="btn btn-danger btn-ok" id="yesbtn">Yes</a>
            </div>
        </div>
    </div>
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

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="confirmModalLabel"></h4>
      </div>
      <div class="modal-body">
       		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="no" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="yes" data-dismiss="modal">Yes</button>
      </div>
    </div>
  </div>
</div>


</div>
</form>
<br><br>
<p> If they haven't registered, but need to avail Accom <a type="button" href="noreg.php" id="noreg" data-dismiss="modal">Click here</a></p>
</div>
</body>