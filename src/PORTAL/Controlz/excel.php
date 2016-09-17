<?php
// output headers so that the file is downloaded rather than displayed
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="eventparticipants.csv"');
 
// do not cache the file
header('Pragma: no-cache');
header('Expires: 0');
 
// create a file pointer connected to the output stream
$file = fopen('php://output', 'w');
 
// send the column headers
include("../functions/functions.php");
fputcsv($file, array('Pearl Id', 'Name', 'EMail', 'College', 'Phone','Registration','Accomodation','Uploaded By'));
 
// Sample data. This can be fetched from mysql too
$query=mysqli_query($con,"SELECT * FROM users as u where u.pearl_id IN (SELECT ep.pearl_id FROM event_participants as ep) OR u.pearl_id IN (SELECT gm.pearl_id FROM group_members as gm)");
$data=array();
$count=0;	
while($result=mysqli_fetch_array($query)){
	$data[$count]['pearl_id']=$result['pearl_id'];
	$data[$count]['name']=$result['name'];
	$data[$count]['email']=$result['email'];
	$data[$count]['college']=$result['college'];
	$data[$count]['phone']=$result['phone'];
	$data[$count]['reg']=$result['reg'];
	$data[$count]['accom']=$result['accom'];
	$data[$count]['id_reg']=$result['id_reg'];
	$count++;
}
 
// output each row of the data
foreach ($data as $row)
{
    fputcsv($file, $row);
}
 
exit();
?>