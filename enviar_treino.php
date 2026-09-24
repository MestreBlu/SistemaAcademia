<?php
session_start();

$perfisAutorizados = ['professor', 'adm'];

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_tipo'], $perfisAutorizados)) {
    header('Location: login.php?erro=acesso_negado');
    exit;
}

require_once 'conexao.php';

$mensagemSucesso = '';
$mensagemErro = '';

// Recebe o ID do aluno via GET
$alunoId = $_GET['aluno_id'] ?? null;

if (!$alunoId) {
    header('Location: painel_professor.php'); // Redireciona se nenhum ID for informado
    exit;
}

// 1. Busca as informações do aluno no banco de dados
try {
    $sql = "SELECT id_aluno, nome, cpf, email, objetivo, peso_atual, altura FROM aluno WHERE id_aluno = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $alunoId, PDO::PARAM_INT);
    $stmt->execute();
    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$aluno) {
        die("Aluno não encontrado.");
    }
} catch (PDOException $e) {
    die("Erro ao buscar dados do aluno: " . $e->getMessage());
}

// 2. Processa o envio do formulário quando for enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $assunto = trim($_POST['assunto'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    if (empty($assunto) || empty($mensagem)) {
        $mensagemErro = "Preencha todos os campos do formulário.";
    } else {
        // Configuração do cabeçalho do e-mail
        $to = $aluno['email'];
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Gym Tech <no-reply@gymtech.com>" . "\r\n";

        // Formatação do corpo do e-mail
        $corpoEmail = "
        <html>
        <head>
            <title>{$assunto}</title>
        </head>
        <body>
            <h3>Olá, " . htmlspecialchars($aluno['nome']) . "!</h3>
            <p>" . nl2br(htmlspecialchars($mensagem)) . "</p>
            <br>
            <p>Atenciosamente,<br>Equipe Gym Tech</p>
        </body>
        </html>
        ";

        // Dispara o e-mail usando a função nativa do PHP
        if (mail($to, $assunto, $corpoEmail, $headers)) {
            $mensagemSucesso = "E-mail enviado com sucesso para " . htmlspecialchars($aluno['email']) . "!";
        } else {
            $mensagemErro = "Falha ao enviar o e-mail. Verifique as configurações de SMTP do seu servidor.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Tech - Enviar Treino</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            padding:  15px;
        }

        .layout-container {
            display: flex;
            gap: 30px;
            align-items: flex-start;
            width: 100%;
        }

        .coluna-esquerda,
        .coluna-holograma {
            flex: 1; /* Divisão 50% / 50% */
            box-sizing: border-box;
        }

        /* Estilo do painel do holograma */
        .coluna-holograma {
            background: #0f172a;
            color: #fff;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #1e293b;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .conteudo-holograma {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 15px;
        }

        .holograma-img {
            width: 45%;
            max-width: 180px;
            height: auto;
            border-radius: 8px;
            filter: drop-shadow(0 0 10px rgba(56, 189, 248, 0.5));
        }

        .metricas-aluno {
            flex: 1;
            background: #1e293b;
            padding: 15px;
            border-radius: 8px;
            text-align: left;
        }

        .metricas-aluno p {
            margin: 12px 0;
            font-size: 15px;
            line-height: 1.4;
        }

        .metricas-aluno strong {
            color: #38bdf8;
            display: block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cpf-tag {
            font-size: 0.85em;
            color: #64748b;
            font-weight: normal;
        }
    </style>
</head>

<body>
    <nav>
        <div class="logo">Gym Tech - <span>Enviar Treino</span></div>
        <div>
            <a href="painel_professor.php" class="link-login">Voltar</a>
        </div>
    </nav>

    <main class="container">
        <div class="layout-container">
            <!-- Coluna Esquerda (50%): Título, E-mail e Formulário -->
            <div class="coluna-esquerda">
                <h2>
                    Enviar treino para: <?php echo htmlspecialchars($aluno['nome']); ?> 
                    <span class="cpf-tag">(CPF: <?php echo htmlspecialchars($aluno['cpf'] ?? 'Não informado'); ?>)</span>
                </h2>
                <p><strong>E-mail de destino:</strong> <?php echo htmlspecialchars($aluno['email']); ?></p>

                <?php if (!empty($mensagemSucesso)): ?>
                    <p class="mensagem-sucesso" style="color: green;"><?php echo $mensagemSucesso; ?></p>
                <?php endif; ?>

                <?php if (!empty($mensagemErro)): ?>
                    <p class="mensagem-erro" style="color: red;"><?php echo $mensagemErro; ?></p>
                <?php endif; ?>

                <form action="" method="POST" class="form-email">
                    <div class="campo">
                        <label for="assunto">Assunto:</label>
                        <input type="text" id="assunto" name="assunto" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>

                    <br>

                    <div class="campo">
                        <label for="mensagem">Mensagem:</label>
                        <textarea id="mensagem" name="mensagem" rows="10" required style="width: 100%; padding: 8px; box-sizing: border-box;"></textarea>
                    </div>

                    <br>

                    <button type="submit" class="btn" style="width: auto;">Enviar Treino</button> <br><br>
                    <a href="painel_professor.php" class="btn-cancelar" style="padding: 6px 12px; font-size: 14px; display: inline-block;">Cancelar</a>
                </form>
            </div>

            <!-- Coluna Direita (50%): Holograma alinhado ao topo do .container -->
            <div class="coluna-holograma">
                <h3 style="margin-top: 0; color: #38bdf8;">Análise Corporal</h3>

                <div class="conteudo-holograma">
                    <img src="holograma.jpg" alt="Holograma Corporal Humano" class="holograma-img">

                    <div class="metricas-aluno">
                        <p><strong>Altura</strong> <?php echo htmlspecialchars($aluno['altura'] ?? 'N/A'); ?> m</p>
                        <p><strong>Peso Atual</strong> <?php echo htmlspecialchars($aluno['peso_atual'] ?? 'N/A'); ?> kg</p>
                        <p><strong>Objetivo</strong> <?php echo htmlspecialchars($aluno['objetivo'] ?? 'Não especificado'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>