<?php

session_start();
require_once 'db_connection.php';

// Recupera e valida l'ID
$id = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT
);


if (!$id || $id <= 0) {

    $_SESSION['error'] = "ID utente non valido";

    header("Location: visualizza_dati.php");

    exit();
}


// Query preparata per eliminare l'utente
$stmt = $conn->prepare(
    "DELETE FROM utenti WHERE id = ?"
);

$stmt->bind_param("i", $id);


if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {

        $_SESSION['success'] = "Utente eliminato con successo";

    } else {

        $_SESSION['error'] = "Utente non trovato";
    }

} else {

    $_SESSION['error'] =
        "Errore durante l'eliminazione: " . $stmt->error;
}


$stmt->close();
$conn->close();


// Torna alla lista
header("Location: visualizza_dati.php");

exit();

?>