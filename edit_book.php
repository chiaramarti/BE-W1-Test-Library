<?php
// Verifica se sono stati inviati i dati del modulo di modifica libro tramite il metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
    // Connessione al database
    $host = 'localhost';
    $db   = 'gestione_libreria';
    $user = 'root';
    $pass = '';

    $dsn = "mysql:host=$host;dbname=$db";

    try {
        $conn = new PDO($dsn, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connessione al database fallita: " . $e->getMessage());
    }

    // Recupera l'ID del libro dalla query string
    $book_id = $_POST['book_id'];

    // Recupera i dati dal modulo di modifica libro
    $titolo = $_POST['titolo'];
    $autore = $_POST['autore'];
    $anno = $_POST['anno'];
    $genere = $_POST['genere'];

    // Query per aggiornare i dati del libro nel database
    $sql = "UPDATE libri SET titolo = ?, autore = ?, anno_pubblicazione = ?, genere = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$titolo, $autore, $anno, $genere, $book_id]);

    // Reindirizza alla pagina principale dopo la modifica del libro
    header("Location: index.php");
    exit();
} elseif (isset($_GET['id'])) {
    // Connessione al database
    $host = 'localhost';
    $db   = 'gestione_libreria';
    $user = 'root';
    $pass = '';

    $dsn = "mysql:host=$host;dbname=$db";

    try {
        $conn = new PDO($dsn, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connessione al database fallita: " . $e->getMessage());
    }

    // Recupera l'ID del libro dalla query string
    $book_id = $_GET['id'];

    // Query per ottenere i dati del libro da modificare
    $sql = "SELECT * FROM libri WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$book_id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        // Se il libro non esiste, reindirizza alla pagina principale
        header("Location: index.php");
        exit();
    }
} else {
    // Se l'ID del libro non è stato fornito, reindirizza alla pagina principale
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Libro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-4">
        <h2>Modifica Libro</h2>
        <form action="edit_process.php" method="POST">
            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
            <div class="mb-3">
                <label for="titolo" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="titolo" name="titolo" value="<?php echo $book['titolo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="autore" class="form-label">Autore</label>
                <input type="text" class="form-control" id="autore" name="autore" value="<?php echo $book['autore']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="anno" class="form-label">Anno di pubblicazione</label>
                <input type="number" class="form-control" id="anno" name="anno" value="<?php echo $book['anno_pubblicazione']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="genere" class="form-label">Genere</label>
                <input type="text" class="form-control" id="genere" name="genere" value="<?php echo $book['genere']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salva Modifiche</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>