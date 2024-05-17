<?php
$server="premium104.web-hosting.com";
$username="prosxwdx_psensia";
$password="hzdA;aUWlFMi";
$dbname="prosxwdx_Prosensia";



$conn=mysqli_connect($server,$username,$password,$dbname);

if(!$conn)
{

    die("Error". mysqli_connect_error());
}
?>