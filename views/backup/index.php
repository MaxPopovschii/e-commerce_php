
<!DOCTYPE html>
<html>
<head>
    <title>Backup Database</title>
</head>
<body>
    <h1>Backup Database</h1>
    <form method="post" action="?page=backup&action=create">
        <button type="submit">Crea nuovo backup</button>
    </form>
    <h2>Backup disponibili</h2>
    <ul>
        <?php foreach ($backups as $backup): ?>
            <li>
                <?php echo htmlspecialchars($backup->filename); ?> -
                Creato il <?php echo $backup->created_at; ?>
                <a href="?page=backup&action=download&filename=<?php echo urlencode($backup->filename); ?>">Scarica</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="?page=admin">Torna alla dashboard admin</a>
</body>
</html>