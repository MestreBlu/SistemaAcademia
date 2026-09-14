<?php

session_start();

// ==========================================================
// PERFIS AUTORIZADOS
// ==========================================================

$perfisAutorizados = ['recepcionista', 'adm'];

// Verifica se o usuário está logado
if (
    !isset($_SESSION['usuario_id']) ||
    !isset($_SESSION['usuario_tipo'])
) {
    header('Location: login.php?erro=acesso_negado');
    exit;
}

// Verifica se o usuário possui permissão
if (!in_array($_SESSION['usuario_tipo'], $perfisAutorizados, true)) {
    header('Location: login.php?erro=acesso_negado');
    exit;
}


// ==========================================================
// ACEITA SOMENTE POST
// ==========================================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: remover.php');
    exit;
}


// ==========================================================
// CONEXÃO COM O BANCO
// ==========================================================

require_once 'conexao.php';

// Força o PDO a lançar exceções quando houver erro SQL
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// ==========================================================
// RECEBE O ID DO ALUNO
// ==========================================================

$id = $_POST['id_aluno'] ?? '';


// Verifica se foi enviado um ID
if ($id === '') {
    header('Location: remover.php?erro=id_invalido');
    exit;
}


// Verifica se o ID é realmente um número inteiro
if (
    filter_var($id, FILTER_VALIDATE_INT) === false ||
    (int)$id <= 0
) {
    header('Location: remover.php?erro=id_invalido');
    exit;
}

$id = (int)$id;


// ==========================================================
// INICIA A TRANSAÇÃO
// ==========================================================

try {

    $pdo->beginTransaction();


    // ======================================================
    // 1. VERIFICA SE O ALUNO EXISTE
    // ======================================================

    $sql = "SELECT id_aluno, nome
            FROM aluno
            WHERE id_aluno = :id
            LIMIT 1";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(
        ':id',
        $id,
        PDO::PARAM_INT
    );

    $stmt->execute();

    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);


    // Se não encontrou o aluno
    if (!$aluno) {

        $pdo->rollBack();

        header('Location: remover.php?erro=aluno_nao_encontrado');
        exit;
    }


    // ======================================================
    // 2. REMOVE O ALUNO
    // ======================================================

    $sqlDelete = "DELETE FROM aluno
                  WHERE id_aluno = :id";

    $stmtDelete = $pdo->prepare($sqlDelete);

    $stmtDelete->bindValue(
        ':id',
        $id,
        PDO::PARAM_INT
    );

    $stmtDelete->execute();


    // Quantidade de registros realmente removidos
    $quantidadeRemovida = $stmtDelete->rowCount();


    // ======================================================
    // 3. VERIFICA SE O REGISTRO REALMENTE FOI EXCLUÍDO
    // ======================================================

    $sqlConfirmacao = "SELECT id_aluno
                       FROM aluno
                       WHERE id_aluno = :id
                       LIMIT 1";

    $stmtConfirmacao = $pdo->prepare($sqlConfirmacao);

    $stmtConfirmacao->bindValue(
        ':id',
        $id,
        PDO::PARAM_INT
    );

    $stmtConfirmacao->execute();

    $alunoAindaExiste = $stmtConfirmacao->fetch(PDO::FETCH_ASSOC);


    // ======================================================
    // 4. CONFIRMAÇÃO
    // ======================================================

    if (
        $quantidadeRemovida > 0 &&
        !$alunoAindaExiste
    ) {

        // Confirma a transação
        $pdo->commit();

        header('Location: remover.php?sucesso=1');
        exit;
    }


    // ======================================================
    // SE NÃO REMOVEU
    // ======================================================

    $pdo->rollBack();

    header('Location: remover.php?erro=nao_removido');
    exit;
} catch (PDOException $e) {

    // Se houver uma transação ativa, desfaz
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }


    /*
     * SQLSTATE 23000 normalmente indica violação de
     * integridade referencial, como uma chave estrangeira.
     *
     * Exemplo:
     *
     * outra tabela possui:
     *
     * id_aluno -> aluno.id_aluno
     *
     * Nesse caso o MySQL impede a exclusão do aluno.
     */

    if ($e->getCode() === '23000') {

        header('Location: remover.php?erro=dependencia');
        exit;
    }


    // Qualquer outro erro do banco
    header('Location: remover.php?erro=banco');
    exit;
}
