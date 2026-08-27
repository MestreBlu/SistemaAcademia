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
    $senha_pura      = $_POST['senha'] ?? '';
    $telefone        = $_POST['telefone'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    $cpf             = $_POST['cpf'] ?? '';
    $endereco        = $_POST['endereco'] ?? '';
    $objetivo        = $_POST['objetivo'] ?? '';
    $plano           = $_POST['plano'] ?? '';
    $peso_atual      = !empty($_POST['peso_atual']) ? $_POST['peso_atual'] : null;
    $celular         = $_POST['celular'] ?? '';

    // 2. Criptografia de segurança para a senha do aluno
    $senha_hash = password_hash($senha_pura, PASSWORD_DEFAULT);

    // 3. Instrução SQL com todos os campos
    $sql = "INSERT INTO aluno (
                nome, 
                email, 
                senha, 
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
                :senha, 
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
        $stmt->bindParam(':senha', $senha_hash);
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
    <style>
        :root {
            --bg-principal: #09090d;
            /* Fundo geral da página */
            --bg-card: #13131a;
            /* Fundo do card */
            --roxo-neon: #a046ff;
            /* Roxo vivo para contraste */
            --roxo-botao: #8a2be2;
            /* Roxo sólido para botões */
            --roxo-hover: #6a1b9a;
            /* Roxo ao passar o mouse */
            --texto-claro: #ffffff;
            /* Títulos e textos principais */
            --texto-mutado: #b3b3c2;
            /* Texto de apoio */
            --borda: #222232;
            /* Linhas divisórias */
            --erro: #ff4d4d;
            /* Cor para mensagens de erro */
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-principal);
            color: var(--texto-claro);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card-resposta {
            max-width: 480px;
            width: 90%;
            background-color: var(--bg-card);
            border: 1px solid var(--borda);
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(138, 43, 226, 0.1);
        }

        .card-resposta h2 {
            font-size: 26px;
            margin-top: 0;
            margin-bottom: 15px;
            color: <?php echo $status_sucesso ? 'var(--roxo-neon)' : 'var(--erro)'; ?>;
        }

        .card-resposta p {
            color: var(--texto-mutado);
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .card-resposta p strong {
            color: var(--texto-claro);
        }

        .btn-voltar {
            display: inline-block;
            width: 100%;
            padding: 14px;
            background-color: var(--roxo-botao);
            color: var(--texto-claro);
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
            box-sizing: border-box;
        }

        .btn-voltar:hover {
            background-color: var(--roxo-hover);
        }
    </style>
</head>

<body>

    <div class="card-resposta">
        <h2><?php echo $mensagem_titulo; ?></h2>
        <p><?php echo $mensagem_corpo; ?></p>
        <a href="cadastro.php" class="btn-voltar">Voltar ao Formulário</a>
    </div>

</body>

</html>