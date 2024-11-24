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

    $stmtFalta = $con->prepare("DELETE FROM falta WHERE controle_id = ?");
    $stmtFalta->execute([$id]);

    $stmtControle = $con->prepare("DELETE FROM controle WHERE id_controle = ?");
    $stmtControle->execute([$id]);

    $con->commit();

    header("Location: historico");
    exit;

} catch (PDOException $e) {
    $con->rollBack();
    echo "Erro ao excluir controle: " . $e->getMessage();
    exit;
}
?>
