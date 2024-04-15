<?php
// Verifica se è stato fornito l'ID del libro da eliminare
if (isset($_GET['id'])) {
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

    // Query per eliminare il libro dal database
    $sql = "DELETE FROM libri WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$book_id]);

    // Reindirizza alla pagina principale dopo l'eliminazione
    header("Location: index.php");
    exit();
} else {
    // Se l'ID del libro non è stato fornito, reindirizza alla pagina principale
    header("Location: index.php");
    exit();
}
