
<!DOCTYPE html>
<html>
<head>
    <title>Notifiche Email</title>
</head>
<body>
    <h1>Invio Notifiche Email</h1>
    <form method="post" action="?page=notification&action=orderConfirmation">
        <label>Email utente: <input type="email" name="user_email" required></label><br>
        <label>ID ordine: <input type="number" name="order_id" required></label><br>
        <label>Totale: <input type="number" step="0.01" name="total" required></label><br>
        <button type="submit">Invia conferma ordine</button>
    </form>
    <form method="post" action="?page=notification&action=supportReply">
        <label>Email utente: <input type="email" name="user_email" required></label><br>
        <label>ID ticket: <input type="number" name="ticket_id" required></label><br>
        <label>Risposta:<br>
            <textarea name="reply" required></textarea>
        </label><br>
        <button type="submit">Invia risposta supporto</button>
    </form>
    <a href="?page=admin">Torna alla dashboard admin</a>
</body>
</html>