<?php

// Include il file della connessione
require_once 'db_connection.php';

$messaggio = "";
$errore = "";


// Controlla se il form è stato inviato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recupera i dati
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');


    // Controlla che i campi non siano vuoti
    if ($nome === '' || $email === '') {

        $errore = "Nome ed email sono obbligatori.";

    // Controlla che l'email sia valida
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errore = "Inserisci un indirizzo email valido.";

    } else {

        // Query preparata
        $stmt = $conn->prepare(
            "INSERT INTO utenti (nome, email) VALUES (?, ?)"
        );

        $stmt->bind_param(
            "ss",
            $nome,
            $email
        );


        // Esegue la query
        if ($stmt->execute()) {

            $messaggio = "Utente ($nome) creato con successo!";

        } else {

            // Controlla se l'email è duplicata
            if ($stmt->errno == 1062) {

                $errore = "Questa email è già presente.";

            } else {

                $errore = "Errore durante la creazione dell'utente: "
                        . $stmt->error;
            }
        }


        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="it">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Registrati</title>

</head>

<body>

    <h1>Registrati</h1>


    <p>
        <a href="./visualizza_dati.php">
            Mostra utenti
        </a>
    </p>


    <?php if ($messaggio): ?>

        <p style="color: green;">
            <?= htmlspecialchars($messaggio) ?>
        </p>

    <?php endif; ?>


    <?php if ($errore): ?>

        <p style="color: red;">
            <?= htmlspecialchars($errore) ?>
        </p>

    <?php endif; ?>


    <form method="post">

        <input
            type="text"
            name="nome"
            placeholder="Inserisci il tuo nome"
            value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
            required
        >

        <br><br>


        <input
            type="email"
            name="email"
            placeholder="Inserisci la tua email"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            required
        >

        <br><br>


        <button type="submit">
            Registrati
        </button>

    </form>

</body>

</html>
