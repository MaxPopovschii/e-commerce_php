
<!DOCTYPE html>
<html>
<head>
    <title>I tuoi ordini</title>
</head>
<body>
    <h1>Storico ordini</h1>
    <ul>
        <?php foreach ($orders as $order): ?>
            <li>
                Ordine #<?php echo $order['id']; ?> - 
                Totale: €<?php echo number_format($order['total'], 2); ?> - 
                Stato: <?php echo htmlspecialchars($order['status']); ?> - 
                Data: <?php echo $order['created_at']; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="?page=products">Torna ai prodotti</a>
</body>
</html>