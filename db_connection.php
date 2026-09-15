<?php

// Dati di accesso al database
const SERVER_NAME = "localhost";
const USER = "root";
const PASSWORD = "";
const DB_NAME = "clienti_db";

// Creazione della connessione
$conn = new mysqli(
    SERVER_NAME,
    USER,
    PASSWORD,
    DB_NAME
);

// Controllo della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Imposta il charset
$conn->set_charset("utf8mb4");

?>