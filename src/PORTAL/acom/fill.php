<?php
include("functions/functions.php");
if(isset($_POST['pearlid']))
{
	$ans=array();
	$Id=mysqli_real_escape_string($con,$_POST['pearlid']);
	$query="Select Updated_At,Bhavan,Cost from accomodation where Pearl_ID='$Id'";
	$result=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($result);
	date_default_timezone_set('Asia/Kolkata');
	$curtime=strtotime(date("m/d/Y G:i:s",time()));
	$updatedat=strtotime($row['Updated_At']);
	$gap=$curtime-$updatedat;
	if($con)
	{
		$query="Select DATE_FORMAT(StartDate,'%D %M') as StartDate,DATE_FORMAT(EndDate,'%D %M') as EndDate,NoofDays from accomodation where Pearl_Id='$Id'";
		$result=mysqli_query($con,$query);
		if(mysqli_num_rows($result)>0)
		{	
			$row=mysqli_fetch_assoc($result);
			$ans[0]=$row['StartDate'];
			$ans[1]=$row['EndDate'];
			$ans[2]=$row['NoofDays'];
			$ans[3]=$gap;
			echo json_encode($ans);
		}
		else
		{	
			$ans[0]=-1;
			echo json_encode($ans);
		}
	}
	else
	{
		echo 'Cant Connect to Database.Check Your Internet Connection.';
	}
}
?>