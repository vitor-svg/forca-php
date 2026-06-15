Como o foco do trabalho era criar o jogo sem banco de dados e com uma arquitetura voltada para produção, utilizei apenas recursos nativos das seguintes tecnologias:

PHP: Utilizado no lado do servidor (Backend) para processar a lógica do jogo (verificar se a letra está certa ou errada, contar os erros e controlar o fluxo de vitória ou derrota).

Sessões do PHP ($_SESSION): O recurso mais importante do projeto. Como não podíamos usar banco de dados, a sessão foi utilizada para salvar o estado do jogo (a palavra que foi sorteada, as letras que o usuário já acertou e a quantidade de erros) na memória do servidor entre os cliques do usuário.

Arrays em PHP: Criei uma lista de palavras (um vetor) direto no código fonte. Ele funcionou como o nosso "banco de dados em memória", permitindo que o jogo escolha palavras aleatórias a cada nova partida.

HTML: Utilizado para estruturar a interface gráfica (o título, a exibição dos tracinhos da palavra, o contador de erros e o formulário com o campo de texto e os botões).

CSS (Separado): Utilizado em um arquivo exclusivo (style.css) para criar a estilização visual moderna no estilo Card (caixa centralizada com sombra e cantos arredondados), deixando o visual idêntico à sua versão em JavaScript.

Git & GitHub: Ferramentas de versionamento utilizadas para criar o repositório, salvar o histórico de alterações e subir o código para a nuvem.

 Passo a Passo do que foi Feito no Código
O fluxo do sistema foi construído seguindo estes passos lógicos no arquivo index.php e style.css:

1. Inicialização do Ambiente e do Jogo
O código PHP inicia chamando a função session_start(), que abre o espaço de memória da sessão para aquele usuário.

O sistema verifica se o jogo está começando agora. Se estiver, ele usa a função array_rand() para escolher sortear uma palavra aleatória da nossa lista de palavras.

Essa palavra sorteada, junto com um contador de erros zerado e uma lista vazia de letras acertadas, é gravada na sessão ($_SESSION). Isso garante que, quando a página recarregar, o PHP lembre de qual palavra estávamos jogando.

2. Processamento da Jogada (Envio do Formulário)
Quando o usuário digita uma letra no campo de texto e clica em "Enviar", o navegador dispara uma requisição do tipo POST para o servidor.

O PHP recebe essa letra e usa a função strtoupper() para transformá-la em maiúscula (evitando que o jogo diferencie "a" de "A").

O sistema verifica se a letra existe dentro da palavra secreta usando a função strpos().

Se existir: A letra é adicionada à lista de letras corretas na sessão.

Se não existir: O contador de erros na sessão é aumentado em 1 ($_SESSION["erros"]++).

3. Montagem Visual da Palavra e Verificação de Fim de Jogo
O PHP roda um laço de repetição (for) que passa por cada letra da palavra secreta. Se a letra já foi acertada pelo usuário, ela é exibida na tela; se não, o código exibe um sinal de underline (_).

O código checa se o contador de erros chegou a 6. Se chegou, o status muda para "PERDEU" e a palavra real é revelada na tela. Se o usuário preencheu todos os underlines corretamente, o status muda para "GANHOU".

Se o usuário clicar no botão "Nova Partida", o PHP executa session_destroy(), limpando toda a memória da sessão e forçando o jogo a reiniciar com uma nova palavra no próximo carregamento.

4. Separação da Estilização
Toda a parte visual de cores, fontes, posicionamento dos botões, sombras do card e responsividade foi removida de dentro do arquivo PHP e isolada no arquivo style.css.

No index.php, adicionamos apenas a tag <link rel="stylesheet" href="style.css"> para conectar os dois arquivos. Isso deixa o código backend limpo e focado apenas nas regras do jogo.

5. Versionamento Semântico no Git
Em vez de fazer um único commit com tudo jogado, as entregas foram divididas de forma lógica.

Utilizamos o padrão Conventional Commits (ex: feat: para novas funções e refactor: para a separação do CSS), simulando exatamente o comportamento de uma equipe de desenvolvimento que trabalha com atualizações de produção de software.