<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettagli Libro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Libreria - Gestionale</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Bottone per aggiungere libro -->
                    <li class="nav-item">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBookModal">Aggiungi Libro</button>
                    </li>
                </ul>
                <!-- Link per tornare alla home -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php
        // Connessione al database con PDO
        $dsn = "mysql:host=localhost;dbname=gestione_libreria";
        $username = "root";
        $password = "";

        try {
            $conn = new PDO($dsn, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connessione al database fallita: " . $e->getMessage());
        }

        // Verifica se è stato passato un ID del libro come parametro
        if (isset($_GET['id'])) {
            $book_id = $_GET['id'];

            // Query per recuperare i dettagli del libro
            $query = "SELECT * FROM libri WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $book_id);
            $stmt->execute();

            // Se il libro è stato trovato, visualizza i dettagli
            if ($stmt->rowCount() > 0) {
                $book = $stmt->fetch(PDO::FETCH_ASSOC);
                // Visualizza i dettagli del libro
                echo "<h1 class='mb-3'><i>Pagina di dettaglio</i></h1>";
                echo "<p>Titolo: " . $book['titolo'] . "</p>";
                echo "<p>Autore: " . $book['autore'] . "</p>";
                echo "<p>Anno di pubblicazione: " . $book['anno_pubblicazione'] . "</p>";
                echo "<p>Genere: " . $book['genere'] . "</p>";
            } else {
                echo "Libro non trovato.";
            }
        } else {
            echo "ID del libro non specificato.";
        }
        ?>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>