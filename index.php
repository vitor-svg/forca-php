<?php

$palavra = "CASA";
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $letra = strtoupper($_POST["letra"]);

    if (strpos($palavra, $letra) !== false) {
        $mensagem = "A letra existe na palavra!";
    } else {
        $mensagem = "A letra não existe na palavra!";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Jogo da Forca PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Jogo da Forca - PHP</h1>

    <form method="POST">

        <input
            type="text"
            name="letra"
            maxlength="1"
            required
        >

        <button type="submit">
            Enviar
        </button>

    </form>

    <p>
        <?php echo $mensagem; ?>
    </p>

</body>
</html>