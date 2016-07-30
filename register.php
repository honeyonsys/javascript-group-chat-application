<?php
ob_start();
session_start();
include('config.php');
if(isset($_POST['go'])){
  
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $check_user_query = mysqli_query($connection, "SELECT * FROM `user` WHERE `email`='$email' and `user_name`='$username'");

  if(mysqli_num_rows(mysqli_query($connection, $check_user_query)) > 0){
    header('location: register.php?register=unsuccessfull');
  } else {
    mysqli_query($connection, "INSERT INTO `user` (`user_email`,`user_name`,`user_pass`) VALUES('$email','$username','$password')");
    header('location: register.php?register=successfull');
  }


}
?>
<!DOCTYPE html>
<html>
<title>Your Title</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<!--custom css-->
<link rel="stylesheet" href="css/style.css">
<Script src="js/script.js"></script>
<head>
<body>
<div class="container">
  
  <div class="row" id="pwd-container">
    <div class="col-md-4"></div>
    
    <div class="col-md-4">
      <section class="login-form">
        <form method="post" action="#" role="login">
          <img src="images/comp_logo.png" class="img-responsive" alt="" />
          <div>
              Register you account<br>
              <?php if(isset($_REQUEST['register']) && $_REQUEST['register']=='unsuccessfull'){?>
              <span style="color:#FF0000;">This email is already registered</span>
              <?php } else if(isset($_REQUEST['register']) && $_REQUEST['register']=='successfull'){ ?>
              <span style="color:#128510;">You are successfully registered. <a href="login.php">Login In</a> here</span>
              <?php } ?>
          </div>
          
          <input type="email" name="email" placeholder="Email" required class="form-control input-lg" />

          <input type="text" name="username" placeholder="Username" required class="form-control input-lg" />
          
          <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Password" required="" />
          
          
          <div class="pwstrength_viewport_progress"></div>
          
          
          <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Register</button>
          <div>
            
            <a href="login.php">Login</a> or <a href="#">reset password</a>
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
</head>
</html>

