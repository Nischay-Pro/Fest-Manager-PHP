<?php
$con=mysqli_connect('localhost','root','060848','pearl_16');
class DB_Functions {
    //put your code here
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        require_once 'DB_Config.php';
        // connecting to database
        
      $this->db = new DB_Connect();
        $this->db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
    public function regUser($name,$email,$phone,$college,$code,$reg,$accom,$team_id){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
        $regUser=mysqli_query($con,"INSERT INTO users(name,email,phone,college,pearl_id,reg,accom,id_reg) VALUES('$name','$email','$phone','$college','$code','$reg','$accom','$team_id')");  
        if ($regUser) {
            // return user data
            $team_reg_collect_query=mysqli_query($con,"UPDATE dosh_credentials SET reg_collect=reg_collect+250 WHERE team_id='$team_id'");
            $response=array();
            $response['name']=$name;
            $response['college']=$college;
            $response['phone']=$phone;
            $response['email']=$email;
            $response['pearl_id']=$code;
            $response['registration']=1;
            echo json_encode($response);
            return true;

        } else {
            return false;
        }
    mysqli_close($con);
    }
    public function addUserToEvent($pearl_id,$event_id,$uploaded_by){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
        $time=Date('U');
        $addUser=mysqli_query($con,"INSERT INTO event_participants(event_id,pearl_id,uploaded_by,updated_at) VALUES('$event_id','$pearl_id','$uploaded_by','$time')");
        if ($addUser) {
            // return user data
            $query=mysqli_query($con,"SELECT * FROM users WHERE pearl_id='$pearl_id'");
            if(mysqli_num_rows($query)){
            $result=mysqli_fetch_array($query);
            $response=array();
            $response['pearl_id']=$result['pearl_id'];
            $response['name']=$result['name'];
            echo json_encode($response);
            return true;
        }
        else{
            return false;
        }
            

        } else {
            return false;
        }
    mysqli_close($con);
    }
     public function checkDoshLogin($team_id,$password){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
        $checkUser=mysqli_query($con,"SELECT * FROM dosh_credentials WHERE team_id='$team_id' AND team_pass='$password'");
        $rows=mysqli_num_rows($checkUser);
        if ($rows) {
            // return user data
            $response=array();
            $response['team_id']=$team_id;
            echo json_encode($response);
            return true;
        } else {
            return false;
        }
    mysqli_close($con);
    }
    public function getIndiEventData($event_id,$updated_at){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
        $addUser=mysqli_query($con,"SELECT * FROM event_participants NATURAL JOIN users WHERE CAST(updated_at AS UNSIGNED) > $updated_at");
        if ($addUser) {
            // return user data
            $response=array();
            $i=0;
            while($result=mysqli_fetch_array($addUser)){
            $response[$i]['event_id']=$result['event_id'];
            $response[$i]['pearl_id']=$result['pearl_id'];
            $response[$i]['uploaded_by']=$result['uploaded_by'];
            $response[$i]['updated_at']=$result['updated_at'];
            $response[$i]['rount_at']=$result['round_at'];
            $response[$i]['name']=$result['name'];
             $i++;

            }
            echo json_encode($response);
            return true;
        } else {
            return false;
        }
    mysqli_close($con);
    }

