<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST'); 
	include("connection.php");
	$Id=mysqli_real_escape_string($con,$_POST['pearlid']);
	$query="Select Updated_At,Bhavan,Cost from accomodation where Pearl_ID='$Id'";
	$result=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($result);
	date_default_timezone_set('Asia/Kolkata');
	$curtime=strtotime(date("m/d/Y G:i:s",time()));
	$updatedat=strtotime($row['Updated_At']);
	$Bhavan=$row['Bhavan'];
	$Cost=$row['Cost'];
	$gap=$curtime-$updatedat;
	//echo date("m/d/Y G:i:s",time()).$row['Updated_At'].$gap;
	if($gap<7200)
	{
		$dquery="Delete From accomodation where Pearl_Id='$Id'";
		if(mysqli_query($con,$dquery))
		{
			$rquery="update rooms set seats_left=seats_left+1 where floor_id='$Bhavan'";
			$col="update dosh_credentials set accom_collect=accom_collect-$Cost WHERE team_id=$team_id";
			if(mysqli_query($con,$rquery)&&mysqli_query($con,$col))
			{
				echo "Accomodation has been Cancelled Successfully.You Have to Return Rs. ".$row['Cost'];
			}
			else
			{
				echo "Refund Failed";
			}
		}
		else
		{
			echo "Cancellation Failed.Try Again.";
		}
	}
	else
	{
		echo "You Can't cancel your Accomodation after 2 hrs.Apply for early refund tomorrow.";
	}	
?>