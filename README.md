# E-commerce App

Una semplice applicazione e-commerce basata su PHP che implementa una struttura MVC. L'app permette di visualizzare e gestire utenti e prodotti, ed è dotata di una gestione delle rotte, inclusa una pagina di errore 404 personalizzata.

## Caratteristiche

- **Struttura MVC** per una gestione chiara e modulare.
- **Gestione degli utenti**: visualizza la lista degli utenti e i dettagli di ogni singolo utente.
- **Gestione dei prodotti**: visualizza la lista dei prodotti e i dettagli di ogni singolo prodotto.
- **Pagina di errore 404** personalizzata per le rotte sconosciute.
- **Semplice routing** per gestire le richieste API e visualizzare i dati.
- **Fallback automatico su file JSON**: se il database non è disponibile, i dati vengono letti e salvati in file locali nella cartella `data/`.

## Tecnologie

- **PHP** 7.x o superiore
- **MySQL** per il database (opzionale, con tabelle per utenti e prodotti)
- **File JSON** per il salvataggio locale dei dati (fallback)
- **CSS** per la parte di styling della vista

## Installazione

### 1. Clona il repository

```bash
git clone https://github.com/tuo-utente/e-commerce-app.git
cd e-commerce-app
```

### 2. Configura il Database (opzionale)

Crea il database e le tabelle per l'applicazione utilizzando i seguenti comandi MySQL:

```sql
CREATE DATABASE myapp;
USE myapp;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 3. Configura la Connessione al Database

Assicurati di configurare correttamente la connessione al database nel file `config/config.php` (modificando le credenziali `host`, `dbName`, `username`, e `password`).

### 4. Modalità senza Database (fallback su file)

Se non vuoi usare MySQL, crea la cartella `data/` e i file vuoti per il salvataggio locale:

```bash
mkdir -p data
echo "[]" > data/products.json
echo "[]" > data/users.json
echo "[]" > data/orders.json
echo "[]" > data/wishlist.json
```

L'app funzionerà automaticamente in modalità file locale se il database non è raggiungibile.

### 5. Avvia il Server PHP

Per avviare il server PHP integrato, esegui il seguente comando dalla cartella principale del progetto:

```bash
php -S localhost:8000 -t public/
```

### 6. Accedi all'App

Puoi ora accedere all'app nel tuo browser all'indirizzo `http://localhost:8000`.

- **Lista Utenti**: `http://localhost:8000/index.php?route=users`
- **Dettagli Utente**: `http://localhost:8000/index.php?route=users/show&id=1`
- **Lista Prodotti**: `http://localhost:8000/index.php?route=products`
- **Dettagli Prodotto**: `http://localhost:8000/index.php?route=products/show&id=1`
- **Errore 404**: Prova a navigare a una rotta sconosciuta, ad esempio `http://localhost:8000/index.php?route=nonexistent`.

## Struttura del Progetto

```
e-commerce-app/
│
├── controllers/               # Controller MVC (UserController, ProductController, ecc.)
├── models/                    # Modelli per dati (User, Product, ecc.)
├── views/                     # Views per l'interfaccia utente (HTML)
├── data/                      # File JSON per dati locali (fallback)
│   ├── products.json
│   ├── users.json
│   ├── orders.json
│   └── wishlist.json
├── config/                    # Configurazione database
│   └── config.php
├── public/                    # Cartella pubblica (accessibile via web)
│   └── index.php
├── .gitignore
└── README.md
```

## Contribuire

Se desideri contribuire a questo progetto, segui questi passaggi:

1. Fork del repository.
2. Crea un nuovo branch (`git checkout -b feature/nuova-funzionalità`).
3. Fai delle modifiche e committa (`git commit -am 'Aggiungi nuova funzionalità'`).
4. Push nel tuo branch (`git push origin feature/nuova-funzionalità`).
5. Crea una pull request.

## Licenza

Distribuito sotto la licenza MIT. Vedi `LICENSE` per ulteriori dettagli.

---

Se hai domande o suggerimenti, sentiti libero di aprire un'issue nel repository!
