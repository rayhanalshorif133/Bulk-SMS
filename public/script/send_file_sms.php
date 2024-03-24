<?php
date_default_timezone_set('Asia/Dhaka');

$servername 	= "192.168.20.14:3306";
$username 		= "root";
$password 		= "351f0*57034e1a025#";
$dbname 		= "bulk_sms";

while(1){
	$db = mysqli_connect($servername, $username, $password, $dbname); 

	$sql = "select * from bulk_s_m_s_msisdns where status='0' limit 100";
	$result = mysqli_query($db,$sql);

	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_array($result)){
			$mobile_number 	= $row['mobile_number'];
			$message 		= $row['message'];
			$api_key 		= $row['api_key'];
			$sender_id 		= $row['sender_id'];
			$user_id 		= $row['user_id'];
			$id 			= $row['id'];

			$response = send_sms($api_key,$mobile_number,$sender_id,$message);

			$sms_log_sql = "insert into s_m_s_logs (user_id,api_key,sender_id,mobile_number,message,our_api,our_api_response,status,type,created_date_time) ";
			$sms_log_sql .= " values('$user_id','$api_key','$sender_id','$mobile_number','$message','https://msg.elitbuzz-bd.com/smsapi','$response','1','1','".date('Y-m-d H:i:s')."')";

			mysqli_query($db, $sms_log_sql);

			$update_sql = "update bulk_s_m_s_msisdns set status = '1' where id ='$id'";
			mysqli_query($db, $update_sql);

			echo date('Y-m-d H:i:s')." -- ".$id."--".$mobile_number." :: ".$user_id." :: ".$response." \n";
		}
	}
	else{
		mysqli_close($db);

		if(date('H') == '00'){
			echo date('Y-m-d H:i:s')." :: Script stoped \n";
			exit;
		}
		echo date('Y-m-d H:i:s')." :: Script are sleeping for 15 mins \n";
		sleep(900);
	}
}
	

function send_sms($api_key,$mobile_number,$sender_id,$message) {
  $url = "https://msg.elitbuzz-bd.com/smsapi";
  $data = [
    "api_key" => $api_key ,
    "type" => "text/unicode",
    "contacts" => $mobile_number,
    "senderid" => $sender_id, 
    "msg" => $message,
  ];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $response = curl_exec($ch);
  curl_close($ch);
  return $response;
}