    public function getGroupEventData($event_id,$updated_at){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
        $getGroupDetails=mysqli_query($con,"SELECT * FROM  group_details WHERE CAST(updated_at AS UNSIGNED) >$updated_at AND event_id='$event_id'");
        

        if ($getGroupDetails) {
            // return user data
            $response=array();
            $i=0;
            while($result=mysqli_fetch_array($getGroupDetails)){
            $response[$i]['event_id']=$result['event_id'];
            $response[$i]['updated_at']=$result['updated_at'];
            $response[$i]['round_at']=$result['round_at'];
            $response[$i]['group_name']=$result['group_name'];
            $response[$i]['group_id']=$result['group_id'];
             $i++;

            }
            $getGroupMembers=mysqli_query($con,"SELECT * FROM group_members as gm,users as u WHERE gm.group_id IN (select group_id from group_details WHERE CAST(updated_at AS UNSIGNED) >$updated_at) and gm.pearl_id=u.pearl_id AND event_id='$event_id'");
            $response2=array();
            $i=0;
            while($result=mysqli_fetch_array($getGroupMembers)){
            $response2[$i]['event_id']=$result['event_id'];
            $response2[$i]['pearl_id']=$result['pearl_id'];
            $response2[$i]['name']=$result['name'];
            $response2[$i]['group_id']=$result['group_id'];
             $i++;

            }
            $response3=array();
            $response3['details']=$response;
            $response3['members']=$response2;
            echo json_encode($response3);
            return true;
        } else {
            return false;
        }
    mysqli_close($con);
    }
    public function checkEventAdmin($Bits_ID,$password){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
        $checkEventAdmin=mysqli_query($con,"SELECT * FROM event_credentials WHERE Bits_ID='$Bits_ID' AND password='$password'");
        $rows=mysqli_num_rows($checkEventAdmin);
        if ($rows) {
            // return user data
            
            $result=mysqli_fetch_array($checkEventAdmin);
            $response=array();
            $response['organiser_id']=$result['organiser_id'];
            $response['uploader_name']=$result['uploader_name'];
            $response['club_name']=$result['club_name'];
            echo json_encode($response);
            return true;
            

        } else {
            
            return false;
        }
    mysqli_close($con);
    }
     public function getEvents(){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
        $getEvents=mysqli_query($con,"SELECT * FROM pearl_events");
        if ($getEvents) {
            // return user data
            $response=array();
            $i=0;
            while($result=mysqli_fetch_array($getEvents)){
            $response[$i]['event_id']=$result['event_id'];
            $response[$i]['event_name']=$result['event_name'];
            $response[$i]['paid']=$result['paid'];
             $i++;

            }
            echo json_encode($response);
            return true;
            

        } else {
            return false;
        }
    mysqli_close($con);
    }
    public function getSchedule($updated_at){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
        $getEvents=mysqli_query($con,"SELECT * FROM event_details NATURAL JOIN pearl_events WHERE CAST(updated_at AS UNSIGNED) > $updated_at");
        if ($getEvents) {
            // return user data
            $response=array();
            $i=0;
            while($result=mysqli_fetch_array($getEvents)){
            $response[$i]['event_id']=$result['Event_id'];
           $response[$i]['round_name']=$result['Roundname'];
           $response[$i]['updated_at']=$result['updated_at'];
           $response[$i]['Event_venue']=$result['Event_venue'];
           $response[$i]['event_name']=$result['event_name'];
           $response[$i]['id']=$result['id'];
             $i++;

            }
            return $response;
        } else {
            return false;
        }
    mysqli_close($con);
    }
    
