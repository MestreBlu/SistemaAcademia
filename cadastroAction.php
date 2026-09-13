<?php
// Inclui o arquivo de conexão com o banco de dados
require_once 'conexao.php';

$mensagem_titulo = "";
$mensagem_corpo = "";
$status_sucesso = false;

// Verifica se os dados foram enviados através do método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Resgate dos campos do formulário
    $nome            = $_POST['nome'] ?? '';
    $email           = $_POST['email'] ?? '';
    $telefone        = $_POST['telefone'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    $cpf             = $_POST['cpf'] ?? '';
    $endereco        = $_POST['endereco'] ?? '';
    $objetivo        = $_POST['objetivo'] ?? '';
    $plano           = $_POST['plano'] ?? '';
    $celular         = $_POST['celular'] ?? '';
    $peso_atual      = !empty($_POST['peso_atual']) ? $_POST['peso_atual'] : null;
    $altura          = !empty($_POST['altura'])     ? $_POST['altura']     : null;

    // 2. Instrução SQL com todos os campos
    $sql = "INSERT INTO aluno (
                nome, 
                email,
                altura, 
                telefone, 
                celular, 
                data_nascimento, 
                cpf, 
                endereco, 
                objetivo, 
                plano, 
                peso_atual, 
                data_cadastro
            ) VALUES (
                :nome, 
                :email,
                :altura,  
                :telefone, 
                :celular, 
                :data_nascimento, 
                :cpf, 
                :endereco, 
                :objetivo, 
                :plano, 
                :peso_atual, 
                CURDATE()
            )";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':altura', $altura);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':objetivo', $objetivo);
        $stmt->bindParam(':plano', $plano);
        $stmt->bindParam(':peso_atual', $peso_atual);

        $stmt->execute();

        $status_sucesso = true;
        $mensagem_titulo = "Matrícula Efetivada!";
        $mensagem_corpo = "O aluno <strong>" . htmlspecialchars($nome) . "</strong> foi cadastrado com sucesso no sistema.";
    } catch (PDOException $e) {
        $status_sucesso = false;
        $mensagem_titulo = "Erro ao Cadastrar";

        if ($e->getCode() == 23000) {
            $mensagem_corpo = "O CPF ou E-mail digitado já está cadastrado no sistema.";
        } else {
            $mensagem_corpo = "Ocorreu um erro no banco de dados: " . htmlspecialchars($e->getMessage());
        }
    }
} else {
    header('Location: cadastro.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Tech - Status do Cadastro</title>
    <!-- Vincula o arquivo CSS compartilhado -->
    <link rel="stylesheet" href="style.css">
    <style>
        /* Ajuste fino de layout exclusivo para centralização do card de resposta */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card-resposta {
            text-align: center;
            margin-bottom: 0;
        }

        .card-resposta h2 {
            color: <?php echo $status_sucesso ? 'var(--sucesso)' : 'var(--erro)'; ?>;
        }

        .card-resposta p {
            color: var(--texto-mutado);
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .btn-voltar {
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>

<body>

    <div class="container-cadastro card-resposta">
        <h2><?php echo $mensagem_titulo; ?></h2>
        <p><?php echo $mensagem_corpo; ?></p>
        <a href="cadastro.php" class="button btn-secundario btn-voltar">Voltar ao Formulário</a>
    </div>

</body>

</html>