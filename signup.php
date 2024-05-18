<?php
include "./partials/headers.php";



$success=false;
$already=false;
$incomplete=false;
if ($_SERVER["REQUEST_METHOD"] == "POST") //send the request by post method
{

  include "partials/db_conn.php"; // include the data base connection file

  //delacring variables

  $firstname = $_POST["fname"];
  $lastname = $_POST["lname"];
  $device_code = $_POST["devicecode"];
  $username = $_POST["username"];
  $password = $_POST["password"];
  $repeatpassword = $_POST["rpassword"];
$terms_aggree=$_POST["terms_agree"];

  if (empty($firstname) || empty($lastname) || empty($username) || empty($password) || empty($repeatpassword) ||empty($terms_aggree)) {
   $incomplete=true;
  } else {

    
    if (($password == $repeatpassword)) { // check if repeat pass is equal to password or not

$hashedpassword=password_hash($password, PASSWORD_DEFAULT);




      $query  = "SELECT `username` FROM `accounts` WHERE  `username`='$username'"; // to select username from table

      $check = mysqli_query($conn, $query);

      if ($check->num_rows > 0) // checks if user name already exists or not
      {
    $already=true;
  }
  else{
    $insert = $conn->prepare("INSERT INTO `accounts` (`fname`, `lname`,`username`, `password`, `device code`,`terms` ) VALUES(?,?,?,?,?,?)"); // to insert data into table 
    $insert->bind_param("ssssss", $firstname, $lastname, $username,$hashedpassword ,$device_code,$terms_aggree );

    if ($insert->execute()) {
      $success = true;
    } else {
      echo $conn->error;
    }

    $insert->close();
    $conn->close();
  }
}
}
}
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ProSensia | Signup</title>
    <link rel="stylesheet" href="./src/style/style.css" />
    <link rel="stylesheet" href="./src/style/signup.css" />
  </head>
  <body>
    <section class="main_signin_sogn_up">
    <?php
    if($success)
    {
    echo '  <div class="account_created" >
      <h1>Account Created Successfully !</h1>
    </div>';
    }

?>
    <?php
    if($already)
    {
    echo '  <div class="account_created" style="background-color:#D0342C" >
      <h1>User Name Already Taken!</h1>
    </div>';
    }

?>
          <?php
    if($incomplete)
    {
    echo '  <div class="account_created" style="background-color:#D0342C" >
      <h1>Fill The Form! </h1>
    </div>';
    }

?>
    <div class="signupBox">
      <div class="signupBoxLeft">
        <div class="signupBoxLeftContent">
          <div class="signupBoxLeftContentRap">
            <div class="signupBoxLeftContentSignupBox" onclick="switchPageLogin()">
                <h1>LOGIN</h1>
            </div>
            <div class="signupBoxLeftContentsignupBox">
                <img src="./src/images/shapeForloginPage.png">
                <h1>SIGNUP</h1>
            </div>
            
          </div>
        </div>
      </div>
      <div class="signupBoxRight">
        <div class="signupBoxRightContent">
          <div class="signupBoxRightContentRap">
            <div class="signupBoxRightImg">
              <img src="./src/images/logoblack.png" alt="ProSensia" />
            </div>
            <form action="" method="post" >
                <div class="signupBoxRightFLName">
                    <input name="fname" type="text" pattern="[a-z,A-z]*" required  placeholder="First Name">
                    <input name="lname" type="text" pattern="[a-z,A-z]*" placeholder="Last Name">
                </div>
              <input name="username" type="text" placeholder="Username" pattern="[a-z,A-z,1-9]*" required  />
              <input name="password" type="password" minlength="8" maxlength="16" placeholder="Password" />
              <input name="rpassword" type="password" placeholder="Re Password" />
              <input name="devicecode" type="text" placeholder="Device Code" />
              <div class="signupBoxRightBtn">
              <input style="width: 30px; height:28px !important; background: none; margin: 0px 20px; " type="checkbox" name="terms_agree" id=""><p>Do you  <a href="#">Agree Terms and Conditions </a></p> 
                <input type="submit" value="Signup" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>
    <script src="./src/script/script.js"></script>
  </body>
</html>
