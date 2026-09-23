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
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0f0f1e;
            color: #eae6f5;
            min-height: 100vh;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 28px;
            background: #18162b;
            border-bottom: 1px solid rgba(168, 85, 247, 0.35);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.3rem;
            font-weight: 700;
            color: #fff;
        }

        .logo img { height: 38px; }

        .logo span { color: #a855f7; }

        .link-login {
            color: #c9c4e0;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .link-login:hover { color: #a855f7; }

        .menu-painel {
            max-width: 720px;
            margin: 40px auto 0;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .menu-painel a {
            display: block;
            padding: 22px 24px;
            background: #1f1c3a;
            color: #eae6f5;
            text-decoration: none;
            border-radius: 10px;
            border: 1px solid rgba(168, 85, 247, 0.25);
            font-weight: 600;
            text-align: center;
            transition: all 0.2s ease;
        }

        .menu-painel a:hover {
            background: #a855f7;
            color: #fff;
            border-color: #a855f7;
            transform: translateY(-2px);
        }
    </style>
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