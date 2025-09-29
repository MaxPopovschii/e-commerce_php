
<!DOCTYPE html>
<html>
<head>
    <title>Log Attività</title>
</head>
<body>
    <h1>Log Attività</h1>
    <table border="1">
        <tr>
            <th>Utente</th>
            <th>Azione</th>
            <th>Dettagli</th>
            <th>Data</th>
        </tr>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?php echo htmlspecialchars($log['username'] ?? 'Sistema'); ?></td>
                <td><?php echo htmlspecialchars($log['action']); ?></td>
                <td><?php echo htmlspecialchars($log['details']); ?></td>
                <td><?php echo $log['created_at']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="?page=admin">Torna alla dashboard admin</a>
</body>
</html>