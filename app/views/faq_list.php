<!DOCTYPE html>
<html>
<head><title>FAQ</title></head>
<body>
    <h1>Domande Frequenti</h1>
    <a href="/?controller=FAQ&action=create">Aggiungi FAQ</a>
    <ul>
        <?php foreach ($faqs as $faq) { ?>
            <li><strong><?= $faq['question'] ?></strong>: <?= $faq['answer'] ?></li>
        <?php } ?>
    </ul>
</body>
</html>