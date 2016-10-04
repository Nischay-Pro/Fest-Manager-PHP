<?php
	session_start();
	include("functions/functions.php");
	$team_id=$_SESSION['team_id'];
	$Id=mysqli_real_escape_string($con,$_POST['pearlid']);
	$query="Select Updated_At,Bhavan,Cost from accomodation where Pearl_ID='$Id' AND deleted='0'";
	$result=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($result);
	date_default_timezone_set('Asia/Kolkata');
	//$curtime=strtotime(date("m/d/Y G:i:s",time()));
	$curtime= strtotime(date("Y-m-d G:i:s"));
	//$curtime=Date('U');
	$updatedat=strtotime($row['Updated_At']);
	$Bhavan=$row['Bhavan'];
	$Cost=$row['Cost'];
	$gap=$curtime-$updatedat+21600;
	//echo date("m/d/Y G:i:s",time())." ".$row['Updated_At']." ".$gap;
	if($gap<9000)
	{
		//$dquery="Delete From accomodation where Pearl_Id='$Id'";///Change to update with 0/1
		$dquery="update accomodation set deleted ='1' where Pearl_Id='$Id'";
		if(mysqli_query($con,$dquery))
		{
			$rquery="update rooms set seats_left=seats_left+1 where floor_id='$Bhavan'";
			$col="update dosh_credentials set accom_collect=accom_collect-$Cost WHERE team_id=$team_id";
			if(mysqli_query($con,$rquery)&&mysqli_query($con,$col))
			{
				echo "You Have to Return Rs. ".$row['Cost'];
			}
			else
			{
				echo "Cancellation Failed.Try Again.";
			}
		}
		else
		{
			echo "Cancellation Failed.Try Again.";
		}
	}
	else
	{
		echo "He/She Can't cancel their Accomodation after 2 hrs.Apply for early refund tomorrow.";
	}	
?>