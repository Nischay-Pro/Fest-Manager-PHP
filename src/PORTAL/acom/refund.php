<?php
session_start();
include("functions/functions.php");
$team_id=$_SESSION['team_id'];
if(isset($_POST['newnoofdays'])&&isset($_POST['oldnoofdays']))
{
	$Id=mysqli_real_escape_string($con,$_POST['pearlid']);
	$onod=mysqli_real_escape_string($con,$_POST['oldnoofdays']);
	$nnod=mysqli_real_escape_string($con,$_POST['newnoofdays']);
	if($con)
	{
		if($onod<$nnod)//Increase Stay
		{
			$query="Select dayofyear(curdate())-dayofyear(startdate) as chk,curdate() as NewEndDate from accomodation where Pearl_Id='$Id'";
			$result=mysqli_query($con,$query);
			$change=$nnod-$onod;
			$squery="Select * from accomodation A,users U where A.Pearl_Id=U.Pearl_Id and A.Pearl_Id='$Id' and U.accom=1";
			$result=mysqli_query($con,$squery);
			$count=mysqli_num_rows($result);
			$squery1="Select * from accomodation where Pearl_Id='$Id' and Refund=0";
			$result1=mysqli_query($con,$squery1);
			$squery2="Select * from accomodation where Pearl_Id='$Id' and Refund=1";
			$result2=mysqli_query($con,$squery2);
			$row=mysqli_fetch_assoc($result);
			if(mysqli_num_rows($result1)> 0)
			{
				if($row['chk']==$onod)//Comes On Time as per original Refund day.
				{
					echo "!Today is his day of Refund.Use 'Refund' Button";
				}
				else if ($row['chk']>$onod) //comes later than original Refund too and claiming early Refund.
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
					$query="Update accomodation set Cost=Cost+$payable,enddate= DATE_ADD(enddate,INTERVAL $change DAY),noofdays=$nnod where Pearl_Id='$Id'";
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
				$query="Update accomodation set Cost=Cost+$payable,enddate= DATE_ADD(enddate,INTERVAL $change DAY),noofdays=$nnod,Refund=0 where Pearl_Id='$Id'";
				$col="update dosh_credentials set accom_collect=accom_collect-$payable WHERE team_id=$team_id";
				if(mysqli_query($con,$query)&&mysqli_query($con,$col))
				{
					$rquery="update rooms,accomodation set seats_left=seats_left-1 where rooms.floor_id=accomodation.Bhavan and Pearl_Id='$Id'";
					if(mysqli_query($con,$rquery))
					{
						echo "(Already Refunded Once).You have to Collect Rs. ".$payable;
					}
					else
					{
						$uquery="Update accomodation set Cost=Cost-$payable,noofdays=$onod,enddate= DATE_SUB(enddate,INTERVAL $change DAY),Refund=1 where Pearl_Id='$Id'";
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
			$query="Select dayofyear(curdate())-dayofyear(startdate) as chk,curdate() as NewEndDate from accomodation where Pearl_Id='$Id'";
			$result=mysqli_query($con,$query);
			$row=mysqli_fetch_assoc($result);
			if($row['chk']==$onod)//Comes On Time as per original Refund day.
			{
				echo "!Today is his day of Refund.Use 'Refund' Button";
			}
			else if ($row['chk']>$onod) //comes later than original Refund too and claiming early Refund.
			{
					echo "!He/She has overstayed.Use 'Refund' Button.";
			}	
			else if($nnod==$row['chk'])//comes on time for early Refund.
			{	
				$squery1="Select * from accomodation where Pearl_Id='$Id' and Refund=0";
				$result1=mysqli_query($con,$squery1);
				if(mysqli_num_rows($result1)> 0)
				{
					$change=$onod-$nnod;
					$squery="Select * from accomodation A,users U where A.Pearl_Id=U.Pearl_Id and A.Pearl_Id='$Id' and U.accom=1";
					$result=mysqli_query($con,$squery);
					$count=mysqli_num_rows($result);
					if($count)
						$Refund=150;
					else
						$Refund=$change*150+150;
					$query="Update accomodation set Cost=Cost-$Refund,enddate= DATE_SUB(enddate,INTERVAL $change DAY),Refund=1,noofdays=$nnod where Pearl_Id='$Id'";
					$col="update dosh_credentials set accom_collect=accom_collect-$Refund WHERE team_id=$team_id";
					if(mysqli_query($con,$query)&&mysqli_query($con,$col))
					{
						$rquery="update rooms,accomodation set seats_left=seats_left+1 where rooms.floor_id=accomodation.Bhavan and Pearl_Id='$Id'";
						if(mysqli_query($con,$rquery))
						{
							echo "You have to Refund Rs. ".$Refund;
						}
						else
						{
							$uquery="Update accomodation set Cost=Cost+$Refund,Refund="+0+",enddate= DATE_ADD(enddate,INTERVAL $change DAY),noofdays=$onod where Pearl_Id='$Id'";
							$ucol="update dosh_credentials set accom_collect=accom_collect+$Refund WHERE team_id=$team_id";
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
			else if($row['chk']>$nnod)//comes after time for early Refund but before original Refund.
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
		$query="Select dayofyear(curdate())-dayofyear(enddate) as chk from accomodation where Pearl_Id='$Id'";
		$result=mysqli_query($con,$query);
		$row=mysqli_fetch_assoc($result);
		if($row['chk']==0)//Comes on Correct Day
		{
			$squery="Select * from accomodation where Pearl_Id='$Id' and Refund=0";
			$result=mysqli_query($con,$squery);
			if(mysqli_num_rows($result)> 0)
			{
				$query="Update accomodation set Cost=Cost-150,Refund=1 where Pearl_Id='$Id'";//Ask to dec cost or not
				$col="update dosh_credentials set accom_collect=accom_collect-150 WHERE team_id=$team_id";
				if(mysqli_query($con,$query))
				{
					$rquery="update rooms,accomodation set seats_left=seats_left+1 where rooms.floor_id=accomodation.Bhavan and Pearl_Id='$Id'";
					if(mysqli_query($con,$rquery)&&mysqli_query($con,$col))
					{
						echo "Today was his last day of stay.You have to Refund Rs.150.";//Pls Collect his booklet.";
					}
					else
					{
						$uquery="Update accomodation set Cost=Cost+150,Refund="+0+" where Pearl_Id='$Id'";
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
			$squery="Select * from accomodation where Pearl_Id='$Id' and Refund=0";
			$result=mysqli_query($con,$squery);
			if(mysqli_num_rows($result)> 0)
			{
				$squery="Select * from accomodation A,users U where A.Pearl_Id=U.Pearl_Id and A.Pearl_Id='$Id' and U.accom=1";
				$result=mysqli_query($con,$squery);
				$count=mysqli_num_rows($result);
				if($count>0)
				{
					$strng="You have to Refund Rs.150";
					$query="Update accomodation set Cost=Cost-150,enddate= DATE_ADD(enddate,INTERVAL $change DAY),Refund=1,noofdays=noofdays+$change where Pearl_Id='$Id'";
					$col="update dosh_credentials set accom_collect=accom_collect-150 WHERE team_id=$team_id";
					$uquery="Update accomodation set Cost=Cost+150,enddate= DATE_SUB(enddate,INTERVAL $change DAY),Refund=0,noofdays=noofdays-$change where Pearl_Id='$Id'";
					$ucol="update dosh_credentials set accom_collect=accom_collect+150 WHERE team_id=$team_id";
				}
				else
				{	
					$Cost=$row['chk']*150-150;
					if($change==1)
						$strng="He/She has stayed for ".$row['chk']." Extra Day.He will not get no Refund.";//.$Cost." Extra from him/her.";//Make sure they leave the hostel.";
					else
						$strng="He/She has stayed for ".$row['chk']." Extra Days.Collect Rs. ".$Cost." Extra from him/her.";//Make sure they leave the hostel.";
					$query="Update accomodation set Cost=Cost+$Cost,enddate= DATE_ADD(enddate,INTERVAL $change DAY),Refund=1,noofdays=noofdays+$change where Pearl_Id='$Id'";
					$col="update dosh_credentials set accom_collect=accom_collect+$Cost WHERE team_id=$team_id";
					$uquery="Update accomodation set Cost=Cost-$Cost,enddate= DATE_SUB(enddate,INTERVAL $change DAY),Refund=0,noofdays=noofdays-$change where Pearl_Id='$Id'";
					$ucol="update dosh_credentials set accom_collect=accom_collect-$Cost WHERE team_id=$team_id";
				}
				if(mysqli_query($con,$query))
				{
					$rquery="update rooms,accomodation set seats_left=seats_left+1 where rooms.floor_id=accomodation.Bhavan and Pearl_Id='$Id'";
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