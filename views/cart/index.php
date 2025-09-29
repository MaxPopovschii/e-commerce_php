
<!DOCTYPE html>
<html>
<head>
    <title>Carrello</title>
</head>
<body>
    <h1>Il tuo carrello</h1>
    <ul>
        <?php foreach ($cart->items as $productId => $quantity): ?>
            <li>
                Prodotto ID: <?php echo $productId; ?> - Quantità: <?php echo $quantity; ?>
                <form method="post" action="?page=cart&action=remove&id=<?php echo $productId; ?>" style="display:inline;">
                    <button type="submit">Rimuovi</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php if (isset($_SESSION['coupon'])): ?>
        <p>Coupon applicato: <?php echo htmlspecialchars($_SESSION['coupon']['code']); ?> - Sconto: <?php echo $_SESSION['coupon']['discount']; ?>%</p>
        <form method="post" action="?page=coupon&action=remove">
            <button type="submit">Rimuovi coupon</button>
        </form>
    <?php else: ?>
        <form method="post" action="?page=coupon&action=apply">
            <input type="text" name="code" placeholder="Codice coupon" required>
            <button type="submit">Applica coupon</button>
        </form>
    <?php endif; ?>
    <form method="post" action="?page=cart&action=clear">
        <button type="submit">Svuota carrello</button>
    </form>
    <form method="post" action="?page=orders&action=create">
        <button type="submit">Conferma ordine</button>
    </form>
    <a href="?page=products">Torna ai prodotti</a>
</body>
</html>