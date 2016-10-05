<?php
session_start();
$con=mysqli_connect("localhost","root","060848","atmos");
function getevents(){
	$con=mysqli_connect("localhost","root","060848","atmos");
$query=mysqli_query($con,"SELECT * FROM event_details NATURAL JOIN pearl_events");
$i=1;
while($result=mysqli_fetch_array($query)){
		$id=$result['id'];
		$Event_id = $result['Event_id'];
		$Event_date=$result['Event_date'];
		$Event_date= date('d-m-Y H:i:s', $Event_date);
		$Event_venue=$result['Event_venue'];
		$Roundname=$result['Roundname'];
		$Event_name=$result['event_name'];
		echo "<tr>
				<td>$i</td>
				<td ' id='EventName:$id'><a href='eventusers.php?event_id=$Event_id'>$Event_name</a></td>
				<td contenteditable='false' id='Roundname:$id'>$Roundname</td>
				<td contenteditable='false' id='Event_date:$id'>$Event_date</td>
				<td contenteditable='false' id='Event_venue:$id'>$Event_venue</td>
				</tr>";
				$i++;
		
	}
}
function getWorkshops(){
	$con=mysqli_connect("localhost","root","060848","atmos");
    $club = $_SESSION['controlz_id'];
$query=mysqli_query($con,"SELECT * FROM event_workshops WHERE `club`='$club' AND isdelete='0'");
$i=1;
while($result=mysqli_fetch_array($query)){
		$id=$result['id'];
		$Workshop_name=$result['name'];
		$Workshop_date=$result['time'];
        $Workshop_cost=$result['cost'];
		$Workshop_venue=$result['room'];
		echo "<tr id=\"$id\">
				<td>$i</td>
				<td ' id='EventName:$id'>$Workshop_name</td>
				<td contenteditable='false' id='datetimepicker'>$Workshop_date</td>
				<td contenteditable='false' id='Event_venue:$id'>$Workshop_cost</td>
        <td contenteditable='false' id='Event_cost:$id'>$Workshop_venue</td>
        <td class='danger' contenteditable='false' onclick='editMe(this)'' id='$id'>DELETE</td>
				</tr>";
				$i++;
		
	}

}

function getWorkshopsCRC(){
    $con=mysqli_connect("localhost","root","060848","atmos");
    $club = $_SESSION['crc_id'];
    $query=mysqli_query($con,"SELECT * FROM event_workshops WHERE `club`='$club' AND isdelete='0'");
    $i=1;
    while($result=mysqli_fetch_array($query)){
        $id=$result['id'];
        $Workshop_name=$result['name'];
        $Workshop_date=$result['time'];
        $Workshop_cost_general=$result['cost_general'];
        $Workshop_cost_bits=$result['cost_bits'];
        $Workshop_venue=$result['room'];
        echo "
				<td>$i</td>
				<td id='EventName:$id'><a href='workshopusers.php?id=$id'>$Workshop_name</a></td>
				<td contenteditable='false' id='datetimepicker'>$Workshop_date</td>
				<td contenteditable='false' id='Event_venue:$id'>$Workshop_cost_general</td>
				<td contenteditable='false' id='Event_venue:$id'>$Workshop_cost_bits</td>
        <td contenteditable='false' id='Event_cost:$id'>$Workshop_venue</td>
				</tr>";
        $i++;
    }

}
                        
