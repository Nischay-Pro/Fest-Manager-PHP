<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 
include("connection.php");
if(isset($_POST['newnoofdays'])&&isset($_POST['oldnoofdays']))
{
	$Id=mysqli_real_escape_string($con,$_POST['pearlid']);
	$onod=mysqli_real_escape_string($con,$_POST['oldnoofdays']);
	$nnod=mysqli_real_escape_string($con,$_POST['newnoofdays']);
	if($con)
	{
		if($onod<$nnod)//Increase Stay
		{
			$query="Select dayofyear(curdate())-dayofyear(startdate) as chk,curdate() as NewEndDate from Accomodation where Pearl_Id='$Id'";
			$result=mysqli_query($con,$query);
			$change=$nnod-$onod;
			$squery="Select * from Accomodation A,Users U where A.Pearl_Id=U.Pearl_Id and A.Pearl_Id='$Id' and U.accom=1";
			$result=mysqli_query($con,$squery);
			$count=mysqli_num_rows($result);
			$squery1="Select * from Accomodation where Pearl_Id='$Id' and refund=0";
			$result1=mysqli_query($con,$squery1);
			$squery2="Select * from Accomodation where Pearl_Id='$Id' and refund=1";
			$result2=mysqli_query($con,$squery2);
			$row=mysqli_fetch_assoc($result);
			if(mysqli_num_rows($result1)> 0)
			{
				if($row['chk']==$onod)//Comes On Time as per original refund day.
				{
					echo "!Today is his day of refund.Use 'Refund' Button";
				}
				else if ($row['chk']>$onod) //comes later than original refund too and claiming early refund.
				{
						echo "!He/She has overstayed.Use 'Refund' Button.";
				}
				else 
				{
					if($count>0)
					{
						$payable=0;
						$string="You do not have to collect any money(Free Accom).";
					}
					else
					{	
						$payable=($nnod-$onod)*150;
						$string="You have to Collect Rs.".$payable;
					}
					$query="Update Accomodation set Cost=Cost+$payable,enddate= DATE_ADD(enddate,INTERVAL $change DAY),noofdays=$nnod where Pearl_Id='$Id'";
					$col="update dosh_credentials set accom_collect=accom_collect+$payable WHERE team_id=$team_id";
					if(mysqli_query($con,$query)&&mysqli_query($con,$col))
					{
							echo $string;
					}
					else
					{
						echo "Update Failed";
					}
				}
			}
			else if(mysqli_num_rows($result2)> 0)
			{
				if($count>0)
					$payable=150;
				else
					$payable=($nnod-$onod)*150+150;;
				$query="Update Accomodation set Cost=Cost+$payable,enddate= DATE_ADD(enddate,INTERVAL $change DAY),noofdays=$nnod,refund=0 where Pearl_Id='$Id'";
				$col="update dosh_credentials set accom_collect=accom_collect-$payable WHERE team_id=$team_id";
				if(mysqli_query($con,$query)&&mysqli_query($con,$col))
				{
					$rquery="update rooms,Accomodation set seats_left=seats_left-1 where rooms.floor_id=Accomodation.Bhavan and Pearl_Id='$Id'";
					if(mysqli_query($con,$rquery))
					{
						echo "(Already Refunded Once).You have to Collect Rs. ".$payable;
					}
					else
					{
						$uquery="Update Accomodation set Cost=Cost-$payable,noofdays=$onod,enddate= DATE_SUB(enddate,INTERVAL $change DAY),refund=1 where Pearl_Id='$Id'";
						$col="update dosh_credentials set accom_collect=accom_collect-$payable WHERE team_id=$team_id";
						mysqli_query($con,$uquery);
						echo "Update Failed";
					}
				}
				else
				{
					echo "Update Failed";
				}
			}
		}
		else if($onod>$nnod)//Refund Early
		{
			$query="Select dayofyear(curdate())-dayofyear(startdate) as chk,curdate() as NewEndDate from Accomodation where Pearl_Id='$Id'";
			$result=mysqli_query($con,$query);
			$row=mysqli_fetch_assoc($result);
			if($row['chk']==$onod)//Comes On Time as per original refund day.
			{
				echo "!Today is his day of refund.Use 'Refund' Button";
			}
			else if ($row['chk']>$onod) //comes later than original refund too and claiming early refund.
			{
					echo "!He/She has overstayed.Use 'Refund' Button.";
			}	
			else if($nnod==$row['chk'])//comes on time for early refund.
			{	
				$squery1="Select * from Accomodation where Pearl_Id='$Id' and refund=0";
				$result1=mysqli_query($con,$squery1);
				if(mysqli_num_rows($result1)> 0)
				{
					$change=$onod-$nnod;
					$squery="Select * from Accomodation A,Users U where A.Pearl_Id=U.Pearl_Id and A.Pearl_Id='$Id' and U.accom=1";
					$result=mysqli_query($con,$squery);
					$count=mysqli_num_rows($result);
					if($count)
						$refund=150;
					else
						$refund=$change*150+150;
					$query="Update Accomodation set Cost=Cost-$refund,enddate= DATE_SUB(enddate,INTERVAL $change DAY),refund=1,noofdays=$nnod where Pearl_Id='$Id'";
					$col="update dosh_credentials set accom_collect=accom_collect-$refund WHERE team_id=$team_id";
					if(mysqli_query($con,$query)&&mysqli_query($con,$col))
					{
						$rquery="update rooms,Accomodation set seats_left=seats_left+1 where rooms.floor_id=Accomodation.Bhavan and Pearl_Id='$Id'";
						if(mysqli_query($con,$rquery))
						{
							echo "You have to Refund Rs. ".$refund;
						}
						else
						{
							$uquery="Update Accomodation set Cost=Cost+$refund,refund="+0+",enddate= DATE_ADD(enddate,INTERVAL $change DAY),noofdays=$onod where Pearl_Id='$Id'";
							$ucol="update dosh_credentials set accom_collect=accom_collect+$refund WHERE team_id=$team_id";
							mysqli_query($con,$uquery);
							mysqli_query($con,$ucol);
							echo "Refund Failed";
						}
					}
					else
					{
						echo "Refund Failed";
					}
				}
			}
			else if($row['chk']>$nnod)//comes after time for early refund but before original refund.
			{	
				echo "#He has already stayed for ".$row['chk']." days already.Enter new no. of Days as ".$row['chk'].".";
			}
			else if($row['chk']<$nnod)//comes before time
			{
				echo "#He has stayed for ".$row['chk']." days only.Enter new no. of days as ".$row['chk']."."	;
			}
		}
	}
	else
	{
		echo 'Cant Connect to Database.Check Your Internet Connection.';
	}
}	
	else if(isset($_POST['pearlid']))
{
	$Id=mysqli_real_escape_string($con,$_POST['pearlid']);
	if($con)
	{
		$query="Select dayofyear(curdate())-dayofyear(enddate) as chk from Accomodation where Pearl_Id='$Id'";
		$result=mysqli_query($con,$query);
		$row=mysqli_fetch_assoc($result);
		if($row['chk']==0)//Comes on Correct Day
		{
			$squery="Select * from Accomodation where Pearl_Id='$Id' and refund=0";
			$result=mysqli_query($con,$squery);
			if(mysqli_num_rows($result)> 0)
			{
				$query="Update Accomodation set Cost=Cost-150,refund=1 where Pearl_Id='$Id'";//Ask to dec cost or not
				$col="update dosh_credentials set accom_collect=accom_collect-150 WHERE team_id=$team_id";
				if(mysqli_query($con,$query))
				{
					$rquery="update rooms,Accomodation set seats_left=seats_left+1 where rooms.floor_id=Accomodation.Bhavan and Pearl_Id='$Id'";
					if(mysqli_query($con,$rquery)&&mysqli_query($con,$col))
					{
						echo "Today was his last day of stay.You have to Refund Rs.150.";//Pls Collect his booklet.";
					}
					else
					{
						$uquery="Update Accomodation set Cost=Cost+150,refund="+0+" where Pearl_Id='$Id'";
						$ucol="update dosh_credentials set accom_collect=accom_collect+150 WHERE team_id=$team_id";
						mysqli_query($con,$uquery);
						mysqli_query($con,$ucol);
						echo "Refund Failed";
					}
				}
				else
				{
					echo "Refund Failed";
				}
			}
			else
			{	
				echo "Already Refunded.";
			}
		}
		else if($row['chk']<0)//Comes Early
		{
			echo "He/She wants to Refund Earlier than Original Amount Collected.Use 'Increase Stay or Refund Early' Button";
		}
		else//Comes Late.OverStayed
		{
			$change=$row['chk'];
			$squery="Select * from Accomodation where Pearl_Id='$Id' and refund=0";
			$result=mysqli_query($con,$squery);
			if(mysqli_num_rows($result)> 0)
			{
				$squery="Select * from Accomodation A,Users U where A.Pearl_Id=U.Pearl_Id and A.Pearl_Id='$Id' and U.accom=1";
				$result=mysqli_query($con,$squery);
				$count=mysqli_num_rows($result);
				if($count>0)
				{
					$strng="You have to refund Rs.150";
					$query="Update Accomodation set Cost=Cost-150,enddate= DATE_ADD(enddate,INTERVAL $change DAY),refund=1,noofdays=noofdays+$change where Pearl_Id='$Id'";
					$col="update dosh_credentials set accom_collect=accom_collect-150 WHERE team_id=$team_id";
					$uquery="Update Accomodation set Cost=Cost+150,enddate= DATE_SUB(enddate,INTERVAL $change DAY),refund=0,noofdays=noofdays-$change where Pearl_Id='$Id'";
					$ucol="update dosh_credentials set accom_collect=accom_collect+150 WHERE team_id=$team_id";
				}
				else
				{	
					$Cost=$row['chk']*150-150;
					if($change==1)
						$strng="He/She has stayed for ".$row['chk']." Extra Day.He will not get no refund.";//.$Cost." Extra from him/her.";//Make sure they leave the hostel.";
					else
						$strng="He/She has stayed for ".$row['chk']." Extra Days.Collect Rs. ".$Cost." Extra from him/her.";//Make sure they leave the hostel.";
					$query="Update Accomodation set Cost=Cost+$Cost,enddate= DATE_ADD(enddate,INTERVAL $change DAY),refund=1,noofdays=noofdays+$change where Pearl_Id='$Id'";
					$col="update dosh_credentials set accom_collect=accom_collect+$Cost WHERE team_id=$team_id";
					$uquery="Update Accomodation set Cost=Cost-$Cost,enddate= DATE_SUB(enddate,INTERVAL $change DAY),refund=0,noofdays=noofdays-$change where Pearl_Id='$Id'";
					$ucol="update dosh_credentials set accom_collect=accom_collect-$Cost WHERE team_id=$team_id";
				}
				if(mysqli_query($con,$query))
				{
					$rquery="update rooms,Accomodation set seats_left=seats_left+1 where rooms.floor_id=Accomodation.Bhavan and Pearl_Id='$Id'";
					if(mysqli_query($con,$rquery)&&mysqli_query($con,$col))
					{
						echo $strng;
					}
					else
					{
						mysqli_query($con,$uquery);
						mysqli_query($con,$ucol);
						echo "Refund Failed";
					}
				}
				else
				{
					echo "Refund Failed";
				}
			}	
			else
			{	
				echo "Already Refunded.";
			}
		}
	}
	else
	{
		echo 'Cant Connect to Database.Check Your Internet Connection.';
	}
}
?>