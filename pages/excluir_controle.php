<?php
if (!isset($_SESSION['logado'])) {
    header("Location: acessoneg");
    exit;
}

if (isset($_GET['id'])) {
    $id_controle = $_GET['id'];

    // Excluir as faltas associadas ao controle
    $sqlFaltas = "DELETE FROM falta WHERE controle_id = :id_controle";
    $stmtFaltas = $con->prepare($sqlFaltas);
    $stmtFaltas->execute(['id_controle' => $id_controle]);

    // Agora, excluir o controle
    $sql = "DELETE FROM controle WHERE id_controle = :id_controle";
    $stmt = $con->prepare($sql);
    $stmt->execute(['id_controle' => $id_controle]);

    // Redirecionar após a exclusão
    header('Location: historico');
    exit;
} else {
    die("Controle não especificado.");
}
