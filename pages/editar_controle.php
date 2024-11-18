<?php
if (!isset($_SESSION['logado'])) {
    header("Location: acessoneg");
    exit;
}

if (isset($_GET['id'])) {
    $id_controle = $_GET['id'];
    
    // Buscar os dados do controle
    $sql = "SELECT * FROM controle WHERE id_controle = :id_controle";
    $stmt = $con->prepare($sql);
    $stmt->execute(['id_controle' => $id_controle]);
    $controle = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$controle) {
        die("Controle não encontrado.");
    }

    // Buscar as faltas associadas ao controle
    $sqlFaltas = "SELECT f.*, a.nome 
                  FROM falta f
                  JOIN alunos a ON f.aluno_id = a.id_alunos
                  WHERE f.controle_id = :id_controle";
    $stmtFaltas = $con->prepare($sqlFaltas);
    $stmtFaltas->execute(['id_controle' => $id_controle]);
    $faltas = $stmtFaltas->fetchAll(PDO::FETCH_ASSOC);
}

// Caso o formulário de edição seja enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_cont = $_POST['data_cont'];
    $turma = $_POST['turma'];
    $materia = $_POST['materia'];
    $professor = $_POST['professor'];
    $periodo = $_POST['periodo'];
    $qtde_aula = $_POST['qtde_aula'];

    // Atualizar o controle
    $updateSql = "
        UPDATE controle
        SET data_cont = :data_cont, turma = :turma, materia = :materia, 
            professor = :professor, periodo = :periodo, qtde_aula = :qtde_aula
        WHERE id_controle = :id_controle
    ";
    $updateStmt = $con->prepare($updateSql);
    $updateStmt->execute([
        ':data_cont' => $data_cont,
        ':turma' => $turma,
        ':materia' => $materia,
        ':professor' => $professor,
        ':periodo' => $periodo,
        ':qtde_aula' => $qtde_aula,
        ':id_controle' => $id_controle
    ]);

    // Atualizar as faltas dos alunos
    foreach ($faltas as $falta) {
        $falta_id = $falta['id_falta'];
        $qtde_faltas = $_POST["qtde_faltas_$falta_id"]; // Pega a quantidade de faltas enviada pelo formulário

        $updateFaltasSql = "
            UPDATE falta 
            SET qtde_faltas = :qtde_faltas
            WHERE id_falta = :id_falta
        ";
        $updateFaltasStmt = $con->prepare($updateFaltasSql);
        $updateFaltasStmt->execute([
            ':qtde_faltas' => $qtde_faltas,
            ':id_falta' => $falta_id
        ]);
    }

    // Redirecionar após a atualização
    header('Location: historico');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Controle de Chamada</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="css/edita.css">
</head>
<body>
<div class="navb">
        <a href="dashboard"><img src="img/back.png" height="40px"></a>
        <h2>EDITAR CONTROLE</h2>
        <p></p>
    </div>

    <form method="POST">
        <label for="data_cont">Data:</label>
        <input type="date" id="data_cont" name="data_cont" value="<?php echo htmlspecialchars($controle['data_cont']); ?>" required><br>

        <label for="turma">Turma:</label>
        <input type="text" id="turma" name="turma" value="<?php echo htmlspecialchars($controle['turma']); ?>" required><br>

        <label for="materia">Matéria:</label>
        <input type="text" id="materia" name="materia" value="<?php echo htmlspecialchars($controle['materia']); ?>" required><br>

        <label for="professor">Professor:</label>
        <input type="text" id="professor" name="professor" value="<?php echo htmlspecialchars($controle['professor']); ?>" required><br>

        <label for="periodo">Período:</label>
        <input type="text" id="periodo" name="periodo" value="<?php echo htmlspecialchars($controle['periodo']); ?>" required><br>

        <label for="qtde_aula">Qtde Aulas:</label>
        <input type="number" id="qtde_aula" name="qtde_aula" value="<?php echo htmlspecialchars($controle['qtde_aula']); ?>" required><br>

        <h3>Faltas dos Alunos</h3>
        <?php foreach ($faltas as $falta) { ?>
            <div>
                <label for="qtde_faltas_<?php echo $falta['id_falta']; ?>">Aluno: <?php echo htmlspecialchars($falta['nome']); ?></label>
                <input type="number" id="qtde_faltas_<?php echo $falta['id_falta']; ?>" name="qtde_faltas_<?php echo $falta['id_falta']; ?>" value="<?php echo htmlspecialchars($falta['qtde_faltas']); ?>" required>
            </div>
        <?php } ?>

        <button type="submit">Salvar Alterações</button>
    </form>

    <a href="historico">Voltar ao Histórico</a>
</body>
</html>
