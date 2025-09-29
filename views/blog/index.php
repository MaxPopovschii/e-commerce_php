
<!DOCTYPE html>
<html>
<head>
    <title>Blog & News</title>
</head>
<body>
    <h1>Articoli e Novità</h1>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
                <a href="?page=blog&id=<?php echo $post['id']; ?>">
                    <?php echo htmlspecialchars($post['title']); ?>
                </a>
                <br>
                <small>Pubblicato da <?php echo htmlspecialchars($post['author']); ?> il <?php echo $post['created_at']; ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="?page=products">Torna al negozio</a>
</body>
</html>