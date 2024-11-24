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
    $stmt = $con->prepare("
        SELECT 
            c.id_controle AS id_controle,
            c.data_cont AS data_controle,
            dt.id_disc AS id_disciplina,
            dt.id_turma AS id_turma,
            a.id_alunos AS id_aluno,
            f.qtde_faltas AS faltas
        FROM 
            controle c
        INNER JOIN 
            falta f ON c.id_controle = f.controle_id
        INNER JOIN 
            alunos a ON f.aluno_id = a.id_alunos
        INNER JOIN 
            disc_turma dt ON c.id_discTurma = dt.id_discTurma
        WHERE 
            c.id_controle = ?
    ");

    $stmt->execute([$id]);
    $controle = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$controle) {
        echo "Controle não encontrado!";
        exit;
    }

    $disciplinas = $con->query("SELECT id_disciplina, nome_disciplina FROM disciplina")->fetchAll(PDO::FETCH_ASSOC);
    $turmas = $con->query("SELECT id_turma, numero_turma FROM turma")->fetchAll(PDO::FETCH_ASSOC);
    $alunos = $con->query("SELECT id_alunos, nome FROM alunos")->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data_controle = $_POST['data_controle'];
        $id_disciplina = $_POST['id_disciplina'];
        $id_turma = $_POST['id_turma'];
        $id_aluno = $_POST['id_aluno'];
        $faltas = $_POST['faltas'];

        $con->beginTransaction();

        $stmtUpdateControle = $con->prepare("
            UPDATE controle 
            SET data_cont = ? 
            WHERE id_controle = ?
        ");

        $stmtUpdateControle->execute([$data_controle, $id]);
        $stmtUpdateDiscTurma = $con->prepare("
            UPDATE disc_turma 
            SET id_disc = ?, id_turma = ?
            WHERE id_discTurma = (
                SELECT id_discTurma FROM controle WHERE id_controle = ?
            )
        ");

        $stmtUpdateDiscTurma->execute([$id_disciplina, $id_turma, $id]);
        $stmtUpdateFaltas = $con->prepare("
            UPDATE falta 
            SET qtde_faltas = ?, aluno_id = ?
            WHERE controle_id = ?
        ");

        $stmtUpdateFaltas->execute([$faltas, $id_aluno, $id]);
        $con->commit();

        header("Location: historico");
        exit;
    }
} catch (PDOException $e) {
    $con->rollBack();
    echo "Erro: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Controle</title>
    
</head>
<body>
    <div class="container">
        <h2>Editar Controle</h2>
        <form method="post">
            <label>Data do Controle:</label>
            <input type="date" name="data_controle" value="<?php echo htmlspecialchars($controle['data_controle']); ?>" required>

            <label>Disciplina:</label>
            <select name="id_disciplina" required>
                <?php foreach ($disciplinas as $disc): ?>
                    <option value="<?php echo $disc['id_disciplina']; ?>" 
                        <?php echo $controle['id_disciplina'] == $disc['id_disciplina'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($disc['nome_disciplina']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Turma:</label>
            <select name="id_turma" required>
                <?php foreach ($turmas as $turma): ?>
                    <option value="<?php echo $turma['id_turma']; ?>" 
                        <?php echo $controle['id_turma'] == $turma['id_turma'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($turma['numero_turma']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Aluno:</label>
            <select name="id_aluno" required>
                <?php foreach ($alunos as $aluno): ?>
                    <option value="<?php echo $aluno['id_alunos']; ?>" 
                        <?php echo $controle['id_aluno'] == $aluno['id_alunos'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($aluno['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Faltas:</label>
            <input type="number" name="faltas" value="<?php echo htmlspecialchars($controle['faltas']); ?>" required min="0">

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
