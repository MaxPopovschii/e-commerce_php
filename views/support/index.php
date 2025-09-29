
<!DOCTYPE html>
<html>
<head>
    <title>I tuoi ticket di supporto</title>
</head>
<body>
    <h1>Ticket di assistenza</h1>
    <a href="?page=support&action=create">Apri nuovo ticket</a>
    <ul>
        <?php foreach ($tickets as $ticket): ?>
            <li>
                <strong><?php echo htmlspecialchars($ticket['subject']); ?></strong><br>
                Stato: <?php echo htmlspecialchars($ticket['status']); ?><br>
                Messaggio: <?php echo nl2br(htmlspecialchars($ticket['message'])); ?><br>
                <small><?php echo $ticket['created_at']; ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="?page=products">Torna al negozio</a>
</body>
</html>