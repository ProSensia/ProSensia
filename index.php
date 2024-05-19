<?php

$request=$_SERVER['REQUEST_URI'];
$router=$request;

if ($router=='/')
{
    include "home.php";
}
elseif ($router=='/about') {
    include "about_us.php";
}
elseif ($router=='/contact') {
    include "contact_us.php";
}
elseif ($router=='/dashboard') {
    include "dashboard.php";
}
elseif ($router=='/signin') {
    include "login.php";
}
elseif ($router=='/signup') {
    include "signup.php";
}
?>