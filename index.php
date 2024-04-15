<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Libreria</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
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

    // Calcola il numero totale di libri nel database
    $total_books_stmt = $conn->query("SELECT COUNT(*) FROM libri");
    $total_books = $total_books_stmt->fetchColumn();

    // Imposta il numero di righe per pagina
    $rows_per_page = 5;

    // Calcola il numero totale di pagine
    $total_pages = ceil($total_books / $rows_per_page);

    // Ottieni il numero della pagina corrente (se non specificato, impostalo a 1)
    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    // Calcola l'offset per la query SQL
    $offset = ($current_page - 1) * $rows_per_page;

    // Se è stata inviata una richiesta di ricerca
    if (isset($_GET['search'])) {
        // Filtra e valida il termine di ricerca
        $search_term = trim($_GET['search']);
        $search_term = htmlspecialchars($search_term, ENT_QUOTES, 'UTF-8');

        // Query per cercare i libri che corrispondono al termine di ricerca
        $query = "SELECT * FROM libri WHERE titolo LIKE '%$search_term%' OR autore LIKE '%$search_term%'";
    } else {
        // Query per ottenere solo le righe per la pagina corrente
        $query = "SELECT * FROM libri LIMIT $offset, $rows_per_page";
    }

    $result = $conn->query($query);
    ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Libreria - Gestionale</a>
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
                <!-- Form per ricerca libro -->
                <form class="d-flex" action="index.php" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Cerca libro..." aria-label="Search" name="search">
                    <button class="btn btn-outline-primary" type="submit">Cerca</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Elenco Libri</h2>
        <!-- Tabella dei libri -->
        <table class="table">
            <thead>
                <tr>
                    <!-- <th scope="col">ID</th> -->
                    <th scope="col">Titolo</th>
                    <th scope="col">Autore</th>
                    <th scope="col">Anno di pubblicazione</th>
                    <th scope="col">Genere</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <!-- <th scope="row"><?php echo $row['id']; ?></th> -->
                        <td><a href="book_detail.php?id=<?php echo $row['id']; ?>"><?php echo $row['titolo']; ?></a></td>
                        <td><?php echo $row['autore']; ?></td>
                        <td><?php echo $row['anno_pubblicazione']; ?></td>
                        <td><?php echo $row['genere']; ?></td>
                        <td>
                            <!-- Pulsanti di modifica ed eliminazione -->
                            <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Modifica</a>
                            <a href="delete_book.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questo libro?')">Elimina</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Paginazione Bootstrap -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php if ($i === $current_page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <!-- Modale di aggiunta libro -->
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookModalLabel">Aggiungi Libro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add_book.php" method="POST">
                        <div class="mb-3">
                            <label for="inputTitolo" class="form-label">Titolo</label>
                            <input type="text" class="form-control" id="inputTitolo" name="titolo" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputAutore" class="form-label">Autore</label>
                            <input type="text" class="form-control" id="inputAutore" name="autore" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputAnno" class="form-label">Anno di pubblicazione</label>
                            <input type="number" class="form-control" id="inputAnno" name="anno" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputGenere" class="form-label">Genere</label>
                            <input type="text" class="form-control" id="inputGenere" name="genere" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Aggiungi Libro</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Funzione per gestire la conferma di eliminazione
        function confirmDelete(id) {
            if (confirm("Sei sicuro di voler eliminare questo libro?")) {
                window.location.href = "delete_book.php?id=" + id;
            }
        }
    </script>

</body>

</html>