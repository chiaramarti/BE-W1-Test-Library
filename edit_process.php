<?php
// Connessione al database
$host = 'localhost';
$db   = 'gestione_libreria';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Errore di connessione al database: " . $e->getMessage());
}

// Verifica se sono stati inviati dati tramite il metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal modulo di modifica
    $id = $_POST['book_id'];
    $titolo = $_POST['titolo'];
    $autore = $_POST['autore'];
    $anno = $_POST['anno'];
    $genere = $_POST['genere'];

    // Query per aggiornare i dati del libro nel database
    $sql = "UPDATE libri SET titolo = ?, autore = ?, anno_pubblicazione = ?, genere = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titolo, $autore, $anno, $genere, $id]);

    // Reindirizza alla pagina principale dopo l'aggiornamento
    header("Location: index.php");
    exit();
} else {
    // Se non sono stati inviati dati tramite il metodo POST, reindirizza alla pagina principale
    header("Location: index.php");
    exit();
}
