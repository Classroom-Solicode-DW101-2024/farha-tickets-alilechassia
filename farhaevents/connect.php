<?php
$servername = "localhost";
$dbname = "farhaevents";
$username = "root"; 
$password = "";
$conn = new mysqli($servername, $username, $password, $dbname);

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

} catch (PDOException $e) {
    echo("Echec dela connexion ". $e -> getMessage());
}
?>