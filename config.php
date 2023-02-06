<?php
//Simpleish forum written by Snat.
//Do as you wish with it, I was bored.

$host = '';
$dbname = '';
$username = '';
$password = '-';

//Below is general config details. 

$site_name = "";
$site_email = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to database: " . $e->getMessage());
}
?>