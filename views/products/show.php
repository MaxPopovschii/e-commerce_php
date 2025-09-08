<?php
// $product deve essere passato dal controller
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($product['name']); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    <p>Categoria: <?php echo htmlspecialchars($product['category']); ?></p>
    <p>Prezzo: €<?php echo number_format($product['price'], 2); ?></p>
</body>
</html>