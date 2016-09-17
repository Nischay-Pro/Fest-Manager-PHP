<?php
include("../functions/functions.php");
?>
<html>
<head>
<title>Website</title>
   <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="../js/jquery-1.11.3.min.js"></script>
  <link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
    <!--<link href='css/component.css' rel='stylesheet' type='text/css'>-->
   
 <link type="text/css" rel="stylesheet" href="../bootstrap-3.2.0-dist/css/bootstrap.css">
<script type="text/javascript" src="../bootstrap-3.2.0-dist/js/bootstrap.min.js"></script>
 <style>
    .login-panel {
        margin-top: 150px;
    }
</style>
</head>
<body>
<body>
<div class="container"><!-- container class is used to centered  the body of the browser with some decent width-->
    <div class="row"><!-- row class is used for grid system in Bootstrap-->
        <div class="col-md-4 col-md-offset-4"><!--col-md-4 is used to create the no of colums in the grid also use for medimum and large devices-->
            <div class="login-panel panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><center><b>Push Notification</b></center></h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="POST" action="http://bits-pearl.org/App/send-notification.php">
                        <fieldset>
                            <?php echo getEventdropdown(); ?>
                            <div class="form-group">
                                <textarea class="form-control" rows="5" id="message" name="message"></textarea>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Send Notification" name="register" >
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="results"></div>
</body>
</body>


</html>