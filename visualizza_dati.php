<?php

session_start();
require_once 'db_connection.php';

// Recupera tutti gli utenti
$sql = "SELECT * FROM utenti ORDER BY id DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Errore nella query: " . $conn->error);
}

// Recupera eventuali messaggi dalla sessione
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;

// Elimina i messaggi dalla sessione
unset($_SESSION['success']);
unset($_SESSION['error']);

?>

<!DOCTYPE html>
<html lang="it">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Visualizza dati</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            margin-right: 10px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

    </style>

</head>

<body>

    <h2>Visualizza Dati</h2>

    <p>
        <a href="./inserisci_utente.php">
            + Inserisci Utente
        </a>

        <a href="./cerca_utenti.php">
            Cerca Utenti
        </a>
    </p>

    <?php if ($success): ?>

        <p class="success">
            <?= htmlspecialchars($success) ?>
        </p>

    <?php endif; ?>


    <?php if ($error): ?>

        <p class="error">
            <?= htmlspecialchars($error) ?>
        </p>

    <?php endif; ?>


    <?php if ($result->num_rows > 0): ?>

        <table>

            <tr>

                <th>ID</th>
                <th>NOME</th>
                <th>EMAIL</th>
                <th>REGISTRATO</th>
                <th>AZIONE</th>

            </tr>


            <?php while ($row = $result->fetch_assoc()): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($row['id']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['nome']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['email']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['data_registrazione']) ?>
                    </td>

                    <td>

                        <a href="./modifica_utente.php?id=<?= $row['id'] ?>">
                            MODIFICA
                        </a>

                        <a
                            href="./elimina_utente.php?id=<?= $row['id'] ?>"
                            onclick="return confirm('Sei sicuro di voler eliminare questo utente?');"
                        >
                            ELIMINA
                        </a>

                    </td>

                </tr>

            <?php endwhile; ?>

        </table>

    <?php else: ?>

        <p>
            Nessun utente creato.
        </p>

    <?php endif; ?>


    <?php $conn->close(); ?>

</body>

</html>