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
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="../js/jquery-1.11.3.min.js"></script>
  <script type="text/javascript" src="js/signup.js"></script>
   <!--js end-->
  <link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
  <link href='css/index.css' rel='stylesheet' type='text/css'>
    <!--<link href='css/component.css' rel='stylesheet' type='text/css'>-->
   
 <link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
<script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>

   
 
  <!--css end-->

</head>
<body>
<nav>
 <ul class="navigbar">
    <li><a href="#">Home</a></li>
    <li><a href="../acom/index.php">Accomodation</a></li>
    <li><a href="#">Contact</a></li>
    <li><a href="abcd.php" target="_blank">Generate Excel</a></li>
  <ul style="float:right">
    <li ><a href="#">Team Collection:&nbsp;&nbsp;<?php echo $result['reg_collect']; ?></a></li>
    <li ><a href="logout.php">Log Out</a></li>
  </ul>
 </ul>
</nav>
<div class="container">
	<div class="form">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Register</a></li>
        <li class="tab"><a href="#login">Registered Online</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="signup">   
          <h1 class="heading">Pearl'16 Registration</h1>
          <div class="form-horizontal" role="form" >
  <div class="form-group field-wrap">
    <label for="pearl_id" class="col-sm-2 control-label">Pearl Id</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="" class="form-control" id="pearl_id" name="pearl_id" placeholder="Pearl Id">
    </div>
  </div>
   <div class="form-group field-wrap">
    <label for="name" class="col-sm-2 control-label">Name</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="" class="form-control" id="name" name="name" placeholder="Name">
    </div>
  </div>
   <div class="form-group field-wrap">
    <label for="college" class="col-sm-2 control-label">College</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="" class="form-control" id="college" name="college" placeholder="College">
    </div>
  </div>
   <div class="form-group field-wrap">
    <label for="phone" class="col-sm-2 control-label">Phone</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="" class="form-control" id="phone" name="phone" placeholder="Phone">
    </div>
  </div>
   <div class="form-group field-wrap">
    <label for="email" class="col-sm-2 control-label">Email</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="" class="form-control" id="email" name="email" placeholder="Email">
    </div>
  </div>
  <div class="form-group field-wrap">
   <label class="checkbox-label"><input type="checkbox" class="reg-checkbox checkbox" value="1" name="reg"> Free Registration </label>   
  </div>
  <div class="form-group field-wrap">
   <label class="checkbox-label"><input type="checkbox" class="accom-checkbox checkbox" value="1" name="accom"> Free Accomodation </label>   
  </div>
  
  <button type="submit" style="margin-bottom:40px" class="button button-block register" name="register"/>Sign Up</button>
</div>
        </div>
        
        <div id="login"> 
        <div class="getinfo">
          <div class="field-wrap">
            <label>
              Search Participant<span class="req">*</span>
            </label>
            <input type="text" id="search_query" required autocomplete="off"/>
          </div>
          <button style="margin-bottom:40px" class="button button-block check_details" />Check Participant</button>
        </div>
        <div class="checked">  
          <h1 class="heading">Validate Fields</h1>
          
          <div class="form-horizontal" role="form">
  <div class="form-group field-wrap">
    <label for="valpearl_id" class="col-sm-2 control-label">Pearl Id</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="" class="form-control" id="valpearl_id" name="pearl_id" required placeholder="Pearl Id">
    </div>
  </div>
   <div class="form-group field-wrap">
    <label for="valname" class="col-sm-2 control-label">Name</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="" class="form-control" id="valname" name="name" required placeholder="Name">
    </div>
  </div>
   <div class="form-group field-wrap">
    <label for="valcollege" class="col-sm-2 control-label">College</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="" class="form-control" id="valcollege" name="college" required placeholder="College">
    </div>
  </div>
   <div class="form-group field-wrap">
    <label for="valphone" class="col-sm-2 control-label">Phone</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="" class="form-control" id="valphone" name="phone" required placeholder="Phone">
    </div>
  </div>
   <div class="form-group field-wrap">
    <label for="valemail" class="col-sm-2 control-label">Email</label>
    <div class=" col-sm-offset-1 col-sm-9">
      <input type="" class="form-control" id="valemail"name="email" required placeholder="Email">
    </div>
  </div>
  <div class="form-group field-wrap">
   <label class="checkbox-label"><input type="checkbox" class="reg-o-checkbox checkbox" value="1" name="reg"> Free Registration </label>   
  </div>
  <div class="form-group field-wrap">
   <label class="checkbox-label"><input type="checkbox" class="accom-o-checkbox checkbox" value="1" name="accom"> Free Accomodation </label>   
  </div>

  <button type="submit" style="margin-bottom:40px" class="button button-block registeronline" name="onlineregister"/>Register</button>
</div>
          </div>
        </div>
        
      </div><!-- tab-content -->
      
</div> <!-- /form -->
</div>
<script type="text/javascript" src="js/index.js"></script>
</body>
</html>


