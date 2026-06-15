<?php

session_start();

$palavra = "CASA";
$mensagem = "";

// Inicializa as letras corretas na sessão
if (!isset($_SESSION["letrasCorretas"])) {
    $_SESSION["letrasCorretas"] = [];
}

// Inicializa os erros na sessão
if (!isset($_SESSION["erros"])) {
    $_SESSION["erros"] = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $letra = strtoupper($_POST["letra"]);

    if (strpos($palavra, $letra) !== false) {

        if (!in_array($letra, $_SESSION["letrasCorretas"])) {
            $_SESSION["letrasCorretas"][] = $letra;
        }

        $mensagem = "Você acertou uma letra!";

    } else {

        $_SESSION["erros"]++;

        $mensagem = "A letra não existe na palavra!";
    }
}

// Monta a palavra exibida
$palavraExibida = "";

for ($i = 0; $i < strlen($palavra); $i++) {

    if (in_array($palavra[$i], $_SESSION["letrasCorretas"])) {
        $palavraExibida .= $palavra[$i] . " ";
    } else {
        $palavraExibida .= "_ ";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Jogo da Forca - PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Jogo da Forca - PHP</h1>

    <h2><?php echo $palavraExibida; ?></h2>

    <p>Erros: <?php echo $_SESSION["erros"]; ?>/6</p>

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

    <p><?php echo $mensagem; ?></p>

</body>
</html>