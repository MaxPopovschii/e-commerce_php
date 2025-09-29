
<!DOCTYPE html>
<html>
<head>
    <title>Registrazione utente</title>
</head>
<body>
    <h1>Registrazione</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post" action="?page=users&action=register">
        <input type="text" name="username" placeholder="Username" required /><br>
        <input type="email" name="email" placeholder="Email" required /><br>
        <input type="password" name="password" placeholder="Password" required /><br>
        <button type="submit">Registrati</button>
    </form>
    <a href="?page=users&action=login">Login</a>
</body>
</html>