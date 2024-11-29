<?php
include 'conexao.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    try {
        $stmt = $con->prepare("DELETE FROM alunos WHERE id_alunos = :id");
        $stmt->execute([':id' => $id]);

        echo "<script>alert('Aluno excluído com sucesso!'); window.location.href = 'listar_alunos';</script>";
    } catch (PDOException $e) {
        echo "Erro ao excluir aluno: " . $e->getMessage();
    }
} else {
    echo "<script>alert('ID inválido!'); window.location.href = 'listar_alunos';</script>";
}
?>

