<?php
session_start();
include("functions/functions.php");
if(!isset($_SESSION['crc_id'])){
    echo "<script>window.open('login.php','_self')</script>";
}
else{
    // start crc work here
}
if(isset($_GET['id'])) {
    $workshop_id = mysqli_real_escape_string($con, $_GET['id']);
    $query = mysqli_query($con, "SELECT name FROM event_workshops WHERE id='$workshop_id'");
    $result = mysqli_fetch_array($query);
    $workshop_name = $result['name'];
    $filename = $workshop_name . '_participants.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    $output = fopen('php://output', 'w');
    fputcsv($output, array('S.no', 'Atmos_id', 'Name', 'Registered_at', 'Coupon Applied?'));
    $query = "SELECT userid,created_at,is_coupon FROM event_workshops_participants WHERE eventid=$workshop_id";
    $result = mysqli_query($con, $query);
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['is_coupon'] == 1)
            $coupon_applied = 'Yes';
        if ($row['is_coupon'] == 0)
            $coupon_applied = 'No';
        $pearl_id = $row['userid'];
        $user_name = mysqli_query($con,"SELECT `name` FROM users WHERE pearl_id='$pearl_id'");
        $row2=mysqli_fetch_assoc($user_name);
        $final_row = array($i, $row['userid'], $row2['name'],$row['created_at'], $coupon_applied);
        fputcsv($output, $final_row);
        $i = $i + 1;
    }
}
if(isset($_GET['event_id'])){
    $event_id = mysqli_real_escape_string($con, $_GET['event_id']);
    $query = mysqli_query($con,"SELECT event_name FROM pearl_events WHERE event_id='$event_id'");
    $result=mysqli_fetch_array($query);
    $event_name = $result['event_name'];
    $filename = $event_name.'_participants.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    $output = fopen('php://output', 'w');
    fputcsv($output, array('S.no', 'Atmos_id', 'Name','Email-Id', 'Phone', 'College'));
    $pearl_ids = mysqli_query($con,"SELECT pearl_id FROM event_participants WHERE event_id=$event_id");
    if(mysqli_num_rows($pearl_ids)==0){
        $group_pearl_ids=mysqli_query($con,"SELECT pearl_id FROM group_members WHERE event_id=$event_id");
        $i = 1;
        while ($each_group_id=mysqli_fetch_assoc($group_pearl_ids)){
            $pearl_id = $each_group_id['pearl_id'];
            $member_details = mysqli_query($con,"SELECT * FROM users WHERE pearl_id='$pearl_id'");
            while($final_result=mysqli_fetch_array($member_details)){
                $final_row = array($i, $final_result['pearl_id'], $final_result['name'], $final_result['email'], $final_result['phone'], $final_result['college']);
                fputcsv($output, $final_row);
                $i = $i+1;
            }
        }
    }
    else{
        $i=1;
        while ($indi_pearl_ids = mysqli_fetch_assoc($pearl_ids)) {
            $pearl_id = $indi_pearl_ids['pearl_id'];
            $member_details = mysqli_query($con,"SELECT * FROM users WHERE pearl_id='$pearl_id'");
            while($final_result=mysqli_fetch_array($member_details)) {
                $final_row = array($i, $final_result['pearl_id'], $final_result['name'], $final_result['email'], $final_result['phone'], $final_result['college']);
                fputcsv($output, $final_row);
                $i = $i + 1;
            }
        }
    }
}
if(isset($_GET['reg_list'])){
    $filename = 'Registered_users.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    $output = fopen('php://output', 'w');
    fputcsv($output, array('S.no', 'Atmos_id', 'Name', 'E-mail', 'College', 'Phone', 'Created'));
    $query="SELECT * FROM users WHERE pearl_id LIKE 'PLH%'";
    $result = mysqli_query($con,$query);
    $i = 1;
    while ($row=mysqli_fetch_assoc($result)){
        $final_row = array($i,$row['pearl_id'], $row['name'], $row['email'], $row['college'],
            $row['phone'], $row['updated_at']);
        fputcsv($output, $final_row);
        $i = $i + 1;
    }
}

if(isset($_GET['acco_list'])){
    $filename = 'Accomodation_details.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    $output = fopen('php://output', 'w');
    fputcsv($output, array('S.no', 'Atmos_id', 'Name', 'StartDate', 'EndDate', 'Days', 'Bhavan', 'Cost', 'Refund', 'Accommodated On'));
    $query="SELECT * FROM accomodation";
    $result = mysqli_query($con,$query);
    $i = 1;
    while ($row=mysqli_fetch_assoc($result)){
        $pearl_id = $row['Pearl_Id'];
        $query1=mysqli_query($con,"SELECT * FROM users WHERE `pearl_id`='$pearl_id'");
        while ($details=mysqli_fetch_assoc($query1))
        {
            $name = $details['name'];
        }
        $final_row = array($i,$row['Pearl_Id'], $name, $row['StartDate'], $row['EndDate'], $row['NoofDays'],$row['Bhavan'],$row['Cost'],
            $row['Refund'], $row['Updated_At']);
        fputcsv($output, $final_row);
        $i = $i + 1;
    }
}