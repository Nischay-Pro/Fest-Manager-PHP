<?php
session_start();
include("functions/functions.php");
include("dynamic.php");
$team_id=$_SESSION['team_id'];
if(isset($_POST['sdate']))	
{
	$Id=mysqli_real_escape_string($con,$_POST['pearlid']);
	$StartDate=mysqli_real_escape_string($con,$_POST['sdate']);
	$EndDate=mysqli_real_escape_string($con,$_POST['edate']);
	$NoofDays=mysqli_real_escape_string($con,$_POST['noofdays']);
	$Bhavan=mysqli_real_escape_string($con,$_POST['bhavan']);
	$Refund=0;
	$squery="Select * from users where Pearl_id='$Id' and accom=1";
	$sresult=mysqli_query($con,$squery);
	if(mysqli_num_rows($sresult)>0)
	{
		$Cost=100;
	} 
	else//Dynamic Pricing
	{
		$Cost=100 + accomcost($NoofDays);
	}
	if($con)
	{
		$query="insert into accomodation(Pearl_Id,StartDate,EndDate,NoofDays,Bhavan,Cost,Refund) values('$Id','$StartDate','$EndDate',$NoofDays,'$Bhavan',$Cost,$Refund)";
		if(mysqli_query($con,$query))
		{
			$sql="update rooms set seats_left=seats_left-1 where floor_id='$Bhavan'";
			$col="update dosh_credentials set accom_collect=accom_collect+$Cost WHERE team_id=$team_id";
			if(mysqli_query($con,$sql)&&mysqli_query($con,$col))
			{	if($Cost==150)
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
			echo 'Accomodation Failed.';
	}
	else	
		echo 'Cant Connect to Database.Check Your Internet Connection.';
}
else if(isset($_POST['pearlid']))
{
	$Id=mysqli_real_escape_string($con,$_POST['pearlid']);
	if($con)
	{
		$query="Select * from users where Pearl_Id='$Id'";
		if($query_run=mysqli_query($con,$query))
		{
			$result=mysqli_query($con,$query);
			if(mysqli_num_rows($result)!=0)
			{	
				$row=mysqli_fetch_assoc($result);
				echo "t".$row['name'];
			}
			else
				echo 'invalid id';
		}
		else
		{	
			echo 'improper connection';
		}
	}
	else
	{
		echo 'Cant Connect to Database.Check Your Internet Connection.';
	}
}
?>