    public function addUserToGroup($pearl_id,$group_id,$event_id){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');

        $addUser=mysqli_query($con,"INSERT INTO group_members(group_id,pearl_id,event_id) VALUES('$group_id','$pearl_id','$event_id')");
        if ($addUser) {
            $time=Date('U');
            $updatetime=mysqli_query($con,"UPDATE group_details SET updated_at='$time' WHERE group_id='$group_id' AND event_id='$event_id'");
            // return user data
            $query=mysqli_query($con,"SELECT * FROM users WHERE pearl_id='$pearl_id'");
            $result=mysqli_fetch_array($query);
            $response=array();
            $response['pearl_id']=$pearl_id;
            $response['event_id']=$event_id;
            $response['name']=$result['name'];
            $response['group_id']=$group_id;
            return $response;

        } else {
            
            return false;
        }
    mysqli_close($con);
    }
    public function updateParticipantRound($pearl_id,$event_id,$round_id){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');

        $addUser=mysqli_query($con,"UPDATE event_participants SET round_at='$round_id' WHERE event_id='$event_id' AND pearl_id='$pearl_id'");
        if ($addUser) {
            $response['event_id']=$event_id;
            $response['pearl_id']=$pearl_id;
            return $response;

        } else {
            
            return false;
        }
    mysqli_close($con);
    }
    public function updateGroupRound($round_id,$group_id,$event_id){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
        $time=Date('U');
        $addUser=mysqli_query($con,"UPDATE group_details SET round_at='$round_id',updated_at='$time' WHERE event_id='$event_id' AND group_id='$group_id'");
        if ($addUser) {

            $response['event_id']=$event_id;
            $response['round_id']=$round_id;
            $response['group_id']=$group_id;
            return $response;

        } else {
            
            return false;
        }
    mysqli_close($con);
    }
    public function getGroupId(){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
        $getGroupId=mysqli_query($con,"SELECT DISTINCT group_id FROM group_details");
        $result=mysqli_num_rows($getGroupId);
        $group_id=$result+1;
        return $group_id;
    }
    public function addGroupDetails($group_id,$group_name,$event_id,$uploaded_by,$round_id){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
        $time=Date('U');
        $addGroupDetails=mysqli_query($con,"INSERT INTO group_details(group_id,group_name,event_id,uploaded_by,round_at,updated_at) VALUES('$group_id','$group_name','$event_id','$uploaded_by','$round_id','$time')");
        if($addGroupDetails){
            $response=array();
            $response['event_id']=$event_id;
            $response['group_name']=$group_name;
            $response['group_id']=$group_id;
            echo json_encode($response);
            return true;
        }
        else{
            return false;
        }
    }
    
    public function addToEvent(){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
        $addGroup=mysqli_query($con,"INSERT INTO events(event_id,user_id) VALUES('$event_id','$group_id')");
        if($addGroup){
            return true;
        }
        else{
            return false;
        }
        
    }
public function gcmCall($event_id,$message,$arraynew,$count) {
    $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16'); 
     include_once 'GCMPushMessage.php';
    $apikey="AIzaSyC07vqOwJVrQ8f763cwtIFU3Pjw45m1um4";
    $gcm = new GCMPushMessage($apikey);
    $registration_ids = $arraynew;
    $message = array("message"=>$message,"event_id"=>$event_id);
    $gcm->setDevices($registration_ids);
    $result = $gcm->send($message);
        $act++;  
       
    $result= json_decode($result, true);
    if($result['success']>0){
        //delete entry          
     }
     else {
         //chat not added to GCM
            return false;
        }
     
mysqli_close( $con);
    }

public function addToken($token){
$con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
    $query=mysqli_query($con,"SELECT * FROM user_token WHERE token='$token'");
    $rows=mysqli_num_rows($query);
    if($rows==0){
     $result = mysqli_query($con,"INSERT INTO user_token(token) VALUES('$token')");
            // check for successful store
            if ($result) {
               return true;
            } else {
             //token not added
                return false;
            }
    }
    else{
        return true;
    }
    mysql_close( $con);
}
public function getFeed($updated_at){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
        $getFeed=mysqli_query($con,"SELECT * FROM notifications  WHERE CAST(updated_at AS UNSIGNED) > $updated_at");
        if ($getFeed) {
            // return user data
            $response=array();
            $i=0;
            while($result=mysqli_fetch_array($getFeed)){
            $response[$i]['event_id']=$result['event_id'];
            $response[$i]['message']=$result['message'];
            $response[$i]['id']=$result['id'];
            $response[$i]['updated_at']=$result['updated_at'];
             $i++;

            }
            echo json_encode($response);
            return true;
        } else {
            return false;
        }
    mysqli_close($con);
    }
    public function updateNotification($message,$event_id){
        $con=mysqli_connect('localhost','root',DB_PASSWORD,'pearl_16');
        $time=Date('U');
        $addNotification=mysqli_query($con,"INSERT INTO notifications(event_id,message,updated_at) VALUES('$event_id','$message','$time')");
        if ($addNotification) {
            // return user data
            return true;
        } else {
            return false;
        }
    mysqli_close($con);
    }
}
?>