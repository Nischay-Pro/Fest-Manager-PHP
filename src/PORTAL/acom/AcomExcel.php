<?php
// output headers so that the file is downloaded rather than displayed
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="accomodated.csv"');
 
// do not cache the file
header('Pragma: no-cache');
header('Expires: 0');
 
// create a file pointer connected to the output stream
$file = fopen('php://output', 'w');
 
// send the column headers
include("../functions/functions.php");
fputcsv($file, array('Pearl Id', 'Name', 'Email', 'College', 'Phone','StartDate','EndDate','Bhavan','NoofDays','Cost','Refund','Canceled'));
 
// Sample data. This can be fetched from mysql too
$query=mysqli_query($con,"SELECT * FROM `accomodation` NATURAL JOIN users");
$data=array();
$count=0;
while($result=mysqli_fetch_array($query)){
	$data[$count]['Pearl_Id']=$result['Pearl_Id'];
	$data[$count]['Name']=$result['name'];
	$data[$count]['Email']=$result['email'];
	$data[$count]['College']=$result['college'];
	$data[$count]['Phone']=$result['phone'];
	$data[$count]['StartDate']=$result['StartDate'];
	$data[$count]['EndDate']=$result['EndDate'];
	$data[$count]['Bhavan']=$result['Bhavan'];
	$data[$count]['NoofDays']=$result['NoofDays'];
	$data[$count]['Cost']=$result['Cost'];
	$data[$count]['Refund']=$result['Refund']*150;	
	$data[$count]['Canceled']=$result['deleted'];	
	$count++;
}
 
// output each row of the data
foreach ($data as $row)
{
    fputcsv($file, $row);
}
 
exit();
?>
?>