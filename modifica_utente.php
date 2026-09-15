<?php

session_start();
require_once 'db_connection.php';

$error = "";
$messaggio = "";

// Recupera l'ID dall'URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);


// Se il form è stato inviato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recupera l'ID dal form
    $id = filter_input(
        INPUT_POST,
        'id',
        FILTER_VALIDATE_INT
    );

    $nome = trim($_POST['nome'] ?? "");
    $email = trim($_POST['email'] ?? "");


    // Controllo dati
    if (!$id || $id <= 0) {

        $error = "ID utente non valido";

    } elseif ($nome === "" || $email === "") {

        $error = "Nome ed email sono obbligatori";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Email non valida";

    } else {

        // Aggiornamento dell'utente
        $stmt = $conn->prepare(
            "UPDATE utenti
             SET nome = ?, email = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "ssi",
            $nome,
            $email,
            $id
        );


        if ($stmt->execute()) {

            $messaggio = "Utente modificato con successo";

        } else {

            $error = "Errore nell'aggiornamento: " . $stmt->error;
        }


        $stmt->close();
    }
}


// Recupera i dati dell'utente
$user = null;

if ($id && $id > 0) {

    $stmt = $conn->prepare(
        "SELECT * FROM utenti WHERE id = ?"
    );

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

    } else {

        $error = "Nessun utente trovato";
    }


    $stmt->close();

} else {

    $error = "ID utente non valido";
}


$conn->close();

?>

<!DOCTYPE html>
<html lang="it">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Modifica utente</title>

</head>

<body>

    <h2>MODIFICA UTENTE</h2>


    <p>
        <a href="./visualizza_dati.php">
            Visualizza dati
        </a>
    </p>


    <?php if ($messaggio): ?>

        <p style="color: green;">
            <?= htmlspecialchars($messaggio) ?>
        </p>

    <?php endif; ?>


    <?php if ($error): ?>

        <p style="color: red;">
            <?= htmlspecialchars($error) ?>
        </p>

    <?php endif; ?>


    <?php if ($user): ?>

        <form
            action="modifica_utente.php?id=<?= $user['id'] ?>"
            method="post"
        >

            <input
                type="hidden"
                name="id"
                value="<?= $user['id'] ?>"
            >


            <label>
                NOME:
            </label>

            <input
                type="text"
                name="nome"
                value="<?= htmlspecialchars($user['nome']) ?>"
                required
            >

            <br><br>


            <label>
                EMAIL:
            </label>

            <input
                type="email"
                name="email"
                value="<?= htmlspecialchars($user['email']) ?>"
                required
            >

            <br><br>


            <button type="submit">
                MODIFICA
            </button>

        </form>

    <?php endif; ?>

</body>

</html>