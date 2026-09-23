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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div class="logo">Gym Tech - <span>Area do Professor</span></div>
        <div>
            <a href="logout.php" class="link-login">Sair, <?php echo htmlspecialchars($_SESSION['usuario_tipo']); ?></a>
        </div>
    </nav>
</body>
</html>