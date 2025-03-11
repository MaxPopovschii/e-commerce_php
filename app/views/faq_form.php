<!DOCTYPE html>
<html>
<head><title>Aggiungi FAQ</title></head>
<body>
    <h1>Aggiungi Domanda</h1>
    <form action="/?controller=FAQ&action=store" method="post">
        <label>Domanda: <input type="text" name="question" required></label><br>
        <label>Risposta: <textarea name="answer" required></textarea></label><br>
        <button type="submit">Salva</button>
    </form>
</body>
</html>