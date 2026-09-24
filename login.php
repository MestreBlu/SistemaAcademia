<?php
// Lê o parâmetro de erro enviado pelo loginAction.php
$erro = $_GET['erro'] ?? '';
$mensagemErro = '';

switch ($erro) {
    case 'invalido':
        $mensagemErro = 'Usuário ou senha inválidos. Verifique suas credenciais e tente novamente.';
        break;
    case 'campos_vazios':
        $mensagemErro = 'Preencha todos os campos para entrar.';
        break;
    case 'acesso_negado':
        $mensagemErro = 'Acesso negado. Faça login com uma conta autorizada.';
        break;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gym Tech - Login</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .alerta-erro {
      background: #2a1420;
      border: 1px solid rgba(248, 113, 113, 0.5);
      color: #fca5a5;
      padding: 12px 14px;
      border-radius: 8px;
      margin-bottom: 16px;
      font-size: 0.9rem;
      text-align: center;
    }
  </style>
</head>
<body>
  <nav>
    <div class="logo">Gym Tech</div>
  </nav>

  <div class="card-login">
    <div class="logo-login">Gym <span>Tech</span></div>
    <div class="instrucao">Acesse o painel administrativo com suas credenciais.</div>

    <?php if ($mensagemErro !== ''): ?>
      <div class="alerta-erro"><?php echo htmlspecialchars($mensagemErro); ?></div>
    <?php endif; ?>

    <form action="loginAction.php" method="POST">
      <div class="grupo-campo">
        <label>Usuário *</label>
        <input type="text" name="usuario" required placeholder="seu usuário">
      </div>
      <div class="grupo-campo">
        <label>Senha *</label>
        <input type="password" name="senha" required placeholder="Sua senha de acesso">
      </div>
      <button type="submit">Entrar no Sistema</button>
    </form>
  </div>
</body>
</html>