function getIndiEvents(){
	$con=mysqli_connect("localhost","root","060848","atmos");
$query=mysqli_query($con,"SELECT * FROM pearl_events");
$i=1;
while($result=mysqli_fetch_array($query)){
		$event_id=$result['event_id'];
		$event_name=$result['event_name'];
		echo "<tr>
				<td>$i</td>
				<td class='events' id='event_name:$event_id'>$event_name</td>
				</tr>";
				$i++;
		
	}
}
function getWorkshopDropdown(){
	$con=mysqli_connect("localhost","root","060848","atmos");
    $club = $_SESSION['controlz_id'];
$query=mysqli_query($con,"SELECT * FROM event_workshops WHERE `isdelete`='0' AND `club` = '$club'");
$i=1;
  echo '<div class="form-group">
  <select class="form-control" id="sel1" name="workshopid">';
  while($result=mysqli_fetch_array($query)){
    $name=$result['name'];
    $event_id=$result['id'];
    echo '<option id="'.$event_id.'" value="'.$event_id.'">'.$name.'</option>';
  }
 echo '</select></div>';
}
function getUsers(){
	$con=mysqli_connect("localhost","root","060848","atmos");
    $club = $_SESSION['controlz_id'];
$query=mysqli_query($con,"SELECT userid,event_workshops.name,event_workshops_participants.id,event_workshops_participants.is_coupon FROM event_workshops_participants,event_workshops WHERE `isdelete`='0' AND event_workshops.id = event_workshops_participants.eventid AND event_workshops.club = '$club' AND event_workshops.isdelete=0 AND event_workshops_participants.is_delete=0");
$i=1;
  echo '<div class="form-group">
  <select class="form-control" id="sel1" name="workshopid">';
while($result=mysqli_fetch_array($query)){
		$id=$result['id'];
		$Event_userid=$result['userid'];
		$Event_name=$result['name'];
        $Event_coupon=$result['is_coupon'];
    if($Event_coupon=='1'){
        $Event_coupon='Applied Coupon';
    }
    else{
        $Event_coupon='Coupon Not Applied';
    }
		echo "<tr onclick=\"editMe(this)\" id=\"$id\">
				<td>$i</td>
        <td contenteditable='false' id='EventUserId:$Event_userid'>$Event_userid</td>
				<td ' id='EventName:$id'>$Event_name</td>
				<td contenteditable='false' id='Event_coupon:$id'>$Event_coupon</td>
                
				</tr>";

        //<td class='danger' contenteditable='false' onclick='editMe(this)'' id='$id'>DELETE</td>
				$i++;
		
	}
 echo '</select></div>';
}
function getEventDropdown(){
	$con=mysqli_connect("localhost","root","060848","atmos");
$query=mysqli_query($con,"SELECT * FROM pearl_events ORDER BY event_name ASC");
$i=1;
  echo '<div class="form-group">
  <input type="text" list="eventlist" class="form-control" id="sel1" name="Event_id"/>
  <datalist id="eventlist">';
  while($result=mysqli_fetch_array($query)){
    $name=$result['event_name'];
    $event_id=$result['event_id'];
    echo '<option id="'.$event_id.'" value="'.$event_id.'">'.$name.'</option>';
  }
 echo '</datalist></div>';
}
function getIndiParticipants(){
	$con=mysqli_connect("localhost","root","060848","atmos");
$query=mysqli_query($con,"SELECT * FROM users AS u,event_participants AS e,pearl_events AS p WHERE u.pearl_id=e.pearl_id AND e.event_id=p.event_id");
$i=1;
  
  while($result=mysqli_fetch_array($query)){
    $event_name=$result['event_name'];
    $phone=$result['phone'];
    $name=$result['name'];
    $round_at=$result['round_at']+1;
    echo '<tr>
    	<td>'.$i.'</td>
    	<td>'.$name.'</td>
    	<td>'.$phone.'</td>
    	<td>'.$event_name.'</td>
    	<td>'.$round_at.'</td>
    		</tr>';
    		$i++;
  }
}function getGroupParticipants(){
	$con=mysqli_connect("localhost","root","060848","atmos");
$query=mysqli_query($con,"SELECT * FROM users AS u,group_members AS gm,pearl_events AS p,group_details AS gd WHERE u.pearl_id=gm.pearl_id AND gm.event_id=p.event_id");
$i=1;
  
  while($result=mysqli_fetch_array($query)){
    $event_name=$result['event_name'];
    $phone=$result['phone'];
    $name=$result['name'];
    $round_at=$result['round_at']+1;
    echo '<tr>
    	<td>'.$i.'</td>
    	<td>'.$name.'</td>
    	<td>'.$phone.'</td>
    	<td>'.$event_name.'</td>
    	<td>'.$round_at.'</td>
    		</tr>';
    		$i++;
  }
}
function getReport(){
  $con=mysqli_connect("localhost","root","060848","atmos");
  $query="Select Pearl_Id,Name,phone,email,DATE_FORMAT(EndDate,'%D %M') as 'RefundDate' from accomodation Natural Join users where dayofyear(curdate())>=dayofyear(enddate) and refund=0";
$result=mysqli_query($con,$query);
  while($row=mysqli_fetch_assoc($result))
  {
    echo "<tr>";
    echo "<td>".$row['Pearl_Id']."</td>";
    echo "<td>".$row['Name']."</td>";
    echo "<td>".$row['phone']."</td>";
    echo "<td>".$row['email']."</td>";
    echo "<td class='text-left'>".$row['RefundDate']."</td>";
    echo "</tr>";
  }

}
function getRegisteredUsers(){
    $con=mysqli_connect("localhost","root","060848","atmos");
    $query="SELECT * FROM users";
    $result = mysqli_query($con,$query);
    $i = 1;
    while ($row=mysqli_fetch_assoc($result))
    {
        echo "<tr>";
        echo "<td>".$i."</td>";
        echo "<td>".$row['pearl_id']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['college']."</td>";
        echo "<td>".$row['phone']."</td>";
        echo "<td>".$row['updated_at']."</td>";
        echo "</tr>";
        $i = $i+1;
    }
}
function getAccoDetails(){
    $con=mysqli_connect("localhost","root","060848","atmos");
    $query="SELECT * FROM accomodation";
    $result = mysqli_query($con,$query);
    $i = 1;
    while ($row=mysqli_fetch_assoc($result))
    {
        echo "<tr>";
        echo "<td>".$i."</td>";
        echo "<td>".$row['Pearl_Id']."</td>";
        echo "<td>".$row['StartDate']."</td>";
        echo "<td>".$row['EndDate']."</td>";
        echo "<td>".$row['NoofDays']."</td>";
        echo "<td>".$row['Bhavan']."</td>";
        echo "<td>".$row['Cost']."</td>";
        echo "<td>".$row['Refund']."</td>";
        echo "<td>".$row['Updated_At']."</td>";
        echo "</tr>";
        $i=$i+1;
    }
}

