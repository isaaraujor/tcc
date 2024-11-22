<?php
// Configuração do banco de dados
include_once('./pages/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_disciplina'])) {
    $idDisciplina = $_POST['id_disciplina'];

    // Consulta para obter as turmas associadas à disciplina
    $query = "
        SELECT turma.id_turma, turma.numero_turma 
        FROM disc_turma 
        INNER JOIN turma ON disc_turma.id_turma = turma.id_turma
        WHERE disc_turma.id_disc = :id_disciplina
    ";

    $stmt = $con->prepare($query);
    $stmt->bindValue(':id_disciplina', $idDisciplina, PDO::PARAM_INT);
    $stmt->execute();

    // Gerar os <option> para o select de turmas
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$row['id_turma']}'>{$row['numero_turma']}</option>";
        }
    } else {
        echo "<option value=''>Nenhuma turma encontrada</option>";
    }
}
