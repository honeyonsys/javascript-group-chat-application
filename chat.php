<?php
/*
Description: Group chat application developed for 1neclick online pvt ltd. Users can login with their login details and can chat together in a single chat window, also they can share files upto 10gb on the same window.
Site Url : http://1neclick.com
Author : Harish Kumar (honeyonsys)
Author URL : http://honeyonsys.github.io
*/ 
session_start();
ob_start();
include('config.php');

if($_SESSION['1neclick']=='')
{
	header('location: '.$siteurl.'login.php');
}
if(isset($_REQUEST['logout']))
{
    session_destroy();
    header('location:'.$siteurl.'login.php');
}

?>
<!DOCTYPE html>
<html>
<head>
<title>1neclick chat login</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<!--custom css-->
<script src="js/jquery-3.1.0.min.js"></script>
<link rel="stylesheet" href="css/style.css">
<Script src="js/script.js"></script>
<script src="js/dropzone.js"></script>

</head>
<body>

<a href="http://bootsnipp.com/mouse0270/snippets/4l0k2" class="btn btn-danger hide" id="back-to-bootsnipp">Back to Bootsnipp</a>
   
<?php $logged_user = mysqli_query($connection, "SELECT * FROM `user` WHERE `id`='".$_SESSION['1neclick']."'"); 
$c_user = mysqli_fetch_array($logged_user);
?>    
   

    <div class="popup-box chat-popup">
        <div class="popup-head">
                <div class="col-md-6">
                <img src="<?php echo $sitelogo; ?>" alt="1neclick" width="100"> <?php echo $site_title; ?>
                </div>
                <div class="user-welcome"><i class="glyphicon glyphicon-user"></i> Welcome <?php 
    echo $c_user['user_name']; ?>,  <a href="?logout">Sign Out</a></div>   
        </div>
        <div class="popup-messages">
            <div class="direct-chat-messages"></div>
        </div>
        <div class="popup-messages-footer">
            
            <!-- <button class="bg_none" id="select_file"><i class="glyphicon glyphicon-paperclip"></i> </button> -->
            <textarea id="status_message" placeholder="Type a message..." rows="10" cols="40" name="message"></textarea>
            <button class="bg_none pull-right" id="send-message"><i class="glyphicon glyphicon-thumbs-up"></i> </button>
        </div>
    </div>
    

    <script type="text/javascript">
    jQuery(document).ready(function(){

        /*getting today messages on load */
        jQuery.ajax({
            type: 'POST', 
            url: '<?php echo $siteurl.'action.php';?>', 
            data: 'action=getallmsg',
            async: false,
            success: function(res){
                jQuery('.direct-chat-messages').html(res);
                jQuery(".popup-messages").animate({scrollTop: jQuery('.popup-messages')[0].scrollHeight}, 1000);
            }
         });
        

        /*calling latest message on every 4 sec*/
        setInterval(function() { 
            window.onfocus = function () {
                isActive = true;
             };
             
            window.onblur = function () {
                isActive = false;
             };          
            var last_msg_id = jQuery('.direct-chat-messages > .direct-chat-msg:last').attr('alt');
            if(jQuery('.direct-chat-messages > .direct-chat-msg').hasClass('highlight-msg')){
                jQuery('.direct-chat-msg').removeClass('highlight-msg');
            }
            jQuery.ajax({
                type: 'POST', 
                url: '<?php echo $siteurl.'action.php';?>', 
                data: 'action=getlatestmsg&last_msg_id='+last_msg_id,
                async: false,
                success: function(res){
                    if(res!=''){ // checking if there is any new message or not
                        jQuery('.direct-chat-messages').append(res);
                        jQuery(".popup-messages").animate({scrollTop: jQuery('.popup-messages')[0].scrollHeight}, 1000);
                        /*Chrome Notification starts*/
                        if (Notification.permission !== "granted")
                            Notification.requestPermission();
                        else {
                                if(isActive==false){
                                    var notification = new Notification('1neclick Chat', {
                                      icon: '<?php echo $sitelogo; ?>',
                                      body: jQuery(res).find('.direct-chat-text').text(),
                                    });

                                    notification.onclick = function () {
                                      window.focus("<?php echo $siteurl; ?>");      
                                    };
                                }       
                        } /*Chrome notification ends*/    
                    }
                }
             });
        }, 1000 * 2);

        /*sending msg */
        jQuery('#send-message').click(function(){
            jQuery.ajax({
                type: 'POST', 
                url: '<?php echo $siteurl.'action.php';?>', 
                data: 'action=newmsg&msg=<pre>'+jQuery('#status_message').val()+'</pre>&sender=<?php echo $_SESSION['1neclick']; ?>',
                success: function(res){
                    jQuery('#status_message').val('');
                    jQuery(".popup-messages").animate({scrollTop: jQuery('.popup-messages')[0].scrollHeight}, 1000);
                }
            });
        });

        jQuery('#status_message').keypress(function(e){
               if(e.keyCode == 13 && !e.shiftKey) {
               //e.preventDefault();
               jQuery(this).parents('.popup-messages-footer').children('#send-message').click();
              } 
        });

        jQuery(".popup-messages-footer").dropzone({ 
            url: "action.php",
            maxFilesize: 10240,
            clickable: true,
            success: function(res){
                // console.log(res.name);
                // console.log(res.xhr.response);
                jQuery.ajax({
                    type: 'POST', 
                    url: '<?php echo $siteurl.'action.php';?>', 
                    data: 'action=newmsg&msg=<a href="<?php echo $siteurl; ?>uploads/'+res.xhr.response+'" target="_blank"><pre> [File : '+res.xhr.response+']</a></pre>&sender=<?php echo $_SESSION['1neclick']; ?>',
                    success: function(res){
                        jQuery('.dz-preview').css('display','none');
                        jQuery(".popup-messages").animate({scrollTop: jQuery('.popup-messages')[0].scrollHeight}, 1000);
                    } 
                });       
            }
        });
        
        
    });
</script>
</body>
</html>