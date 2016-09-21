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
    <title>Sign Up /Login</title>
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
        <script type="text/javascript">
        $(document).ready(function(){
        function ShowAndClear(data){
        alert(data);
        $('#valname').attr('value','');
        $('#valemail').attr('value','');
        $('#valpearl_id').attr('value','');
        $('#valcollege').attr('value','');
        $('#valphone').attr('value','');
        $('#name').val('');
        $('#email').val('');
        $('#pearl_id').val('');
        $('#college').val('');
        $('#phone').val('');
        $('.checked').hide();
        $('.getinfo').show();
        }
        $('.checked').hide();
        $('.check_details').click(function(){
        var detail=$('#search_query').val();
        $.post('http://learnwebbing.hol.es/pearlreg/reg_16.php',{detail:detail},function(response,status){
        $.each(response , function (index, value) {
        if(index=='name'){
        $('#valname').attr('value',value);
        }
        else if(index=='email'){
        $('#valemail').attr('value',value);
        }
        else if(index=='college'){
        $('#valcollege').attr('value',value);
        }
        else if(index=='phone'){
        $('#valphone').attr('value',value);
        }
        });
        $('.getinfo').hide();
        $('.checked').show();
        },"json");
        });
        $('.registeronline').click(function(){
        // todo start work here
        var pearl_id=$('#valpearl_id').val();
        var email=$('#valemail').val();
        var college=$('#valcollege').val();
        var phone=$('#valphone').val();
        var name=$('#valname').val();
        var reg,accom;
        
        if($('.reg-o-checkbox').prop("checked") == true){
        reg=1;
        }
        else if($('.reg-o-checkbox').prop("checked") == false){
        reg=0;
        }
        
        if($('.accom-o-checkbox').prop("checked") == true){
        accom=1;
        }
        else if($('.accom-o-checkbox').prop("checked") == false){
        accom=0;
        }
        
        if(pearl_id==''||college==''||name==''||email==''||phone==''){
        alert('Please fill all fields');
        }
        
        else{
        $.post('register.php',{pearl_id:pearl_id,college:college,name:name,email:email,phone:phone,reg:reg,accom:accom},function(data,status){
        ShowAndClear(data);
        
        });
        }
        
        });
        $('.register').click(function(){
        // todo start work here
        var pearl_id=$('#pearl_id').val();
        var email=$('#email').val();
        var college=$('#college').val();
        var phone=$('#phone').val();
        var name=$('#name').val();
        var reg,accom;
        
        if($('.reg-checkbox').prop("checked") == true){
        reg=1;
        }
        else if($('.reg-checkbox').prop("checked") == false){
        reg=0;
        }
        
        if($('.accom-checkbox').prop("checked") == true){
        accom=1;
        }
        else if($('.accom-checkbox').prop("checked") == false){
        accom=0;
        }
        
        if(pearl_id==''||college==''||name==''||email==''||phone==''){
        alert('Please fill all fields');
        }
        
        else{
        $.post('register.php',{pearl_id:pearl_id,college:college,name:name,email:email,phone:phone,reg:reg,accom:accom},function(data,status){
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
        </style>
      </body>
    </html>