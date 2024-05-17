<?php

require __DIR__ . '/../vendor/autoload.php'; // Add a forward slash before '../vendor/autoload.php'

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../partials'); // Add a forward slash before '../partials'
$dotenv->load();

// Now you can access the environment variables
$hostname = $_ENV['DATABASE_HOSTNAME'];
$username = $_ENV['DATABASE_USERNAME'];
$password = $_ENV['DATABASE_PASSWORD'];
$database = $_ENV['DATABASE_NAME'];

// Use the variables as needed in your application
$conn=mysqli_connect($hostname,$username,$password,$database);

if(!$conn)
{
    die("Error". mysqli_connect_error());
}

?>
