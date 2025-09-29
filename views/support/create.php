
<!DOCTYPE html>
<html>
<head>
    <title>Apri ticket di assistenza</title>
</head>
<body>
    <h1>Nuovo ticket di supporto</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <label>Oggetto: <input type="text" name="subject" required></label><br>
        <label>Messaggio:<br>
            <textarea name="message" required></textarea>
        </label><br>
        <button type="submit">Invia</button>
    </form>
    <a href="?page=support">Torna ai ticket</a>
</body>
</html>