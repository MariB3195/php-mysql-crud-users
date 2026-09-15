# Sistema CRUD per la Gestione Utenti (PHP & MySQL)

Questo è un sistema di gestione utenti completo che permette di creare, leggere, aggiornare ed eliminare record all'interno di un database locale. Il progetto implementa controlli di sicurezza contro SQL Injection e attacchi XSS.

## 🚀 Come avviare il progetto in locale

Segui questi passaggi per eseguire l'applicazione sul tuo computer utilizzando **XAMPP** (o MAMP/WampServer).

### 1. Prerequisiti
* Installare [XAMPP](https://apachefriends.org) (include PHP, MySQL e Apache).

### 2. Configurazione dei file
1. Scarica questo repository come file ZIP (cliccando su "Code" > "Download ZIP") oppure clona il progetto.
2. Estrai la cartella e posizionala all'interno della directory dei server locali:
   * Su Windows: `C:/xampp/htdocs/gestione-utenti/`
   * Su Mac: `/Applications/XAMPP/htdocs/gestione-utenti/`

### 3. Configurazione del Database
1. Apri il pannello di controllo di XAMPP e avvia i moduli **Apache** e **MySQL**.
2. Vai sul tuo browser all'indirizzo `http://localhost/phpmyadmin/`.
3. Crea un nuovo database e nominalo esattamente: `clienti_db`.
4. Seleziona il database appena creato, clicca sulla scheda **Importa**, seleziona il file `clienti_db.sql` presente nella cartella del progetto e clicca su **Importa** (in fondo alla pagina).

### 4. Avvio dell'applicazione
Apri il tuo browser e naviga al seguente indirizzo:
`http://localhost/gestione-utenti/visualizza_dati.php`
