<?php

require_once 'db_connection.php';

$search_term = "";
$result_found = false;

// Controlla se è stata effettuata una ricerca
if (isset($_GET['search'])) {

    $search_term = trim($_GET['search']);

    if ($search_term !== "") {

        // Query preparata
        $stmt = $conn->prepare(
            "SELECT * FROM utenti
             WHERE nome LIKE ?
             OR email LIKE ?
             ORDER BY id DESC"
        );

        $search = "%" . $search_term . "%";

        $stmt->bind_param("ss", $search, $search);

        $stmt->execute();

        $result = $stmt->get_result();

    } else {

        // Se la ricerca è vuota mostra tutti gli utenti
        $sql = "SELECT * FROM utenti ORDER BY id DESC";

        $result = $conn->query($sql);
    }

} else {

    // Prima della ricerca mostra tutti gli utenti
    $sql = "SELECT * FROM utenti ORDER BY id DESC";

    $result = $conn->query($sql);
}


// Controlla se ci sono risultati
if ($result && $result->num_rows > 0) {
    $result_found = true;
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

    <title>Cerca utente</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        input[type="search"],
        button {
            padding: 8px;
            margin-right: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .no-results {
            color: #888;
            padding: 20px;
        }

    </style>

</head>

<body>

    <h2>Ricerca utente</h2>


    <form method="get">

        <label>
            Cerca per nome o email:
        </label>

        <input
            type="search"
            name="search"
            value="<?= htmlspecialchars($search_term) ?>"
            placeholder="Es. Mario oppure mario@email.it"
        >

        <button type="submit">
            Cerca
        </button>

    </form>


    <?php if ($result_found): ?>

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

        <p class="no-results">
            Nessun utente trovato.
        </p>

    <?php endif; ?>


    <p>

        <a href="./visualizza_dati.php">
            ← Torna agli utenti
        </a>

    </p>


    <?php $conn->close(); ?>

</body>

</html>