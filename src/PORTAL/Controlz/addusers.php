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
<title>Website</title>
<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
<link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="../../css/sweetalert.css">
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
<body>
<nav>
 <ul class="navigbar">
 <li><a href="index.php">Controlz Panel :P</a></li>
  <li><a href="workshop.php">Back to Workshop Dashboard</a></li>
  <li style="float:right"><a href="logout.php">Log Out</a></li>
  </ul>
 </ul>
</nav>
<div class="container" style="width:50%">
<div class="space"></div>
<form class="form-horizontal" action="workshopcall.php" role="form" method="GET">
              <input type="hidden" name="action" value="registerUser">
              <input type="hidden" name="iscoupon" id="coupon-hidden" value="0">
                  <div class="form-group">
                    <label  class="col-sm-2 control-label"
                              for="sel1">Workshop Name</label>
                    <div class="col-sm-10">
                        <?php getWorkshopDropdown(); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"
                          for="Roundname" >Participant ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control"
                            id="part-id" name="userid" placeholder="Enter Participant ID"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <input class="col-sm-6 btn btn-lg btn-success" onclick="checkCoupon()" value="Check and Apply Coupon" name="register" >
                    <div class="col-sm-6">
                        <input type="text" class="form-control"
                            id="coupon" disabled placeholder="Coupon Not Applied (default)."/>
                    </div>
                  </div>
                                   
      </div>
      
        <input class="btn btn-lg btn-success col-sm-6" style="margin-left:25vw" type="submit" value="Add User" name="register" >
      </div>
      </form>
      </div>
<script type="text/javascript">
$(document).ready(function(){
  $('#datetimepicker').click(function(){
    $(this).datetimepicker({
      lang:'en',
      minDate:0,
      maxDate:'15.10.2016',
      formatDate:'d.m.Y',
      allowTimes:['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00']
    });
  });
});

function checkCoupon(){
  var user = document.getElementById('part-id').value;
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var dat = JSON.parse(this.responseText);
      if(dat.message){
        swal({
          title: 'Add Coupon?',
          text: 'Only one coupon, mofo. Use wisely.',
          type: 'info',
          showCancelButton: true,
          closeOnConfirm: true,
          disableButtonsOnConfirm: true,
          confirmLoadingButtonColor: '#DD6B55'
        }, function(isConfirm){
          if(isConfirm){
            document.getElementById('coupon').value="Coupon Applied.";
            document.getElementById('coupon-hidden').value=1;
          }
          else{
            document.getElementById('coupon').value="Coupon Not Applied.";
            document.getElementById('coupon-hidden').value=0;
          }
        });
      }
      else{
          document.getElementById('coupon').value="Coupon Not Available.";
          document.getElementById('coupon-hidden').value=0;
      }
    }
  };
  request.open("GET", "workshopcall.php/?action=checkCouponUser&userid="+user, true);
  request.send();
}

</script>
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/ >
<script src="js/jquery.datetimepicker.js"></script>
      
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