
<!DOCTYPE html>
<html>
<head>
    <title>Login utente</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post" action="?page=users&action=login">
        <input type="text" name="username" placeholder="Username" required /><br>
        <input type="password" name="password" placeholder="Password" required /><br>
        <button type="submit">Accedi</button>
    </form>
    <a href="?page=users&action=register">Registrati</a>
</body>
</html>