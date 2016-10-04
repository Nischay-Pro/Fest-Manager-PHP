<?php
session_start();
include("functions/functions.php");
include("dynamic.php");
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

			$query="Select dayofyear(curdate())-dayofyear(startdate) as chk,curdate() as NewEndDate, EndDate, StartDate from accomodation where Pearl_Id='$Id' AND deleted='0'";
			$result=mysqli_query($con,$query);
			$change=$nnod-$onod;
			//print_r($change);
			$squery="Select * from accomodation A,users U where A.Pearl_Id=U.Pearl_Id and A.Pearl_Id='$Id' and U.accom=1";
			$result=mysqli_query($con,$squery);
			$count=mysqli_num_rows($result);
			$squery1="Select * from accomodation where Pearl_Id='$Id' and Refund=0 AND deleted='0'";
			$result1=mysqli_query($con,$squery1);
			$squery2="Select * from accomodation where Pearl_Id='$Id' and Refund=1 AND deleted='0'";
			$result2=mysqli_query($con,$squery2);
			$row=mysqli_fetch_assoc($result);
			if(mysqli_num_rows($result1)> 0)
			{
				if($row['chk']==$onod)//Comes On Time as per original Refund day.
				{
					echo "!Today is his day of Refund.Use 'Refund' Button";
				}
				else if ($row['chk']>$onod) //comes later than original Refund too and increase stay
				{
						echo "!He/She has overstayed.Use 'Refund' Button.";
				}
				else 
				{
					if($count>0)
					{
						$payable=0;
						$string="Collect Rs. 0 (Free Accom).";
					}
					else
					{	
						//$payable=($nnod-$onod)*150; 
						$payable = accomCost($nnod) - accomCost($onod);
						//print_r($row['StartDate']." ".$row['EndDate']);
						$string="Collect Rs.".$payable;
					}
					$query="Update accomodation set Cost=Cost+$payable,enddate= DATE_ADD(enddate,INTERVAL $change DAY),noofdays=$nnod, extensionID=$team_id where Pearl_Id='$Id'";
					$col="update dosh_credentials set accom_collect=accom_collect+$payable WHERE team_id=$team_id";
					//$changetime="update accomodation set Updated_At = DATE_ADD(Updated_At,INTERVAL 6 HOUR) where Pearl_Id='$Id' AND deleted!='1'";
					if(mysqli_query($con,$query)&&mysqli_query($con,$col))
					{
						//print_r($query);
							echo $string;
						//	print_r($row['StartDate']." ".$row['EndDate']);
					}

					else
					{
						echo "*Update Failed";
					}
				}
			}
			else if(mysqli_num_rows($result2)> 0)
			{
				if($count>0)
				{
					$payable=100;
					$msg="(Already Refunded Once).Collect Rs. 100.(Free Accom)";
				}
				else
				{
					//$payable=($nnod-$onod)*150+150;
					$payable = accomCost($nnod) - accomCost($onod) + 100;
					$msg="(Already Refunded Once).Collect Rs. ".$payable;
				}
				$query="Update accomodation set Cost=Cost+$payable,enddate= DATE_ADD(enddate,INTERVAL $change DAY),noofdays=$nnod,Refund=0, refunderID2= $team_id where Pearl_Id='$Id'";
				$col="update dosh_credentials set accom_collect=accom_collect-$payable WHERE team_id=$team_id";
				//$changetime="update accomodation set Updated_At = DATE_ADD(Updated_At,INTERVAL 6 HOUR) where Pearl_Id='$Id' AND deleted!='1'";
				if(mysqli_query($con,$query)&&mysqli_query($con,$col))
				{
					$rquery="update rooms,accomodation set seats_left=seats_left-1 where rooms.floor_id=accomodation.Bhavan and Pearl_Id='$Id'";
					$changetime="update accomodation set Updated_At = DATE_ADD(Updated_At,INTERVAL 6 HOUR) where Pearl_Id='$Id' AND deleted!='1'";
					if(mysqli_query($con,$rquery))
					{
						echo $msg;
					}
					else
					{
						$uquery="Update accomodation set Cost=Cost-$payable,noofdays=$onod,enddate= DATE_SUB(enddate,INTERVAL $change DAY),Refund=1 where Pearl_Id='$Id'";
						$col="update dosh_credentials set accom_collect=accom_collect-$payable WHERE team_id=$team_id";
						$changetime="update accomodation set Updated_At = DATE_ADD(Updated_At,INTERVAL 6 HOUR) where Pearl_Id='$Id' AND deleted!='1'";
						mysqli_query($con,$uquery);
						
						echo "*Update Failed";
					}
				}
				else
				{
					echo "*Update Failed";
				}
			}
		}
		else if($onod>$nnod)//Refund Early
		{
			$query="Select dayofyear(curdate())-dayofyear(startdate) as chk,curdate() as NewEndDate from accomodation where Pearl_Id='$Id' AND deleted='0'";
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
				$squery1="Select * from accomodation where Pearl_Id='$Id' and Refund=0 AND deleted='0'";
				$result1=mysqli_query($con,$squery1);
				if(mysqli_num_rows($result1)> 0)
				{
					$change=$onod-$nnod;
					$costChange = accomCost($onod) - accomCost($nnod);

					$squery="Select * from accomodation A,users U where A.Pearl_Id=U.Pearl_Id and A.Pearl_Id='$Id' and U.accom=1 AND A.deleted='0'";
					$result=mysqli_query($con,$squery);
					$count=mysqli_num_rows($result);
					if($count)
						$Refund=100;
					else{
						//$Refund=$change*150+150;
						$Refund = $costChange + 100;
					}
					$query="Update accomodation set Cost=Cost-$Refund,enddate= DATE_SUB(enddate,INTERVAL $change DAY),Refund=1,noofdays=$nnod, refunderID=$team_id where Pearl_Id='$Id'";
					$col="update dosh_credentials set accom_collect=accom_collect-$Refund WHERE team_id=$team_id";
					$changetime="update accomodation set Updated_At = DATE_ADD(Updated_At,INTERVAL 6 HOUR) where Pearl_Id='$Id' AND deleted!='1'";
					if(mysqli_query($con,$query)&&mysqli_query($con,$col))
					{
						$rquery="update rooms,accomodation set seats_left=seats_left+1 where rooms.floor_id=accomodation.Bhavan and Pearl_Id='$Id'";
						$changetime="update accomodation set Updated_At = DATE_ADD(Updated_At,INTERVAL 6 HOUR) where Pearl_Id='$Id' AND deleted!='1'";
						if(mysqli_query($con,$rquery))
						{
							echo "Refund Rs. ".$Refund;

						}
						else
						{
							$uquery="Update accomodation set Cost=Cost+$Refund,Refund="+0+",enddate= DATE_ADD(enddate,INTERVAL $change DAY),noofdays=$onod where Pearl_Id='$Id'";
							$ucol="update dosh_credentials set accom_collect=accom_collect+$Refund WHERE team_id=$team_id";
							//$changetime="update accomodation set Updated_At = DATE_ADD(Updated_At,INTERVAL 6 HOUR) where Pearl_Id='$Id' AND deleted!='1'";
							mysqli_query($con,$uquery);

							mysqli_query($con,$ucol);
							//mysqli_query($con,$changetime);
							echo "!Refund Failed";
						}
					}
					else
					{
						echo "!Refund Failed";
					}
				}
			}
			else if($row['chk']>$nnod)//comes after time for early Refund but before original Refund.
			{	
				echo "#Stayed for ".$row['chk']." days.Enter new no. of Days as ".$row['chk'].".";
			}
			else if($row['chk']<$nnod)//comes before time
			{
				echo "#Stayed for ".$row['chk']." days only.Enter new no. of days as ".$row['chk']."."	;
			}
		}
	}
	else
	{
		echo '!Cant Connect to Database.Check Your Internet Connection.';
	}
}	
	else if(isset($_POST['pearlid']))
{
	$Id=mysqli_real_escape_string($con,$_POST['pearlid']);
	$changetime="update accomodation set Updated_At = DATE_ADD(Updated_At,INTERVAL 6 HOUR) where Pearl_Id='$Id' AND deleted!='1'";
	if($con)
	{
		$query="Select dayofyear(curdate())-dayofyear(enddate) as chk from accomodation where Pearl_Id='$Id' AND deleted='0'";
		$query2="Select dayofyear(enddate)-dayofyear(startdate) as supday from accomodation where Pearl_Id='$Id' AND deleted='0'";
		$query3="Select dayofyear(curdate())-dayofyear(startdate) as actday from accomodation where Pearl_Id='$Id' AND deleted='0'";
		$result=mysqli_query($con,$query);
		$row=mysqli_fetch_assoc($result);
		$supresult=mysqli_query($con,$query2);
		$suprow=mysqli_fetch_assoc($supresult);
		$actresult=mysqli_query($con,$query3);
		$actrow=mysqli_fetch_assoc($actresult);
		if($row['chk']==0)//Comes on Correct Day 
		{
			$squery="Select * from accomodation where Pearl_Id='$Id' and Refund=0 AND deleted='0'";
			$result=mysqli_query($con,$squery);
			if(mysqli_num_rows($result)> 0)
			{
				$query="Update accomodation set Cost=Cost-100,Refund=1 , refunderID=$team_id where Pearl_Id='$Id'";//Ask to dec cost or not
				$col="update dosh_credentials set accom_collect=accom_collect-100 WHERE team_id=$team_id";

				if(mysqli_query($con,$query))
				{
					$rquery="update rooms,accomodation set seats_left=seats_left+1 where rooms.floor_id=accomodation.Bhavan and Pearl_Id='$Id'";
					if(mysqli_query($con,$rquery)&&mysqli_query($con,$col))
					{
						echo "Refund Rs.100.";//Pls Collect his booklet.";
					}
					else
					{
						$uquery="Update accomodation set Cost=Cost+100,Refund="+0+" where Pearl_Id='$Id'";
						$ucol="update dosh_credentials set accom_collect=accom_collect+100 WHERE team_id=$team_id";
						mysqli_query($con,$uquery);
						mysqli_query($con,$ucol);
						//mysqli_query($con,$changetime);
						echo "!Refund Failed";
					}
				}
				else
				{
					echo "!Refund Failed";
				}
			}
			else
			{	
				echo "Already Refunded.";
			}
		}
		else if($row['chk']<0)//Comes Early 
		{
			echo 'Use "Refund Early" Button';
		}
		else//Comes Late.OverStayed
		{
			$change=$row['chk'];
			$squery="Select * from accomodation where Pearl_Id='$Id' and Refund=0 AND deleted='0'";
			$result=mysqli_query($con,$squery);
			if(mysqli_num_rows($result)> 0)
			{
				$squery="Select * from accomodation A,users U where A.Pearl_Id=U.Pearl_Id and A.Pearl_Id='$Id' and U.accom=1 AND A.deleted='0'";
				$result=mysqli_query($con,$squery);
				$count=mysqli_num_rows($result);
				if($count>0)
				{
					$strng="(Free Accom)Refund Rs.100";
					$query="Update accomodation set Cost=Cost-100,enddate= DATE_ADD(enddate,INTERVAL $change DAY),Refund=1,noofdays=noofdays+$change , refunderID=$team_id where Pearl_Id='$Id'";
					$col="update dosh_credentials set accom_collect=accom_collect-100 WHERE team_id=$team_id";
					$uquery="Update accomodation set Cost=Cost+100,enddate= DATE_SUB(enddate,INTERVAL $change DAY),Refund=0,noofdays=noofdays-$change where Pearl_Id='$Id'";
					$ucol="update dosh_credentials set accom_collect=accom_collect+100 WHERE team_id=$team_id";
				}
				else
				{	$query2="Select dayofyear(enddate)-dayofyear(startdate) as supday from accomodation where Pearl_Id='$Id' AND deleted='0'";
		$query3="Select dayofyear(curdate())-dayofyear(startdate) as actday from accomodation where Pearl_Id='$Id' AND deleted='0'";
		$supresult=mysqli_query($con,$query2);
		$suprow=mysqli_fetch_assoc($supresult);
		$actresult=mysqli_query($con,$query3);
		$actrow=mysqli_fetch_assoc($actresult);


					//$Cost=$row['chk']*150-150;
					$Cost = accomCost($actrow['actday']) - accomCost($suprow['supday']) -100;
					//if($change==1)
					//	$strng="Stayed ".$row['chk']." Extra Day. ZERO Refund.";//.$Cost." Extra from him/her.";//Make sure they leave the hostel.";
					//else
						$strng="Stayed for ".$row['chk']." Extra Days.Collect Rs. ".$Cost;//Make sure they leave the hostel.";
					$query="Update accomodation set Cost=Cost+$Cost,enddate= DATE_ADD(enddate,INTERVAL $change DAY),Refund=1, refunderID=$team_id , noofdays=noofdays+$change where Pearl_Id='$Id'";
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
						//mysqli_query($con,$changetime);
						echo "!Refund Failed";
					}
				}
				else
				{
					echo "!Refund Failed";
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