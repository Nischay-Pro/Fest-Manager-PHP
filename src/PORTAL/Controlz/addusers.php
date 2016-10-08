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
<html>
<head>
<title>Add User To Workshop</title>
<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
<link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="../../css/sweetalert.css">
        <link type="text/css" rel="stylesheet" href="../../css/toastr.min.css">
    <script type="text/javascript" src="../../js/toastr.min.js"></script>
            <script type="text/javascript" src="../../js/toastr-options.js"></script>
<script type="text/javascript" src="../../js/sweetalert.min.js"></script>
<script type="text/javascript" src="../../js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
<link type="text/css" rel="stylesheet" href="css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <style type="text/css">
 .space{
    width:100%;
    height: 50px;
  }</style>
</head>
<body>
<nav>
 <ul class="navigbar">
 <li><a href="index.php">Events Dashboard</a></li>
  <li><a href="workshop.php">Back to Workshop Dashboard</a></li>
  <li><a href="users.php">See Registered Users</a></li>
  <li style="float:right"><a href="logout.php">Log Out</a></li>
  </ul>
<div class="container" style="width:50%">
<div class="space"></div>
<form class="form-horizontal" id="my-fucking-form" action="workshopcall.php" style="margin-bottom:0px;" role="form" method="GET">
              <input type="hidden" name="action" value="registerUser">
              <input type="hidden" name="outsider" id="outsider">
              <input type="hidden" name="iscoupon" id="coupon-hidden" value="0">
                  <div class="form-group">
                    <label  class="col-sm-5 control-label"
                              for="sel1">Workshop Name</label>
                    <div class="col-sm-7">
                        <?php getWorkshopDropdown(); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label  class="col-sm-9 control-label"
                              for="sel1">Bitsian Vacancies Available</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="event-cost"
                            id="bitsian-holder" disabled placeholder=""/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label  class="col-sm-9 control-label"
                              for="sel1">Outsider Vacancies Available</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="event-cost"
                            id="outsider-holder" disabled placeholder=""/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"
                          for="Roundname" >Participant ID</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"
                            id="part-id" name="userid" placeholder="Enter Participant ID"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label  class="col-sm-6 control-label"
                              for="sel1">Workshop Cost</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="event-cost"
                            id="cost-holder" disabled placeholder="Calculate Cost"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <input id="coupon-button" class="col-sm-6 btn btn-lg btn-success" onclick="checkCoupon()" value="Check and Apply Coupon">
                    <div class="col-sm-6">
                        <input type="text" class="form-control"
                            id="coupon" disabled placeholder="Coupon Not Applied (default)."/>
                    </div>
                  </div>
                <div class="form-group">
                    <input id="coupon-button" style="display: none" class="col-sm-12 btn btn-lg btn-success" onclick="verifyPayment()" value="Check Workshop Paid Online">
                  </div>
                                   
      </div>
        <input id="submit-button" disabled="true" class="btn btn-lg btn-success col-sm-6" style="margin-left:25vw;"value="Add User" name="register" onclick="addUser()">
      </div>
      </form>
      </div>
<script type="text/javascript" src="js/addusers.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/ >
<script src="js/jquery.datetimepicker.js"></script>
<script type="text/javascript">
window.onload=function(e){
  last_message = <?php echo $_GET['messageid']; ?>;
  console.log("MessageID",last_message);
  var messages = [];
  var titles = [];
  var types = [];

  //0
  titles.push("Success");
  types.push("success");
  messages.push("Successfully registered User to Workshop.");
  //1
  titles.push("Something Went Wrong.");
  types.push("error");
  messages.push("Serious Technical Error. Please contact DOTA.");
  //2
  titles.push("User Already Registered");
  types.push("error");
  messages.push("User has already registered for this workshop.");
  //3
  titles.push("No Seats Available");
  types.push("error");
  messages.push("No seats available for Outsiders. User cannot be registered.");
  //4
  titles.push("No Seats Available");
  types.push("error");
  messages.push("No seats available for Bitsians. User cannot be registered.");

  titles[69] = "Position Already Taken";
  types[69] = "warning";
  messages[69] = "Position '69' already taken. Try 96 maybe.";
  if(last_message!=undefined){
    swal(titles[last_message],messages[last_message],types[last_message]);
  }
}


</script>
<?php
if(isset($_POST['register'])){
  $Event_date=$_POST['Event_date'];
  $Roundname=$_POST['Roundname'];
  $Event_id=$_POST['Event_id'];
  $Event_venue=$_POST['Event_venue'];
  $timezone='GMT+5:30';
  $Event_date.=$timezone;
  $Event_date=strtotime($Event_date);
  $run=mysqli_query($con,"INSERT INTO event_details(Event_id,Event_date,Roundname,Event_venue,updated_at) VALUES('$Event_id','$Event_date','$Roundname','$Event_venue','$Event_date')");
  if($run){
    //query pass
    
  }
  else{
    // query failed
  }
}
?>
</body>
<html>