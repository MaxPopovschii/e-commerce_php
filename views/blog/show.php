
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($post['title']); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    <small>Pubblicato da <?php echo htmlspecialchars($post['author']); ?> il <?php echo $post['created_at']; ?></small>
    <br>
    <a href="?page=blog">Torna al blog</a>
</body>
</html>