<?php
session_start();//session starts here
include("../functions/functions.php");
?>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="../js/jquery-1.11.3.min.js"></script>
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
                    <h3 class="panel-title">Admin Login</h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="login.php">
                        <fieldset>
                            <div class="form-group"  >
                                <input class="form-control" placeholder="Admin Id" name="admin_id" type="number" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Admin Password" name="admin_password" type="password" value="">
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
    $admin_id=mysqli_real_escape_string($con,$_POST['admin_id']);
    $admin_password=md5(mysqli_real_escape_string($con,$_POST['admin_password']));
    $check_user=mysqli_query($con,"SELECT * FROM  admin WHERE admin_id='$admin_id'AND admin_password='$admin_password'");
    $rows=mysqli_num_rows($check_user);
    if($rows)
    {
        $_SESSION['admin_id']=$admin_id;
        echo "<script>window.open('index.php','_self')</script>";
    }
    else
    {
        echo "<script>alert('Email or password is incorrect!')</script>";
    }
}
?>