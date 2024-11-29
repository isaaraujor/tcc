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
    // $stmt = $con->prepare("
    //     SELECT 
    //         c.id_controle AS id_controle,
    //         c.data_cont AS data_controle,
    //         dt.id_disc AS id_disciplina,
    //         dt.id_turma AS id_turma,
    //         a.id_alunos AS id_aluno,
    //         f.qtde_faltas AS faltas
    //     FROM 
    //         controle c
    //     INNER JOIN 
    //         falta f ON c.id_controle = f.controle_id
    //     INNER JOIN 
    //         alunos a ON f.aluno_id = a.id_alunos
    //     INNER JOIN 
    //         disc_turma dt ON c.id_discTurma = dt.id_discTurma
    //     WHERE 
    //         f.id_falta = ?
    // ",);

    $stmt = $con->prepare("
        SELECT
            c.id_controle AS id_controle,
            c.data_cont AS data_controle,
            dt.id_disc AS id_disciplina,
            dt.id_turma AS id_turma,
            a.id_alunos AS id_aluno,
            f.qtde_faltas AS faltas
        FROM
            falta f
        INNER JOIN
            controle c ON f.controle_id = c.id_controle
        INNER JOIN
            alunos a ON f.aluno_id = a.id_alunos
        INNER JOIN
            disc_turma dt ON c.id_discTurma = dt.id_discTurma
        WHERE
            f.id_falta = ?
    ",);

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
        $stmtUpdateControle->execute([$data_controle, $controle['id_controle']]);






        // $stmtUpdateDiscTurma = $con->prepare("
        //     UPDATE disc_turma 
        //     SET id_disc = ?, id_turma = ?
        //     WHERE id_discTurma = (
        //         SELECT id_discTurma FROM controle WHERE id_controle = ?
        //     )
        // ");
        // $stmtUpdateDiscTurma->execute([$id_disciplina, $id_turma, $id]);


        $STMT_DISCTURMA = $con->prepare("
            SELECT id_discTurma FROM disc_turma
            WHERE id_disc = ? AND id_turma = ?
        ");
        $STMT_DISCTURMA->execute([$id_disciplina, $id_turma]);
        $id_discTurma = $STMT_DISCTURMA->fetch(PDO::FETCH_ASSOC);

        $stmtUpdateDiscTurma = $con->prepare("
            UPDATE controle 
            SET id_discTurma = ?
            WHERE id_controle = ?
        ");
        $stmtUpdateDiscTurma->execute([$id_discTurma['id_discTurma'], $controle['id_controle']]);








        $stmtUpdateFaltas = $con->prepare("
            UPDATE falta 
            SET qtde_faltas = ?, aluno_id = ?
            WHERE id_falta = ?
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
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="css/cont.css">
    <style>
        .input-negrito {
            font-weight: bold;
        }
        .auto-width-input {
            width: auto;
            min-width: 100px;
            max-width: 100%;
            padding: 0.375rem 0.75rem;
        }
        .auto-width-select {
            width: auto;
            min-width: 150px;
            padding: 0.375rem 0.75rem;
            display: inline-block;
        }
        .container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            max-width: 600px;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-size: 14px;
            margin-bottom: 5px;
        }
        .form-control, .form-select {
            font-size: 14px;
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="navb">
    <a href="historico">
            <img src="img/back.png" height="40px">
        </a>
      <h2>EDITAR CONTROLE</h2>
      <p></p>
    </div>
    <div class="container">
        <form method="post">
            <div class="mb-3">
                <label for="data_controle" class="form-label">Data do Controle:</label>
                <input type="date" id="data_controle" class="form-control auto-width-input input-negrito" name="data_controle" value="<?php echo htmlspecialchars($controle['data_controle']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="id_disciplina" class="form-label">Disciplina:</label>
                <select id="id_disciplina" class="form-select auto-width-select" name="id_disciplina" required>
                    <?php foreach ($disciplinas as $disc): ?>
                        <option value="<?php echo $disc['id_disciplina']; ?>" 
                            <?php echo $controle['id_disciplina'] == $disc['id_disciplina'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($disc['nome_disciplina']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_turma" class="form-label">Turma:</label>
                <select id="id_turma" class="form-select auto-width-select" name="id_turma" required>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?php echo $turma['id_turma']; ?>" 
                            <?php echo $controle['id_turma'] == $turma['id_turma'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($turma['numero_turma']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_aluno" class="form-label">Aluno:</label>
                <select id="id_aluno" class="form-select auto-width-select" name="id_aluno" required>
                    <?php foreach ($alunos as $aluno): ?>
                        <option value="<?php echo $aluno['id_alunos']; ?>" 
                            <?php echo $controle['id_aluno'] == $aluno['id_alunos'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($aluno['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="faltas" class="form-label">Faltas:</label>
                <input type="number" id="faltas" class="form-control auto-width-input" name="faltas" value="<?php echo htmlspecialchars($controle['faltas']); ?>" required min="0">
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
