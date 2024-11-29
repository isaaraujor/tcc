<?php
include 'conexao.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID inválido.";
    exit;
}
$idProfessor = $_GET['id'];
try {
    $con->beginTransaction();
    $stmtDiscTurma = $con->prepare("DELETE FROM disc_turma WHERE id_professor = :id_professor");
    $stmtDiscTurma->execute([':id_professor' => $idProfessor]);

    $stmtProfessor = $con->prepare("DELETE FROM professor WHERE id_professor = :id_professor");
    $stmtProfessor->execute([':id_professor' => $idProfessor]);

    $stmtUsuario = $con->prepare("DELETE FROM usuarios WHERE id_usuario = (SELECT id_usuario FROM professor WHERE id_professor = :id_professor)");
    $stmtUsuario->execute([':id_professor' => $idProfessor]);
    $con->commit();

    echo "<script>alert('Professor excluído com sucesso!'); window.location.href = 'listar_prof';</script>";
} catch (PDOException $e) {
    $con->rollBack();
    echo "Erro ao excluir professor: " . $e->getMessage();
}
?>
