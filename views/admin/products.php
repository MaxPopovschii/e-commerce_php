
<!DOCTYPE html>
<html>
<head>
    <title>Gestione Prodotti</title>
</head>
<body>
    <h1>Prodotti</h1>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <?php echo htmlspecialchars($product['name']); ?> -
                <?php echo htmlspecialchars($product['category']); ?> -
                €<?php echo number_format($product['price'], 2); ?>
                <!-- Qui puoi aggiungere link per modifica/elimina -->
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="?page=admin">Torna alla dashboard</a>
</body>
</html>