
<!DOCTYPE html>
<html>
<head>
    <title>Wishlist</title>
</head>
<body>
    <h1>La tua wishlist</h1>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <a href="?page=products&id=<?php echo $product['id']; ?>">
                    <?php echo htmlspecialchars($product['name']); ?>
                </a>
                - <?php echo htmlspecialchars($product['category']); ?>
                - €<?php echo number_format($product['price'], 2); ?>
                <form method="post" action="?page=wishlist&action=remove&id=<?php echo $product['id']; ?>" style="display:inline;">
                    <button type="submit">Rimuovi</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="?page=products">Torna ai prodotti</a>
</body>
</html>