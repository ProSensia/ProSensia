<?php

require __DIR__ . "../vendor/autoload.php"

$server="";
$username="";
$password="";
$dbname="";



$conn=mysqli_connect($server,$username,$password,$dbname);

if(!$conn)
{

    die("Error". mysqli_connect_error());
}
?>