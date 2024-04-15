<?php
// Verifica se sono stati inviati i dati del modulo di aggiunta libro tramite il metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Recupera i dati dal modulo di aggiunta libro
    $titolo = $_POST['titolo'];
    $autore = $_POST['autore'];
    $anno = $_POST['anno'];
    $genere = $_POST['genere'];

    // Query per inserire il nuovo libro nel database
    $sql = "INSERT INTO libri (titolo, autore, anno_pubblicazione, genere) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$titolo, $autore, $anno, $genere]);

    // Reindirizza alla pagina principale dopo l'aggiunta del libro
    header("Location: index.php");
    exit();
} else {
    // Se non sono stati inviati dati tramite il metodo POST, reindirizza alla pagina principale
    header("Location: index.php");
    exit();
}
