<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "gestiune_materiale";

// Conectare la baza de date folosind mysqli
$conn = new mysqli($servername, $username, $password, $database);

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiunea la baza de date a eșuat: " . $conn->connect_error);
}
?>