<?php
 
include "includes/config.php"; // Conexiunea la baza de date

// Preluăm parametrii pentru sortare și căutare
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'id';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

// Obține locațiile
$locatii_result = $conn->query("SELECT * FROM locatii");

// Obține materialele cu numele locației, cu sortare și căutare
$materiale_result = $conn->prepare("
    SELECT 
        materiale.id, 
        materiale.nume, 
        materiale.unitatea_de_masura, 
        materiale.pret, 
        materiale.data, 
        locatii.nume AS locatie 
    FROM 
        materiale 
    JOIN 
        locatii ON materiale.locatie_id = locatii.id
    WHERE 
        materiale.nume LIKE ? OR locatii.nume LIKE ?
    ORDER BY $sort_column $sort_order
");

$search_param = "%$search%";
$materiale_result->bind_param("ss", $search_param, $search_param);
$materiale_result->execute();
$result = $materiale_result->get_result();

// Verifică dacă interogarea a eșuat
if (!$result) {
    die("Eroare la interogare: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestiune Materiale</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" >Gestiune Materiale</a>
    </div>
</nav>

<div class="container mt-4">
    <h1 class="text-center">Lista Materialelor</h1>
    
    <!-- Formular Adăugare Material -->
     
    <h2 class="text-center">Adaugă Material</h2>

    <form action="includes/adauga_material.php" method="post" class="row g-3">
        <div class="col-md-4">
            <label for="nume" class="form-label">Nume Material</label>
            <input type="text" name="nume" id="nume" class="form-control" placeholder="Nume material" required>
        </div>
        <div class="col-md-4">
            <label for="unitatea_de_masura" class="form-label">Unitatea de Măsură</label>
            <input type="text" name="unitatea_de_masura" id="unitatea_de_masura" class="form-control" placeholder="Unitatea de măsură" required>
        </div>
        <div class="col-md-4">
            <label for="pret" class="form-label">Preț</label>
            <input type="text" name="pret" id="pret" class="form-control" placeholder="Preț" required>
        </div>
        
        <div class="col-md-4">
            <label for="locatie" class="form-label">Locație</label>
            <input type="text" name="locatie" id="locatie" class="form-control" placeholder="Locație material" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">Adaugă</button>
        </div>
    </form>

    <!-- Formular Căutare -->
    <form method="get" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Caută..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Caută</button>
        </div>
    </form>

    <!-- Tabel Materiale -->
    <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th><a class="text-white" href="?sort_column=id&sort_order=<?php echo $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">ID</a></th>
                <th><a class="text-white" href="?sort_column=nume&sort_order=<?php echo $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">Nume</a></th>
                <th><a class="text-white" href="?sort_column=unitatea_de_masura&sort_order=<?php echo $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">Unitatea de Măsură</a></th>
                <th><a class="text-white" href="?sort_column=pret&sort_order=<?php echo $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">Preț</a></th>
                <th><a class="text-white" href="?sort_column=data&sort_order=<?php echo $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">Data</a></th>
                <th><a class="text-white" href="?sort_column=locatie&sort_order=<?php echo $sort_order === 'ASC' ? 'DESC' : 'ASC'; ?>">Locație</a></th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
          
        </tbody>
    </table>
</div>
</body>
</html>
