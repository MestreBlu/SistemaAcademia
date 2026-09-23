<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gym Tech - Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav>
    <div class="logo">Gym Tech</div>
  </nav>

  <div class="card-login">
    <div class="logo-login">Gym <span>Tech</span></div>
    <div class="instrucao">Acesse o painel administrativo com suas credenciais.</div>

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