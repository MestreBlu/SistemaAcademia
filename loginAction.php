<?php
session_start();
require_once 'conexao.php';

// Verifica se os campos foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($usuario) || empty($senha)) {
        header('Location: login.php?erro=campos_vazios');
        exit;
    }

    try {
        // Busca o usuário no banco de dados
        $stmt = $pdo->prepare("SELECT id_usuario, usuario, senha, tipo FROM usuario WHERE usuario = :usuario");
        $stmt->bindValue(':usuario', $usuario);
        $stmt->execute();

        $dadosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e se a senha está correta
        if ($dadosUsuario && $senha === $dadosUsuario['senha']) {
            
            // Regenera o ID da sessão por segurança contra Session Fixation
            session_regenerate_id(true);

            // Armazena os dados do usuário na sessão
            $_SESSION['usuario_id'] = $dadosUsuario['id_usuario'];
            $_SESSION['usuario_nome'] = $dadosUsuario['usuario'];
            $_SESSION['usuario_tipo'] = $dadosUsuario['tipo'];

            // Redireciona de acordo com o tipo de usuário ou para um painel geral
            if ($dadosUsuario['tipo'] === 'recepcionista') {
                header('Location: painel_recepcao.php');
            } elseif ($dadosUsuario['tipo'] === 'professor') {
                header('Location: painel_professor.php');
            } elseif ($dadosUsuario['tipo'] === 'adm') {
                header('Location: painel_adm.php');
            } 
            exit;

        } else {
            // Credenciais inválidas
            header('Location: login.php?erro=invalido');
            exit;
        }

    } catch (PDOException $e) {
        // Tratar erros de banco de dados
        die("Erro ao processar login: " . $e->getMessage());
    }

} else {
    // Se o acesso não for via POST, redireciona para a tela de login
    header('Location: login.php');
    exit;
}