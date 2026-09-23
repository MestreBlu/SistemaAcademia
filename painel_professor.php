<?php
session_start();

// Perfis autorizados nesta página
$perfisAutorizados = ['professor', 'adm'];

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
    <title>Gym Tech - Painel Professor</title>
    <link rel="stylesheet" href="painel.css">
</head>
<body>
    <nav>
        <div class="logo">
            <img src="logo_da_Gym_Tech.png" alt="Gym Tech">
            <span>Área do Professor</span>
        </div>
        <a href="logout.php" class="link-login">Sair, <?php echo htmlspecialchars($_SESSION['usuario_tipo']); ?></a>
    </nav>

    <div class="menu-painel">
        <a href="cadastro.html">📝 Cadastrar Aluno</a>
        <a href="atualizar.html">✏️ Atualizar Aluno</a>
        <a href="remover.html">🗑️ Remover Aluno</a>
        <?php if ($_SESSION['usuario_tipo'] === 'adm'): ?>
            <a href="painel_adm.php">⬅️ Voltar ao Painel ADM</a>
        <?php endif; ?>
    </div>
</body>
</html>