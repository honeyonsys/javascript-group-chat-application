<?php
include('config.php');

if(isset($_POST['action']) && $_POST['action']=='newmsg'){
	$checksession = mysqli_query($connection, "SELECT * FROM `session` WHERE date(`time`) = CURDATE()");
	
	if(mysqli_num_rows($checksession) == 0)
	{
		mysqli_query($connection, "INSERT INTO `session` (`user_id`) VALUES('$_REQUEST[sender]') ");
		$curr_session = mysqli_insert_id($connection);

		mysqli_query($connection, "INSERT INTO `chat` (`user_id`,`message`,`session_id`) VALUES('$_REQUEST[sender]','$_REQUEST[msg]','$curr_session')");
		echo 'upper';
		
	} else {
		$curr_session = mysqli_fetch_array($checksession);
		mysqli_query($connection, "INSERT INTO `chat` (`user_id`,`message`,`session_id`) VALUES('$_REQUEST[sender]','$_REQUEST[msg]','$curr_session[id]') ");

		echo 'success';
	} 

}

if(isset($_POST['action']) && $_POST['action']=='getallmsg'){

	$checksession = mysqli_query($connection, "SELECT * FROM `session` WHERE date(`time`) = CURDATE()");
	if(mysqli_num_rows($checksession) != 0){
		$sessionid = mysqli_fetch_array($checksession); 
		$msgs_query = mysqli_query($connection, "SELECT * FROM `chat` WHERE `session_id`='$sessionid[id]' ORDER BY time ASC");
		echo '<div class="chat-box-single-line"><abbr class="timestamp">'.date('d F Y').'</abbr></div>';
		while($msgs = mysqli_fetch_assoc($msgs_query)){
			$user = mysqli_fetch_array(mysqli_query($connection, "SELECT `user_name` FROM `user` WHERE `id`='$msgs[user_id]'"));
			echo '<div class="direct-chat-msg doted-border" alt="'.$msgs['id'].'"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-left">'.$user['user_name'].'  </span> <span class="time-color"> - ['.date('h:i a d F Y',strtotime($msgs['time'])).']</span></div><div class="direct-chat-text">'.$msgs['message'].' </div></div>';
		}	
	} 
	
}

if(isset($_POST['action']) && $_POST['action']=='getlatestmsg'){
	$checksession = mysqli_query($connection, "SELECT * FROM `session` WHERE date(`time`) = CURDATE()");
	if(mysqli_num_rows($checksession) != 0){
		$sessionid = mysqli_fetch_array($checksession); 
		$msgs_query = mysqli_query($connection, "SELECT * FROM `chat` WHERE `session_id`='$sessionid[id]' AND `id`>'$_REQUEST[last_msg_id]' ORDER BY time ASC");
		while($msgs = mysqli_fetch_assoc($msgs_query)){
			$user = mysqli_fetch_array(mysqli_query($connection, "SELECT `user_name` FROM `user` WHERE `id`='$msgs[user_id]'"));
			echo '<div class="direct-chat-msg doted-border highlight-msg" alt="'.$msgs['id'].'"><div class="direct-chat-info clearfix"><span class="direct-chat-name pull-left">'.$user['user_name'].' </span><span class="time-color"> - ['.date('h:i a d F Y',strtotime($msgs['time'])).']</span></div><div class="direct-chat-text">'.$msgs['message'].' </div><div class="direct-chat-info clearfix"></div></div>';
		}	
	} else {
		echo 'There is no chat';
	}
}

if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];          //3             
    $newfilename = time(). str_replace(' ','_',$_FILES['file']['name']);  
    $targetPath = '/var/www/html/1neclick_group_chat/uploads/';  //4
    $targetFile =  $targetPath. $newfilename;  //5
    move_uploaded_file($tempFile,$targetFile); //6
    echo $newfilename;
     
}
?>