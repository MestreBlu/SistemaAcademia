<?php
session_start();

// Perfis autorizados nesta página
$perfisAutorizados = ['recepcionista', 'adm'];

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
  <title>Gym Tech - Remover Aluno</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav>
    <div class="logo">Gym Tech</div>
    <a href="logout.php" class="link-login">Sair, <?php echo htmlspecialchars($_SESSION['usuario_tipo']); ?></a>
  </nav>

  <div class="container-cadastro">
    <h2>Remover Cadastro de Aluno</h2>
    <div class="instrucao">Busque o aluno e confirme a exclusão do registro.</div>

    <!-- Busca -->
    <form action="remover.php" method="GET">
      <div class="grupo-campo">
        <label>Buscar por CPF ou E-mail</label>
        <input type="text" name="busca" placeholder="000.000.000-00 ou nome@provedor.com" required>
      </div>
      <button type="submit">Buscar Aluno</button>
    </form>

    <!-- Resultado da busca (backend preenche) -->
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
        <tr>
          <td>—</td>
          <td>—</td>
          <td>—</td>
          <td>—</td>
          <td>
            <form action="removerAction.php" method="POST"
                  onsubmit="return confirm('Tem certeza que deseja remover este aluno? Esta ação não pode ser desfeita.');">
              <input type="hidden" name="id" value="">
              <button type="submit" class="btn-perigo">Remover</button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>