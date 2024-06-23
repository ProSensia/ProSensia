<?php

include "./partials/headers.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") 
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
            if ( password_verify($password,$row['password'])){
               session_start();
        $_SESSION["loggedin"]=true;
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_id;
                header("location:/dashboard");
            }
            else
            {
               echo "<script>alert('Wrong Password or username')</script>";
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

  <div id="preloader">
      <h1>
       <span class="let1">P</span>
       <span class="let2">R</span>
       <span class="let3">O</span>
       <span class="let4">S</span>
       <span class="let5">E</span>
       <span class="let6">N</span>
       <span class="let7">S I</span>
       <span class="let8">A</span> 
      </h1>
    </div>


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
