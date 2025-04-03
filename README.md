
# E-commerce App

Una semplice applicazione e-commerce basata su PHP che implementa una struttura MVC. L'app permette di visualizzare e gestire gli utenti e i prodotti, ed è dotata di una gestione delle rotte, inclusa una pagina di errore 404 personalizzata.

## Caratteristiche

- **Struttura MVC** per una gestione chiara e modulare.
- **Gestione degli utenti**: visualizza la lista degli utenti e i dettagli di ogni singolo utente.
- **Gestione dei prodotti**: visualizza la lista dei prodotti e i dettagli di ogni singolo prodotto.
- **Pagina di errore 404** personalizzata per le rotte sconosciute.
- **Semplice routing** per gestire le richieste API e visualizzare i dati.

## Tecnologie

- **PHP** 7.x o superiore
- **MySQL** per il database (con tabelle per utenti e prodotti)
- **CSS** per la parte di styling della vista

## Installazione

### 1. Clona il repository

```bash
git clone https://github.com/tuo-utente/e-commerce-app.git
cd e-commerce-app
```

### 2. Configura il Database

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

Assicurati di configurare correttamente la connessione al database nel file `app/Database.php` (modificando le credenziali `host`, `dbName`, `username`, e `password`).

### 4. Avvia il Server PHP

Per avviare il server PHP integrato, esegui il seguente comando dalla cartella principale del progetto:

```bash
php -S localhost:8000 -t public/
```

### 5. Accedi all'App

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
├── app/
│   ├── Controllers/           # Controller MVC (UserController, ProductController)
│   ├── Models/                # Modelli per interagire con il database (User, Product)
│   ├── Database.php           # Gestione della connessione al database
│   └── Views/                 # Views per l'interfaccia utente (HTML)
│
├── public/                    # Cartella pubblica (accessibile via web)
│   └── index.php              # Punto di ingresso principale
│
├── views/
│   ├── errors/                # Pagina di errore 404
│   └── product_view.php       # View per la lista dei prodotti
│
├── .gitignore                 # File per ignorare file non necessari nel repository
└── README.md                  # Questo file
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
