<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") //send the request by post method
{
    include "partials/db_conn.php";
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM `accounts` WHERE  `username`=?";
$stmt=$conn->prepare( $sql );
$stmt->bind_param('s',$username);
$stmt->execute();
$result=$stmt->get_result();


$num=mysqli_num_rows($result);

    if ($num == 1) {
        while ($row=$result->fetch_assoc()) {
            $user_id = $row["user_id"];
            if ($password==$row["password"]) {
               session_start();
        $_SESSION["loggedin"]=true;
        $_SESSION['username'] = $username;
                header("location:dashboard.php");
            }
            else
            {
               echo "wrong pass";
            }
        }
      
    } else {
        
    }
} ?>







<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ProSensia | Login</title>
    <link rel="stylesheet" href="./src/style/style.css" />
    <link rel="stylesheet" href="./src/style/login.css" />
  </head>
  <body>
    <section class="main_signin_sogn_up">

      <div class="loginBox">
        <div class="loginBoxLeft">
          <div class="loginBoxLeftContent">
            <div class="loginBoxLeftContentRap">
              <div class="loginBoxLeftContentLoginBox">
                  <img src="./src/images/shapeForLoginPage.png">
                  <h1>LOGIN</h1>
              </div>
              <div class="loginBoxLeftContentSignupBox" onclick="switchPageSignup()">
                  <h1>SIGNUP</h1>
              </div>
            </div>
          </div>
        </div>
        <div class="loginBoxRight">
          <div class="loginBoxRightContent">
            <div class="loginBoxRightContentRap">
              <div class="loginBoxRightImg">
                <img src="./src/images/logoblack.png" alt="ProSensia" />
              </div>
              <form action="" method="post">
                <input type="text" name="username" placeholder="Username" />
                <input type="password" name="password" placeholder="Password" />
                <div class="loginBoxRightBtn">
                  <a href="#">Forgot Password</a>
                  <input type="submit" value="Login" />
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
