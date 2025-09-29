
<!DOCTYPE html>
<html>
<head>
    <title>Gestione Utenti</title>
</head>
<body>
    <h1>Utenti</h1>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?php echo htmlspecialchars($user['username']); ?> -
                <?php echo htmlspecialchars($user['email']); ?> -
                Ruolo: <?php echo htmlspecialchars($user['role']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="?page=admin">Torna alla dashboard</a>
</body>
</html>