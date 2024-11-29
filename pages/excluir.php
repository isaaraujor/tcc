<?php
include "conexao.php";
if (!isset($_SESSION['logado'])) {
    header("Location: acessoneg");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID do controle não fornecido!";
    exit;
}
try {
    $con->beginTransaction();

    $stmtFalta = $con->prepare("DELETE FROM falta WHERE id_falta = ?");
    $stmtFalta->execute([$id]);

    $con->commit();

    header("Location: historico");
    exit;

} catch (PDOException $e) {
    $con->rollBack();
    echo "Erro ao excluir controle: " . $e->getMessage();
    exit;
}
?>
