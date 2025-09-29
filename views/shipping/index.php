
<!DOCTYPE html>
<html>
<head>
    <title>Seleziona spedizione</title>
</head>
<body>
    <h1>Opzioni di spedizione</h1>
    <ul>
        <?php foreach ($methods as $method): ?>
            <li>
                <?php echo htmlspecialchars($method['name']); ?> -
                €<?php echo number_format($method['price'], 2); ?> -
                Consegna in <?php echo $method['estimated_days']; ?> giorni
                <form method="post" action="?page=shipping&action=select&id=<?php echo $method['id']; ?>" style="display:inline;">
                    <button type="submit">Seleziona</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="?page=cart">Torna al carrello</a>
</body>
</html>