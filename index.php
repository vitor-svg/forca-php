<?php
session_start();


$listaPalavras = ["CASA", "DESENVOLVIMENTO", "PROGRAMACAO", "ESTUDANTE", "INTERNET", "CODIGO", "PHP", "JAVASCRIPT"];

// Reinicia a sessão se o usuário clicar em "Nova Partida"
if (isset($_POST['reiniciar'])) {
    session_unset();
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Inicializa as variáveis do jogo na sessão
if (!isset($_SESSION["palavra_secreta"])) {
    $indiceAleatorio = array_rand($listaPalavras);
    $_SESSION["palavra_secreta"] = strtoupper($listaPalavras[$indiceAleatorio]);
    $_SESSION["letrasCorretas"] = [];
    $_SESSION["erros"] = 0;
    $_SESSION["status"] = "JOGANDO"; 
}

$palavraSecreta = $_SESSION["palavra_secreta"];

// Processa a letra enviada via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["letra"]) && $_SESSION["status"] == "JOGANDO") {
    $letra = strtoupper(trim($_POST["letra"]));

    if (!empty($letra)) {
        if (strpos($palavraSecreta, $letra) !== false) {
            if (!in_array($letra, $_SESSION["letrasCorretas"])) {
                $_SESSION["letrasCorretas"][] = $letra;
            }
        } else {
            $_SESSION["erros"]++;
        }
    }
}

// Monta o visual da palavra (_ _ _ _)
$palavraExibida = "";
$ganhou = true;

for ($i = 0; $i < strlen($palavraSecreta); $i++) {
    $letraAtual = $palavraSecreta[$i];
    if (in_array($letraAtual, $_SESSION["letrasCorretas"])) {
        $palavraExibida .= $letraAtual . " ";
    } else {
        $palavraExibida .= "_ ";
        $ganhou = false;
    }
}

// Verifica se o jogo acabou
if ($_SESSION["erros"] >= 6) {
    $_SESSION["status"] = "PERDEU";
    $palavraExibida = "";
    for ($i = 0; $i < strlen($palavraSecreta); $i++) {
        $palavraExibida .= $palavraSecreta[$i] . " ";
    }
} elseif ($ganhou) {
    $_SESSION["status"] = "GANHOU";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo da Forca</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="card">
        <h1>Jogo da Forca</h1>

        <div class="palavra"><?php echo trim($palavraExibida); ?></div>

        <div class="erros">Erros: <?php echo $_SESSION["erros"]; ?>/6</div>

        <form method="POST" autocomplete="off">
            
            <?php if ($_SESSION["status"] == "JOGANDO"): ?>
                <input
                    type="text"
                    name="letra"
                    placeholder="Digite uma letra"
                    maxlength="1"
                    required
                    autofocus
                >
            <?php endif; ?>

            <div class="botoes-container">
                <?php if ($_SESSION["status"] == "JOGANDO"): ?>
                    <button type="submit">Enviar</button>
                <?php endif; ?>
                
                <button type="submit" name="reiniciar" value="1">Nova Partida</button>
            </div>
        </form>

        <?php if ($_SESSION["status"] == "PERDEU"): ?>
            <div class="status-mensagem perdeu">💀 Você perdeu!</div>
        <?php elseif ($_SESSION["status"] == "GANHOU"): ?>
            <div class="status-mensagem ganhou">🎉 Parabéns, você ganhou!</div>
        <?php endif; ?>
    </div>

</body>
</html>