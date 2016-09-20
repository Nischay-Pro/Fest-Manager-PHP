<?php
session_start();
include("../functions/functions.php");
if(!isset($_SESSION['team_id'])){
  echo "<script>window.open('login.php','_self')</script>";
}
else{
  $team_id=$_SESSION['team_id'];
  $team_collection=mysqli_query($con,"SELECT * FROM dosh_credentials WHERE team_id='$team_id'");
  $result=mysqli_fetch_array($team_collection);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Corrections</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="../js/jquery-1.11.3.min.js"></script>
  <script type="text/javascript" src="js/signup.js"></script>
   <!--js end-->
  <link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
    <!--<link href='css/component.css' rel='stylesheet' type='text/css'>-->
   
 <link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
<script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>

   
 
  <!--css end-->

</head>
<body>
<nav>
 <ul class="navigbar">
  <li><a href="index.php">Home</a></li>
  <li><a href="../acom/index.php">Accomodation</a></li>
  <li><a href="#">Contact</a></li>
  <ul style="float:right">
  <li ><a href="#">Team Collection:&nbsp;&nbsp;<?php echo $result['reg_collect']; ?></a></li>
  <li ><a href="logout.php">Log Out</a></li>
  </ul>
 </ul>
</nav>
<div class="container">
	<div class="form">
       <div id="login"> 
        <div class="getinfo">
          <div class="field-wrap">
            <label>
              Search Participant<span class="req">*</span>
            </label>
            <input type="text" id="correct_query" required autocomplete="off"/>
          </div>
          <button style="margin-bottom:40px" class="button button-block check_details" />Check Participant</button>
        </div>
        <div class="checked">  
          <h1 class="heading">Correct Fields</h1>
          
          <div class="form-horizontal" role="form">
  <div class="form-group field-wrap">
    <label for="valpearl_id" class="col-sm-2 control-label">Pearl Id</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="text" disabled class="form-control" id="correct_pearl_id" name="pearl_id" required placeholder="Pearl Id">
    </div>
  </div>
   <div class="form-group field-wrap">
    <label for="valname" class="col-sm-2 control-label">Name</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="" class="form-control" id="correct_name" name="name" required placeholder="Name">
    </div>
  </div>
   <div class="form-group field-wrap">
    <label for="valcollege" class="col-sm-2 control-label">College</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="" class="form-control" id="correct_college" name="college" required placeholder="College">
    </div>
  </div>
   <div class="form-group field-wrap">
    <label for="valphone" class="col-sm-2 control-label">Phone</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="" class="form-control" id="correct_phone" name="phone" required placeholder="Phone">
    </div>
  </div>
   <div class="form-group field-wrap">
    <label for="valemail" class="col-sm-2 control-label">Email</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="" class="form-control" id="correct_email"name="email" required placeholder="Email">
    </div>
  </div>
    <button type="submit" style="margin-bottom:40px" class="button button-block correctdetails" name="correctdetails"/>Update Details</button>
</div>
          </div>
        </div>     
</div> <!-- /form -->
</div>
<script type="text/javascript">
    $(document).ready(function(){
      function ShowAndClear(data){
  alert(data);
  $('#correct_name').attr('value','');
  $('#correct_email').attr('value','');
  $('#correct_pearl_id').attr('value','');
  $('#correct_college').attr('value','');
  $('#correct_phone').attr('value','');
  $('.checked').hide();
    $('.getinfo').show();
}
  $('.checked').hide();
  $('.check_details').click(function(){
    var detail=$('#correct_query').val();
    $.post('ajax.php',{detail:detail},function(response,status){
      $.each(response , function (index, value) {
        if(index=='name'){
          $('#correct_name').attr('value',value);
        }
        else if(index=='email'){
          $('#correct_email').attr('value',value);
        }
        else if(index=='college'){
          $('#correct_college').attr('value',value);
        }
        else if(index=='phone'){
          $('#correct_phone').attr('value',value);
        }
        });
      $('#correct_pearl_id').attr('value',detail);
      $('.getinfo').hide();
      $('.checked').show();
    },"json");
  });  
  $('.correctdetails').click(function(){
    // todo start work here
    var pearl_id=$('#correct_pearl_id').val();
    var email=$('#correct_email').val();
    var college=$('#correct_college').val();
    var phone=$('#correct_phone').val();
    var name=$('#correct_name').val();
    if(pearl_id==''||college==''||name==''||email==''||phone==''){
      alert('Please fill all fields');
    }
   
      else{
      $.post('update.php',{pearl_id:pearl_id,college:college,name:name,email:email,phone:phone},function(data,status){
    ShowAndClear(data);
      
    });
    }
    
  });
});

</script>

<style type="text/css">
  .heading{
    color:white;
  }
  body{
     font-family: 'Slabo 27px', serif;
  }
  input[type="text"]{
    color:white;
  }
  .field-wrap label{
    color:white;
    font-weight:400;
    
  }
  .control-label{
    color:white;
  }
  .checkbox{
    width:20%;
  }
  #inputEmail3{
    color:black;
  }
  .navigbar{
    z-index:999 ;
  }
  .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control{
    color:black;
  }
</style>
</body>
</html>