function getEventParticipants($event_id)
{
    $con=mysqli_connect("localhost","root","060848","atmos");
    $query="SELECT * FROM event_participants WHERE event_id=$event_id";
    $result = mysqli_query($con,$query);
    $i=1;
    while ($row=mysqli_fetch_assoc($result))
    {
        echo "<tr>";
        echo "<td>".$i."</td>";
        echo "<td>".$row['pearl_id']."</td>";
        echo "<td>".$row['uploaded_by']."</td>";
        echo "<td>".$row['updated_at']."</td>";
        echo "<td>".$row['round_at']."</td>";
        echo "</tr>";
        $i=$i+1;
    }
}
function getWorkshopParticipants($workshop_id)
{
    $con=mysqli_connect("localhost","root","060848","atmos");
    $query="SELECT * FROM event_workshops_participants WHERE eventid=$workshop_id";
    $result = mysqli_query($con,$query);
    $i=1;
    while ($row=mysqli_fetch_assoc($result))
    {
        if($row['is_coupon']==1)
            $coupon_applied = 'Yes';
        if($row['is_coupon']==0)
            $coupon_applied = 'No';
        echo "<tr>";
        echo "<td>".$i."</td>";
        echo "<td>".$row['userid']."</td>";
        echo "<td>".$row['created_at']."</td>";
        echo "<td>".$coupon_applied."</td>";
        echo "</tr>";
        $i=$i+1;
    }
}
?>
