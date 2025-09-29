
<!DOCTYPE html>
<html>
<head>
    <title>Gestione Inventario</title>
</head>
<body>
    <h1>Inventario Prodotti</h1>
    <table border="1">
        <tr>
            <th>Prodotto</th>
            <th>Quantità disponibile</th>
            <th>Azione</th>
        </tr>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo $item['quantity'] ?? 0; ?></td>
                <td>
                    <form method="post" action="?page=inventory&action=update&id=<?php echo $item['id']; ?>">
                        <input type="number" name="quantity" min="0" value="<?php echo $item['quantity'] ?? 0; ?>" required>
                        <button type="submit">Aggiorna</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="?page=admin">Torna alla dashboard admin</a>
</body>
</html>