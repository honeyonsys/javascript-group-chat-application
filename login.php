<?php
session_start();
include('config.php');
if(isset($_POST['go'])){
  $user = $_POST['username'];
  $pass = md5($_POST['password']);
  
  $query = "SELECT * FROM `user` WHERE `user_name`='$user' and `user_pass`='$pass'";
  $result = mysqli_query($connection,$query);
  
  //print_r($result);

while($user = mysqli_fetch_assoc($result)){
  $_SESSION['1neclick'] = $user['id']; 
  header('location: '.$site_url.'chat.php'); 
}


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
<link rel="stylesheet" href="css/style.css">
<Script src="js/script.js"></script>
</head>
<body>
<div class="container">
  
  <div class="row" id="pwd-container">
    <div class="col-md-4"></div>
    
    <div class="col-md-4">
      <section class="login-form">
        <form method="post" action="#" role="login">
          <img src="images/comp_logo.png" class="img-responsive" alt="" />
          <input type="text" name="username" placeholder="Username" required class="form-control input-lg" />
          
          <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Password" required="" />
          
          
          <div class="pwstrength_viewport_progress"></div>
          
          
          <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Sign in</button>
          <div>
            
            <a href="register.php">Create account</a> or <a href="#">reset password</a>
          </div>
          
        </form>
        
        <div class="form-links">
          <a href="#">www.1neclick.com</a>
        </div>
      </section>  
      </div>
      
      <div class="col-md-4"></div>
      

  </div>
  
  
  
</div>
</body>
</html>