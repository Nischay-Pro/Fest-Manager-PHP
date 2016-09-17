<?php
session_start();
include("functions/functions.php");
if(!isset($_SESSION['team_id'])){
  echo "<script>window.open('../reg/login.php','_self')</script>";
}
else{
  $team_id=$_SESSION['team_id'];
  $team_collection=mysqli_query($con,"SELECT * FROM dosh_credentials WHERE team_id='$team_id'");
  $result=mysqli_fetch_array($team_collection);
}
?>
<head>
<style>
#accommodation-step{margin:0;padding:0;}
#accommodation-step li{list-style:none; float:left;padding:5px 10px;border-top:#EEE 1px solid;border-left:#EEE 1px solid;border-right:#EEE 1px solid;}
#accommodation-step li.highlight{background-color:#EEE;}
#accommodation-form{clear:both;border:1px #EEE solid;padding:20px;}
.demoInputBox{padding: 10px;border: #F0F0F0 1px solid;border-radius: 4px;background-color: #FFF;width: 50%;font-weight:bold}
.accommodation-error{color:#FF0000; padding-left:15px;}
.message {color: #00FF00;font-weight: bold;width: 100%;padding: 10;}
.btnAction{padding: 5px 10px;background-color: #09F;border: 0;color: #FFF;cursor: pointer; margin-top:15px;}
#refund{padding-top:-5px;}
#pid{cursor:pointer;cursor:hand;}
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
<script src="../js/jquery-1.11.3.min.js"></script>
<link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
<script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../js/jquery-ui-1.11.4.custom/jquery-ui.css">	
<script src="../js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script>
function valid() {
var output = true;
$(".accommodation-error").html('');
if($("#pid-field").css('display') != 'none') {
	if(!($("#pearlid").val())) {
		output = false;
		$("#pearlid-error").html("required");
	}
	else if(($("#pearlid").val().substring(0,3)!='PLH')||($("#pearlid").val().length!=7))
	{
		output = false;
		$("#pearlid-error").html("wrong format");
	}
}

if($("#acom-field").css('display') != 'none') {
	if(!($("#sdate").val())) {
		output = false;
		$("#sdate-error").html("required");
	}	
	if(!($("#edate").val())) {
		output = false;
		$("#edate-error").html("required");
	}	
	if(!($("#noofdays").val())) {
		output = false;
		$("#noofdays-error").html("required");
	}
	if(!($("#bhavan").val())) {
		output = false;
		$("#bhavan-error").html("required");
	}
}

return output;
}

$(document).ready(function() {
	$("#pearlid").val('PLH');
	$("#pearlid").focus();
	$("#pid").click(function(){ 
		var current = $(".highlight");
		var prev = $(".highlight").prev("li");
		if(prev.length>0) {

			$("#pearlid").val('PLH');
			$("#"+current.attr("id")+"-field").hide();
			$("#"+prev.attr("id")+"-field").show();
			$(".highlight").removeClass("highlight");
			prev.addClass("highlight");
			$("#acom").html("Accommodation");
			$("#beforeacom").show();
			$("#rearly").hide();
			//$("#pid").hide();
			$("#validate").show();
			$("#pearlid").focus();
		}
	});

$('#pearlid').keydown(function(event){    
    if(event.keyCode==13){
       $('#validate').trigger('click');
    }
});

	$("#validate").click(function(){
		var output = valid();
		var flag=0;
		if(output)
		{
			//alert("here")
			$.ajax({
            type: 'POST',
            url: 'fill.php',
			data: {pearlid:$("#pearlid").val()},
            dataType: 'json',
            cache:false,
            success: function(response,status){
					if(response!=-1)
					{	
						$("#acom").html("Refund");
						$("#beforeacom").hide();
						$("#usdate").val(response[0]);
						$("#uedate").val(response[1]);
						$("#oldnoofdays").val(response[2]);
						$("#rearly").show();
						if(response[3]<=7200)
						{
							$("#ref").hide();
							$("#cancel").show();
						}
						else
						{
							$("#cancel").hide();
							$("#ref").show();
						}
					}	
            },
        });	
		$.post("insert.php",{pearlid:$("#pearlid").val()},function(response,status){
		if(response[0]!='t')
		{
			output=false;	
			$("#pearlid-error").html(response);
		}
		if(output) {
			$("#name").val(response.substring(1));
			$("#rname").val(response.substring(1));
			var current = $(".highlight");
			var next = $(".highlight").next("li");
			if(next.length>0) {
				$("#"+current.attr("id")+"-field").hide();
				$("#"+next.attr("id")+"-field").show();
				$(".highlight").removeClass("highlight");
				next.addClass("highlight");
				$("#validate").hide();
				$("#finish").show();
				//$("#pid").show();
			}
		}
		});
		}
	});
	
	$("#refund").click(function(){
		$.post("refund.php",{pearlid:$("#pearlid").val()},function(response,status){
			if(status='success')
			{
			/*$.post("http://personalwork.esy.es/backup/refund.php",{pearlid:$("#pearlid").val(),teamid:<?php echo $result['team_id']; ?>},function(response,status){
		});*/
			alert(response);
			if(response!="He/She wants to Refund Earlier than Original Amount Collected.Use 'Increase Stay or Refund Early' Button")
				$("#pid").click();
			else
				$("#newnoofdays").focus();
		}
		else
			alert("Try Again.")
		});
		
	});
	
	$("#refundearly").click(function(){
		if(($("#newnoofdays").val()))
		{
			if($("#newnoofdays").val()<$("#oldnoofdays").val()&&$("#newnoofdays").val()!=0)
			{
				$.post("refund.php",{pearlid:$("#pearlid").val(),oldnoofdays:$("#oldnoofdays").val(),newnoofdays:$("#newnoofdays").val()},function(response,status){
					if(status='success')
					{	
						/*$.post("http://personalwork.esy.es/backup/refund.php",{pearlid:$("#pearlid").val(),oldnoofdays:$("#oldnoofdays").val(),newnoofdays:$("#newnoofdays").val(),teamid:<?php echo $result['team_id']; ?>},function(response,status){
						});*/
						if(response[0]=='!')
						{
							$("#refund").click();
						}
						else if(response[0]=='#')
						{
							alert(response.substring(1));
							$("#newnoofdays").focus();
						}
						else
						{
							alert(response);
							$("#pid").click();
						}
					}
				});
				
			}
			else if($("#newnoofdays").val()==$("#oldnoofdays").val())
				$("#onod-error").html("Use 'Refund' Button");	
			else
				$("#onod-error").html("Invalid Input.");
		}
		else
		{
			$("#onod-error").html("required");
		}
	});	
	$("#increasestay").click(function(){
		if(($("#newnoofdays").val()))
		{
			if($("#newnoofdays").val()>$("#oldnoofdays").val()&&$("#newnoofdays").val()!=0)
			{
				$.post("refund.php",{pearlid:$("#pearlid").val(),oldnoofdays:$("#oldnoofdays").val(),newnoofdays:$("#newnoofdays").val()},function(response,status){
					if(status='success')
					{	
						$.post("http://personalwork.esy.es/backup/refund.php",{pearlid:$("#pearlid").val(),oldnoofdays:$("#oldnoofdays").val(),newnoofdays:$("#newnoofdays").val(),teamid:<?php echo $result['team_id']; ?>},function(response,status){
						});
					}
					if(response[0]=='!')
					{
						$("#refund").click();
					}
					else if(response[0]=='#')
					{
						alert(response.substring(1));
						$("#newnoofdays").focus();
					}
					else
					{
						alert(response);
						$("#pid").click();
					}
				});
				
			}
			else
				$("#onod-error").html("Invalid Input.Enter total No. of days");
		}
		else
		{
			$("#onod-error").html("required");
		}
	});
	$("#finish").click(function(){
		var output = valid();
		if(output) {
			$.post("insert.php",
			{
				pearlid:$("#pearlid").val(),
				sdate:$("#sdate").val(),
				edate:$("#edate").val(),
				noofdays:$("#noofdays").val(),
				bhavan:$("#bhavan").val()
			},
			function(response,status){
				$.post("http://personalwork.esy.es/backup/insert.php",
				{	
					pearlid:$("#pearlid").val(),
					sdate:$("#sdate").val(),
					edate:$("#edate").val(),
					noofdays:$("#noofdays").val(),
					bhavan:$("#bhavan").val(),
					teamid:<?php echo $result['team_id']; ?>
				},
				function(response,status){
				});
						alert(response);

						$("#pid").click();	
			});
		}
	});

	$("#cancel").click(function() {
		$.post("cancel.php",
			{
					pearlid:$("#pearlid").val(),
					
			},
			function(response,status){
				$.post("http://personalwork.esy.es/backup/cancel.php",
			{
				pearlid:$("#pearlid").val(),
				teamid:<?php echo $result['team_id']; ?>
			},
			function(response,status){
			});
					alert(response);
					$("#pid").click();
			});
	});
	$('#sdate').datepicker({ dateFormat: 'yy-mm-dd',minDate:+0, maxDate: +0 });
	$('#edate').datepicker({ dateFormat: 'yy-mm-dd',minDate:+1, maxDate: new Date(2016,02,21) });
	$(function() {
		$( "#sdate" ).datepicker();
		$( "#edate" ).datepicker();	
	});	
	$("#edate").on("change",function(){
	  var sdate =$( "#sdate" ).datepicker("getDate");
	  var edate=$( "#edate" ).datepicker("getDate");
	  var noofdays=(edate.getTime()-sdate.getTime())/86400000;
	  if(noofdays<=0)
	  {
		  $("#edate-error").html("invalid");
		  $('#noofdays').val(''); 
      }
	  else
	  {
		$("#edate-error").html("");
		$('#noofdays').val(noofdays);    
	  }
	});
	$(function() {
		$.ajax({
            type: 'POST',
            url: 'bhavan.php',
            dataType: 'json',
            cache: false,
            success: function(result) {
                $.each(result,function(key,value) {
					if(value>0)
						$("#bhavan").append('<option value="'+key+'">'+key+"---"+value+"</option>");
				});
            },
        });
	});
});
</script>
</head>
<body>
<nav>
 <ul class="navigbar">
  <li><a href="../reg/index.php">Registration</a></li>
  <li><a href="../acom/index.php">Accommodation</a></li>
  <li><a href="report.php">Generate  Report</a></li>
  <li><a href="abcd.php">Excel</a></li>
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
<label>Pearl ID</label><span id="pearlid-error" class="accommodation-error"></span>
<div><input type="text" name="pearlid" id="pearlid" class="demoInputBox" /></div>
</div>
<div id="acom-field" style="display:none;">
	<div id="beforeacom">
		<label>Name</label>
		<div><input type="text" name="name" id="name" class="demoInputBox" readonly /></div>
		<!--label>Contact No.</label>
		<div><input type="text" name="contact" id="contact" class="demoInputBox" readonly /></div-->
		<label>Start Date</label><span id="sdate-error" class="accommodation-error"></span>
		<div><input type="text" name="sdate" id="sdate" class="demoInputBox"/></div>
		<label>End Date</label><span id="edate-error" class="accommodation-error"></span>
		<div><input type="text" name="edate" id="edate" class="demoInputBox"/></div>
		<label>No of days</label><span id="noofdays-error" class="accommodation-error"></span>
		<div><input type="text" name="noofdays" id="noofdays" class="demoInputBox" readonly /></div>
		<label>Bhavan</label><span id="bhavan-error" class="accommodation-error"></span>
		<div>
			<select name="bhavan" id="bhavan" class="demoInputBox">
			<!--option value="K1">K1</option>
			<option value="K2">K2</option>
			<option value="K3">K3</option>
			<option value="G1">G1</option>
			<option value="G2">G2</option>
			<option value="G3">G3</option>
			<option value="V1">V1</option>
			<option value="V2">V2</option>
			<option value="V3">V3</option>
			<option value="S1">S1</option>
			<option value="S2">S2</option>
			<option value="S3">S3</option>
			<option value="M1">M1</option>
			<option value="M2">M2</option>
			<option value="M3">M3</option>
			<option value="MM1">MM1</option>
			<option value="MM2">MM2</option>
			<option value="MM3">MM3</option>
			<option value="MM4">MM4</option-->
			</select>
		</div>
		<input class="btnAction" type="button" name="finish" id="finish" value="Finish" data-toggle="modal" data-target="#myModal" style="display:none;"><br>
	</div>
</div>
<div>
<!--input class="btnAction" type="button" name="back" id="back" value="Back" style="display:none;"-->
<input class="btnAction" type="button" name="validate" id="validate" value="Validate" >
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
		<input class="btnAction" type="button" name="refundearly" id="increasestay" value="Increase Stay">
		<input class="btnAction" type="button" name="refundearly" id="refundearly" value="Refund Early">
		<br>
	</div>
	<input class="btnAction" type="button" name="cancel" id="cancel" value="Cancel Acommodation">
</div> 
<!--<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">adsa</h4>
      </div>
      <div class="modal-body" id="alert">
      	adsfsad
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Done</button>
      </div>
    </div>
  </div>
</div>-->
</div>
</form>
</div>
</body>