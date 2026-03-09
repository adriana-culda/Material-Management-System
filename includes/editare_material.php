<?php
include "config.php"; // Include conexiunea la baza de date

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preluăm datele materialului curent
    $stmt = $conn->prepare("SELECT * FROM materiale WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $material = $result->fetch_assoc();

    // Verificăm dacă materialul există
    if (!$material) {
        die("Materialul cu ID-ul specificat nu există.");
    }
}

// Obținem lista locațiilor existente
$locatii_result = $conn->query("SELECT * FROM locatii");

if (!$locatii_result) {
    die("Eroare la obținerea locațiilor: " . $conn->error);
}

// Actualizăm materialul după trimiterea formularului
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nume = $_POST["nume"];
    $unitatea_de_masura = $_POST["unitatea_de_masura"];
    $pret = $_POST["pret"];
    
    $locatie_id = $_POST["locatie_id"];

    $stmt = $conn->prepare("UPDATE materiale SET nume = ?, unitatea_de_masura = ?, pret = ?, data = ?, locatie_id = ? WHERE id = ?");
    $stmt->bind_param("ssdssi", $nume, $unitatea_de_masura, $pret, $data_editare, $locatie_id, $id);
    
    if ($stmt->execute()) {
        header("Location: ../index.php"); // Redirecționează înapoi la pagina principală
        exit();
    } else {
        die("Eroare la actualizare: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editare Material</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">Gestiune Materiale</a>
    </div>
</nav>
<div class="container mt-5">
    <h2 class="text-center">Editare Material</h2>
    
    <form action="editare_material.php" method="post" class="row g-3">
        <input type="hidden" name="id" value="<?php echo $material['id']; ?>">

        <div class="col-md-6">
            <label for="nume" class="form-label">Nume Material</label>
            <input type="text" name="nume" id="nume" class="form-control" value="<?php echo $material['nume']; ?>" required>
        </div>

        <div class="col-md-6">
            <label for="unitatea_de_masura" class="form-label">Unitatea de Măsură</label>
            <input type="text" name="unitatea_de_masura" id="unitatea_de_masura" class="form-control" value="<?php echo $material['unitatea_de_masura']; ?>" required>
        </div>

        <div class="col-md-4">
            <label for="pret" class="form-label">Preț</label>
            <input type="number-"  name="pret" id="pret" class="form-control" value="<?php echo $material['pret']; ?>" required>
        </div>

        <div class="col-md-4">
            <label for="data" class="form-label">Data</label>
            <input type="date" name="data" id="data" class="form-control" value="<?php echo $material['data']; ?>" required>
        </div>

        <div class="col-md-4">
            <label for="locatie_id" class="form-label">Locație</label>
            <select name="locatie_id" id="locatie_id" class="form-select" required>
                <?php while ($locatie = $locatii_result->fetch_assoc()) { ?>
                    <option value="<?php echo $locatie['id']; ?>" <?php echo $locatie['id'] == $material['locatie_id'] ? 'selected' : ''; ?>>
                        <?php echo $locatie['nume']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Salvează Modificările</button>
            <a href="../index.php" class="btn btn-secondary">Înapoi</a>
        </div>
    </form>
</div>
</body>
</html>
