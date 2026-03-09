<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nume = $_POST["nume"];
    $unitatea_de_masura = $_POST["unitatea_de_masura"];
    $pret = $_POST["pret"];
    $data = date('Y-m-d'); // Data curentă
    $locatie = $_POST["locatie"];

    // Verificăm dacă locația există deja
    $stmt = $conn->prepare("SELECT id FROM locatii WHERE nume = ?");
    $stmt->bind_param("s", $locatie);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $locatie_id = $row['id'];
    } else {
        // Adăugăm locația dacă nu există
        $stmt = $conn->prepare("INSERT INTO locatii (nume) VALUES (?)");
        $stmt->bind_param("s", $locatie);
        $stmt->execute();
        $locatie_id = $stmt->insert_id;
    }

    // Adăugăm materialul
    $stmt = $conn->prepare("INSERT INTO materiale (nume, unitatea_de_masura, pret, data, locatie_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $nume, $unitatea_de_masura, $pret, $data, $locatie_id);

    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        die("Eroare la adăugare: " . $conn->error);
    }
}
?>