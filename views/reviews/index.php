
<!DOCTYPE html>
<html>
<head>
    <title>Recensioni prodotto</title>
</head>
<body>
    <h2>Recensioni</h2>
    <a href="?page=reviews&action=create&product_id=<?php echo $reviews[0]['product_id'] ?? $_GET['product_id']; ?>">Aggiungi recensione</a>
    <ul>
        <?php foreach ($reviews as $review): ?>
            <li>
                <strong><?php echo htmlspecialchars($review['username']); ?></strong>
                - Voto: <?php echo $review['rating']; ?>/5
                <br>
                <?php echo htmlspecialchars($review['comment']); ?>
                <br>
                <small><?php echo $review['created_at']; ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="?page=products&id=<?php echo $reviews[0]['product_id'] ?? $_GET['product_id']; ?>">Torna al prodotto</a>
</body>
</html>