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
			$query="Select dayofyear(curdate())-dayofyear(startdate) as chk,curdate() as NewEndDate from accomodation where Pearl_Id='$Id' AND deleted='0'";
			$result=mysqli_query($con,$query);
			$change=$nnod-$onod;
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
					//echo "!Today is his day of Refund.Use 'Refund' Button";
					echo "Are you sure you want to take your refund today? It is the correct day.";

				}
				else if ($row['chk']>$onod) //comes later than original Refund too and increase stay
				{
						echo "!He/She has overstayed by {$row['chk']} days.Use 'Refund' Button.";
				}
				else 
				{
					if($count>0)
					{
						$payable=0;
						//$string="Collect Rs. 0 (Free Accom).";
						$string = "You have been provided free Accom.";
					}
					else
					{	
						//$payable=($nnod-$onod)*150; 
						//$payable = accomCost($nnod) - accomCost($onod);
						//$string="Collect Rs.".$payable;
						$string = "Are you sure you want to increase your stay by {$change} day(s)?";
					}
				
					
							echo $string;
					
					
				}
			}
			else if(mysqli_num_rows($result2)> 0)
			{
				if($count>0)
				{
					//$payable=100;
					//$msg="(Already Refunded Once).Collect Rs. 100.(Free Accom)";
					$msg ="You have already Collected your refund once.";
				}
				else
				{
					//$payable=($nnod-$onod)*150+150;
					//$payable = accomCost($nnod) - accomCost($onod) + 100;
					//$msg="(Already Refunded Once).Collect Rs. ".$payable;
					$msg ="You have already Collected your refund once.";
				}
				
						echo $msg;
					
			
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
					echo "!He/She has overstayed by {$row['chk']} days.Use 'Refund' Button.";
			}	
			else if($nnod==$row['chk'])//comes on time for early Refund.
			{	
				$squery1="Select * from accomodation where Pearl_Id='$Id' and Refund=0 AND deleted='0'";
				$result1=mysqli_query($con,$squery1);
				if(mysqli_num_rows($result1)> 0)
				{
					//$change=$onod-$nnod;
					//$change = accomCost($onod) - accomCost($nnod);

					$squery="Select * from accomodation A,users U where A.Pearl_Id=U.Pearl_Id and A.Pearl_Id='$Id' and U.accom=1 AND A.deleted='0'";
					$result=mysqli_query($con,$squery);
					$count=mysqli_num_rows($result);
					if($count)
						//$Refund=100;
						$Refund = "Only your security Deposit needs to be returned";
					else
						//$Refund=$change*150+150;
						//$Refund = $change + 100;
						$Refund = "Are you sure you want to change from {$onod} to {$nnod} days?";
					//$query="Update accomodation set Cost=Cost-$Refund,enddate= DATE_SUB(enddate,INTERVAL $change DAY),Refund=1,noofdays=$nnod, refunderID=$team_id where Pearl_Id='$Id'";
					//$col="update dosh_credentials set accom_collect=accom_collect-$Refund WHERE team_id=$team_id";
			
						
							echo $Refund;
						
						
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
				
					
						//echo "Refund Rs.100.";//Pls Collect his booklet.";
						echo "Are you sure you want to refund? (On time)";
					
			}
			else
			{	
				//echo "Already Refunded.";
				echo "You have already collected your refund.";
			}
		}
		else if($row['chk']<0)//Comes Early 
		{
			echo 'Are you sure you want to collect your refund before scheduled date?';
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
					//$strng="(Free Accom)Refund Rs.100";
					$strng ="You have been provided free accom?";
									}
				else
				{	$query2="Select dayofyear(enddate)-dayofyear(startdate) as supday from accomodation where Pearl_Id='$Id' AND deleted='0'";
		$query3="Select dayofyear(curdate())-dayofyear(startdate) as actday from accomodation where Pearl_Id='$Id' AND deleted='0'";
		$supresult=mysqli_query($con,$query2);
		$suprow=mysqli_fetch_assoc($supresult);
		$actresult=mysqli_query($con,$query3);
		$actrow=mysqli_fetch_assoc($actresult);


					//$Cost=$row['chk']*150-150;
					//$Cost = accomCost($actrow['actday']) - accomCost($suprow['supday']) -100;
					//if($change==1)
					//	$strng="Stayed ".$row['chk']." Extra Day. ZERO Refund.";//.$Cost." Extra from him/her.";//Make sure they leave the hostel.";
					//else
						$strng="Stayed for ".$row['chk']." Extra Days.";//Make sure they leave the hostel.";
				
				}
				
					
						echo $strng;
				
				
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