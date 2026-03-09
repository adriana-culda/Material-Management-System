<?php
include "config.php"; // Include conexiunea la baza de date

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verificăm dacă materialul există
    $stmt = $conn->prepare("SELECT * FROM materiale WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $material = $result->fetch_assoc();

    if (!$material) {
        die("Materialul cu ID-ul specificat nu există.");
    }

    // Ștergem materialul
    $stmt = $conn->prepare("DELETE FROM materiale WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Reordonăm ID-urile după ștergere
        $conn->query("SET @num := 0");
        $conn->query("UPDATE materiale SET id = (@num := @num + 1)");
        $conn->query("ALTER TABLE materiale AUTO_INCREMENT = 1");

        header("Location: ../index.php?status=deleted"); // Redirecționează înapoi la pagina principală cu un mesaj de succes
        exit();
    } else {
        die("Eroare la ștergere: " . $conn->error);
    }
} else {
    die("ID-ul materialului nu a fost specificat.");
}
?>
