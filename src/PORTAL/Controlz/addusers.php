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
<form class="form-horizontal" action="workshopcall.php" role="form" method="GET">
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
                    <input id="coupon-button" class="col-sm-12 btn btn-lg btn-success" onclick="startTransfer()" value="Check Workshop Paid Online">
                  </div>
                                   
      </div>
      
        <input id="submit-button" disabled="true" class="btn btn-lg btn-success col-sm-6" style="margin-left:25vw;" type="submit" value="Add User" name="register">
      </div>
      </form>
      </div>
<script type="text/javascript">
var currentworkshop = {};
$(document).ready(function(){
  updateData(document.getElementById('sel1'));
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

function updateData(select){
  var workshopobject = select.options[select.selectedIndex];
  var workshopid = workshopobject.value;
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var dat = JSON.parse(this.responseText);
      //var dat = this.responseText;
      dat = dat[0];
      console.log(dat);
      currentworkshop = dat;
      document.getElementById('bitsian-holder').value = currentworkshop.max_count_bits - currentworkshop.current_count_bits;
      document.getElementById('outsider-holder').value = currentworkshop.max_count_general - currentworkshop.current_count_general;
    }
  };
  request.open("GET", "workshopcall.php?action=getDataWorkshop&id="+workshopid, true);
  request.send();
}
function startTransfer(){
    
}
function checkCoupon(){
  var user = document.getElementById('part-id').value;
  var costholder = document.getElementById('cost-holder');
  if(costholder.value>150){
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var dat = JSON.parse(this.responseText);
        if(dat.message){
          swal({
            title: 'Add Coupon?',
            text: 'You can apply only one coupon.',
            type: 'info',
            showCancelButton: true,
            closeOnConfirm: true,
            disableButtonsOnConfirm: true,
            confirmLoadingButtonColor: '#DD6B55'
          }, function(isConfirm){
            if(isConfirm){
              document.getElementById('coupon').value="Coupon Applied.";
              //TODO toastr
              document.getElementById('cost-holder').value-=150;
              document.getElementById('coupon-hidden').value=1;
              document.getElementById('coupon-button').disabled=true;
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
  else {
    document.getElementById('coupon').value="Coupon cannot be applied.";
    document.getElementById('coupon-hidden').value=0;
  }
  
}

var inputfield = document.getElementById('part-id');
inputfield.addEventListener("keyup", function(){
  var partid = inputfield.value;
  var button = document.getElementById('submit-button');
  var partidval = partid.match(/[fhFH](20)\d{5}/g);
  var valid = false;
  var outsider = true;
  if (partidval != null && partid.length==8){
    document.getElementById('coupon-button').disabled = false;
    outsider = false;
    valid = true;
  }
  if(partid.startsWith('ATMH')){
    document.getElementById('coupon-button').disabled = true;
    outsider = true;
    valid = true;
  }
  if(partid.length == 0){
    inputfield.style.background = "#ffffff";
    document.getElementById('cost-holder').value=0;
    return;
  }
  if(!valid){
    inputfield.style.background = "#ffaaaa";
    button.disabled = true;
    document.getElementById('cost-holder').value=0;
    return;
  }
  button.disabled = false;
  var seats = outsider? document.getElementById('outsider-holder').value : document.getElementById('bitsian-holder').value;
  var cost = outsider? currentworkshop.cost_general : currentworkshop.cost_bits;
  if(seats == 0){
    button.disabled = true;
    inputfield.style.background = "#eeee55";
    return;
  }
  document.getElementById('outsider').value=outsider?1:0;
  document.getElementById('cost-holder').value=cost;
  if(outsider){
    inputfield.style.background = "#aaeebb";
    return;
  }
  if(!outsider){
    inputfield.style.background = "#aaccdd";
    return;
  }
}); 

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