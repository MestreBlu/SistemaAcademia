<?php
session_start();

// Perfis autorizados nesta página
$perfisAutorizados = ['professor', 'adm'];

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_tipo'], $perfisAutorizados)) {
    header('Location: login.php?erro=acesso_negado');
    exit;
}

// 1. Inclui o arquivo de conexão com o banco de dados
require_once 'conexao.php';

// 2. Consulta para buscar a lista de alunos
try {
    
    $sql = "SELECT id_aluno, nome, cpf, email FROM aluno ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $alunos = [];
    $erro = "Erro ao carregar a lista de alunos: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Tech - Painel Professor</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav>
        <div class="logo">Gym Tech - <span>Área do Professor</span></div>
        <div>
            <a href="logout.php" class="link-login">Sair, <?php echo htmlspecialchars($_SESSION['usuario_tipo']); ?></a>
        </div>
    </nav>

    <main class="container">
        <h2>Lista de Alunos</h2>

        <?php if (isset($erro)): ?>
            <p class="mensagem-erro"><?php echo $erro; ?></p>
        <?php endif; ?>

        <?php if (empty($alunos)): ?>
            <p>Nenhum aluno encontrado.</p>
        <?php else: ?>
            <table class="tabela-alunos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>E-mail</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($aluno['id_aluno']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                            <td><?php echo htmlspecialchars($aluno['cpf'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($aluno['email']); ?></td>
                            <td>
                                <a href="enviar_treino.php?aluno_id=<?php echo $aluno['id_aluno']; ?>" class="btn">Enviar Treino</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>

</html>