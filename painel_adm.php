<?php
session_start();

// Perfis autorizados nesta página
$perfisAutorizados = ['adm'];

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_tipo'], $perfisAutorizados)) {
    header('Location: login.php?erro=acesso_negado');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Tech - Painel Adm</title>
    <link rel="stylesheet" href="painel.css">
</head>
<body>
    <nav>
        <div class="logo">
            <img src="logo_da_Gym_Tech.png" alt="Gym Tech">
            <span>Painel ADM</span>
        </div>
        <a href="logout.php" class="link-login">Sair, <?php echo htmlspecialchars($_SESSION['usuario_tipo']); ?></a>
    </nav>

    <div class="menu-painel">
        <a href="painel_professor.php">👨‍🏫 Painel do Professor</a>
        <a href="painel_recepcao.php">🛎️ Painel da Recepção</a>
        <a href="cadastro.html">📝 Cadastrar Aluno</a>
        <a href="atualizar.html">✏️ Atualizar Aluno</a>
        <a href="remover.html">🗑️ Remover Aluno</a>
    </div>
</body>
</html>