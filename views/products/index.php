<?php
// $products deve essere un array di prodotti passato dal controller
?>
<!DOCTYPE html>
<html>
<head>
    <title>Negozio Tecnologia</title>
</head>
<body>
    <h1>Prodotti tecnologici</h1>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <?php echo htmlspecialchars($product['name']); ?> -
                <?php echo htmlspecialchars($product['category']); ?> -
                €<?php echo number_format($product['price'], 2); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>