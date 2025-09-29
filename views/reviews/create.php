
<!DOCTYPE html>
<html>
<head>
    <title>Aggiungi recensione</title>
</head>
<body>
    <h2>Lascia una recensione</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <label>Voto (1-5): <input type="number" name="rating" min="1" max="5" required></label><br>
        <label>Commento:<br>
            <textarea name="comment" required></textarea>
        </label><br>
        <button type="submit">Invia</button>
    </form>
    <a href="?page=reviews&product_id=<?php echo $_GET['product_id']; ?>">Torna alle recensioni</a>
</body>
</html>