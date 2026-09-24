<?php

session_start();

// Perfis autorizados nesta página
$perfisAutorizados = ['recepcionista', 'adm'];

// Verifica se o usuário está logado e possui permissão
if (
    !isset($_SESSION['usuario_id']) ||
    !isset($_SESSION['usuario_tipo']) ||
    !in_array($_SESSION['usuario_tipo'], $perfisAutorizados, true)
) {
    header('Location: login.php?erro=acesso_negado');
    exit;
}

// Inclui a conexão com o banco
require_once 'conexao.php';

// Garante que os erros do PDO sejam tratados como exceções
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Variáveis
$aluno = null;
$erro = null;
$sucesso = null;

// Recebe a busca
$busca = trim($_GET['busca'] ?? '');

// Mensagens vindas do removerAction.php
if (isset($_GET['sucesso'])) {
    $sucesso = 'Cadastro do aluno removido com sucesso.';
}

if (isset($_GET['erro'])) {

    switch ($_GET['erro']) {

        case 'id_invalido':
            $erro = 'Identificação do aluno inválida.';
            break;

        case 'aluno_nao_encontrado':
            $erro = 'O aluno não foi encontrado no banco de dados.';
            break;

        case 'nao_removido':
            $erro = 'O aluno não foi removido. Nenhum registro foi alterado.';
            break;

        case 'dependencia':
            $erro = 'Não foi possível remover o aluno porque existem outros registros relacionados a ele no banco de dados.';
            break;

        case 'banco':
            $erro = 'Ocorreu um erro ao tentar remover o aluno. Verifique a estrutura do banco de dados.';
            break;

        default:
            $erro = 'Ocorreu um erro ao realizar a operação.';
            break;
    }
}


// ==========================================================
// BUSCA DO ALUNO
// ==========================================================

if ($busca !== '') {

    // Remove tudo que não for número.
    // Exemplo:
    // 123.456.789-00 -> 12345678900
    $cpfBusca = preg_replace('/\D/', '', $busca);

    try {

        /*
         * A busca funciona tanto se o CPF estiver armazenado:
         *
         * 12345678900
         *
         * quanto:
         *
         * 123.456.789-00
         *
         * Também permite buscar normalmente pelo e-mail.
         */

        $sql = "SELECT
                    id_aluno,
                    nome,
                    email,
                    cpf,
                    plano
                FROM aluno
                WHERE
                    (
                        REPLACE(
                            REPLACE(
                                REPLACE(cpf, '.', ''),
                                '-', ''
                            ),
                            ' ',
                            ''
                        ) = :cpf
                    )
                    OR LOWER(TRIM(email)) = LOWER(TRIM(:email))
                LIMIT 1";

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(
            ':cpf',
            $cpfBusca,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':email',
            $busca,
            PDO::PARAM_STR
        );

        $stmt->execute();

        $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$aluno) {
            $erro = 'Aluno não encontrado.';
        }
    } catch (PDOException $e) {

        // Não mostra detalhes internos do banco para o usuário
        $erro = 'Ocorreu um erro ao realizar a busca.';
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gym Tech - Remover Aluno</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <nav>

        <div class="logo">
            Gym Tech
        </div>

        <a href="logout.php" class="link-login">
            Sair, <?php echo htmlspecialchars($_SESSION['usuario_tipo']); ?>
        </a>

    </nav>


    <div class="container-cadastro">

        <h2>Remover Cadastro de Aluno</h2>

        <div class="instrucao">
            Busque o aluno e confirme a exclusão do registro.
        </div>


        <!-- ==================================================
             MENSAGEM DE SUCESSO
        =================================================== -->

        <?php if ($sucesso !== null): ?>

            <div class="mensagem-sucesso">
                <?php echo htmlspecialchars($sucesso); ?>
            </div>

        <?php endif; ?>


        <!-- ==================================================
             MENSAGEM DE ERRO
        =================================================== -->

        <?php if ($erro !== null): ?>

            <div class="mensagem-erro">
                <?php echo htmlspecialchars($erro); ?>
            </div>

        <?php endif; ?>


        <!-- ==================================================
             FORMULÁRIO DE BUSCA
        =================================================== -->

        <form action="remover.php" method="GET">

            <div class="grupo-campo">

                <label for="busca">
                    Buscar por CPF ou E-mail
                </label>

                <input
                    type="text"
                    id="busca"
                    name="busca"
                    value="<?php echo htmlspecialchars($busca); ?>"
                    placeholder="000.000.000-00 ou nome@provedor.com"
                    required>

            </div>

            <button type="submit">
                Buscar Aluno
            </button>

        </form>


        <!-- ==================================================
             RESULTADO DA BUSCA
        =================================================== -->

        <table class="tabela-alunos">

            <thead>

                <tr>

                    <th>Nome</th>

                    <th>E-mail</th>

                    <th>CPF</th>

                    <th>Plano</th>

                    <th>Ação</th>

                </tr>

            </thead>

            <tbody>

                <?php if ($aluno): ?>

                    <tr>

                        <td>
                            <?php echo htmlspecialchars($aluno['nome']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($aluno['email']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($aluno['cpf']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($aluno['plano']); ?>
                        </td>

                        <td>

                            <form
                                action="removerAction.php"
                                method="POST"
                                onsubmit="return confirm('Tem certeza que deseja remover este aluno? Esta ação não pode ser desfeita.');">

                                <input
                                    type="hidden"
                                    name="id_aluno"
                                    value="<?php echo (int) $aluno['id_aluno']; ?>">

                                <button
                                    type="submit"
                                    class="btn-perigo">
                                    Remover
                                </button>

                            </form>

                        </td>

                    </tr>

                <?php elseif ($busca === '' && $sucesso === null): ?>

                    <tr>

                        <td colspan="5">
                            Digite um CPF ou E-mail para buscar um aluno.
                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</body>

</html>