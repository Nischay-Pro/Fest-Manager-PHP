<?php
session_start();//session starts here
include("../functions/functions.php");
?>
<html>
<head lang="en">
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <script src="../js/jquery-1.11.3.min.js"></script>
        <link type="text/css" rel="stylesheet" href="../../css/toastr.min.css">
    <script type="text/javascript" src="../../js/toastr.min.js"></script>
            <script type="text/javascript" src="../../js/toastr-options.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
    <!--<link href='css/component.css' rel='stylesheet' type='text/css'>-->
   
 <link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
<script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
</head>
<style>
    .login-panel {
        margin-top: 150px;
    }
</style>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Sign In</h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="login.php">
                        <fieldset>
                            <div class="form-group"  >
                                <input class="form-control" placeholder="Controlz Id" name="controlz_id" type="number" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="controlz_pass" type="password" value="">
                            </div>
                                <input class="btn btn-lg btn-success btn-block" type="submit" value="Login" name="login" >
                        </fieldset>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php
if(isset($_POST['login']))
{
    $controlz_id=mysqli_real_escape_string($con,$_POST['controlz_id']);
    $controlz_pass=mysqli_real_escape_string($con,$_POST['controlz_pass']);
    $check_user=mysqli_query($con,"SELECT * FROM  controlz_credentials WHERE controlz_id='$controlz_id'AND controlz_pass='$controlz_pass'");
    $rows=mysqli_num_rows($check_user);
    if($rows)
    {
        $_SESSION['controlz_id']=$controlz_id;
        echo "<script>window.open('index.php','_self')</script>";
    }
    else
    {
        echo "<script>alert('id - password combination is incorrect!')</script>";
    }
}
?>