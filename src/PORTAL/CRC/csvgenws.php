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
    fputcsv($output, array('S.no', 'Atmos_id', 'Registered_at', 'Coupon Applied?'));
    $query = "SELECT userid,created_at,is_coupon FROM event_workshops_participants WHERE eventid=$workshop_id";
    $result = mysqli_query($con, $query);
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['is_coupon'] == 1)
            $coupon_applied = 'Yes';
        if ($row['is_coupon'] == 0)
            $coupon_applied = 'No';
        $final_row = array($i, $row['userid'], $row['created_at'], $coupon_applied);
        fputcsv($output, $final_row);
        $i = $i + 1;
    }
}
if(isset($_GET['event_id'])){
    $event_id = mysqli_real_escape_string($con, $_GET['event_id']);
    $query = mysqli_query($con,"SELECT event_name FROM pearl_events WHERE event_id='$event_id'");
    $result=mysqli_fetch_array($query);
    $event_name = $result['event_name'];
    $filename = $event_name. '_participants.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    $output = fopen('php://output', 'w');
    fputcsv($output, array('S.no', 'Atmos_id', 'Uploaded By', 'Updated at', 'Round'));
    $query="SELECT * FROM event_participants WHERE event_id=$event_id";
    $result = mysqli_query($con,$query);
    $i=1;
    while ($row = mysqli_fetch_assoc($result)) {

        $final_row = array($i, $row['pearl_id'], $row['uploaded_by'], $row['updated_at'], $row['round_at']);
        fputcsv($output, $final_row);
        $i = $i + 1;
    }
}
if(isset($_GET['reg_list'])){
    $filename = 'Registered_users.csv';
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);
    $output = fopen('php://output', 'w');
    fputcsv($output, array('S.no', 'Atmos_id', 'Name', 'E-mail', 'College', 'Phone', 'Created'));
    $query="SELECT * FROM users";
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
    fputcsv($output, array('S.no', 'Atmos_id', 'StartDate', 'EndDate', 'Days', 'Bhavan', 'Cost', 'Refund', 'Accommodated On'));
    $query="SELECT * FROM accomodation";
    $result = mysqli_query($con,$query);
    $i = 1;
    while ($row=mysqli_fetch_assoc($result)){
        $final_row = array($i,$row['Pearl_Id'], $row['StartDate'], $row['EndDate'], $row['NoofDays'],$row['Bhavan'],$row['Cost'],
            $row['Refund'], $row['Updated_At']);
        fputcsv($output, $final_row);
        $i = $i + 1;
    }
}