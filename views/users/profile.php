
<!DOCTYPE html>
<html>
<head>
    <title>Profilo utente</title>
</head>
<body>
    <h1>Benvenuto, <?php echo htmlspecialchars($user['username']); ?></h1>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    <a href="?page=users&action=logout">Logout</a>
</body>
</html>