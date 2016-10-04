<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 
include("connection.php");
if(isset($_POST['sdate']))  
{
  $con =mysqli_connect("mysql.hostinger.in","u336397587_per","abcdefgh","u336397587_per");
  $Id=mysqli_real_escape_string($con,$_POST['pearlid']);
  $StartDate=mysqli_real_escape_string($con,$_POST['sdate']);
  $EndDate=mysqli_real_escape_string($con,$_POST['edate']);
  $NoofDays=mysqli_real_escape_string($con,$_POST['noofdays']);
  $Bhavan=mysqli_real_escape_string($con,$_POST['bhavan']);
  $Refund=0;
  $squery="Select * from users where Pearl_Id='$Id' and accom=1";
  $sresult=mysqli_query($con,$squery);
  if(mysqli_num_rows($sresult)>0)
  {
    $Cost=150;
  } 
  else
  {
    $Cost=150+$NoofDays*150;
  }
  if($con)
  {
    $query="insert into Accomodation(Pearl_Id,StartDate,EndDate,NoofDays,Bhavan,Cost,Refund) values('$Id','$StartDate','$EndDate',$NoofDays,'$Bhavan',$Cost,$Refund)";
    if(mysqli_query($con,$query))
    {
      $sql="update rooms set seats_left=seats_left-1 where floor_id='$Bhavan'";
      $col="update dosh_credentials set accom_collect=accom_collect+$Cost WHERE team_id=$team_id";
      if(mysqli_query($con,$sql)&&mysqli_query($con,$col))
      { if($Cost==150)
          echo "You have to Collect Rs. $Cost Only.(Free Accomodation)";
        else
          echo "You have to Collect Rs. $Cost";
      } 
      else
      {
        $dquery="delete from Accomodation where Pearl_Id='$Id'";
        mysqli_query($con,$dquery);
        echo "Seats full";
      }
    }
    else
      echo 'The person has already been Accommodated.';
  }
  else  
    echo 'Cant Connect to Database.Check Your Internet Connection.';
}
?>