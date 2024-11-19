<?php
if (!isset($_SESSION['logado'])) {
    header("Location: acessoneg");
    exit;
}


$data_filtro = isset($_POST['data_filtro']) ? $_POST['data_filtro'] : '';
$materia_filtro = isset($_POST['materia_filtro']) ? $_POST['materia_filtro'] : '';
$aluno_filtro = isset($_POST['aluno_filtro']) ? $_POST['aluno_filtro'] : '';
$turma_filtro = isset($_POST['turma_filtro']) ? $_POST['turma_filtro'] : '';


$sql_historico = "
    SELECT controle.id_controle, controle.data_cont, controle.turma, controle.periodo, 
    controle.materia, controle.professor, controle.qtde_aula
    FROM controle
    WHERE 1 = 1
";


if ($data_filtro) {
    $sql_historico .= " AND controle.data_cont = :data_filtro";
}
if ($materia_filtro) {
    $sql_historico .= " AND controle.materia LIKE :materia_filtro";
}
if ($aluno_filtro) {
    $sql_historico .= " AND EXISTS (
        SELECT 1 FROM falta
        WHERE falta.controle_id = controle.id_controle
        AND falta.aluno_id = :aluno_filtro
    )";
}
if ($turma_filtro) {
    $sql_historico .= " AND controle.turma = :turma_filtro";
}

$sql_historico .= " ORDER BY controle.data_cont DESC";

$historico = $con->prepare($sql_historico);


$params = [];
if ($data_filtro) $params[':data_filtro'] = $data_filtro;
if ($materia_filtro) $params[':materia_filtro'] = "%$materia_filtro%"; 

if ($aluno_filtro) $params[':aluno_filtro'] = $aluno_filtro;
if ($turma_filtro) $params[':turma_filtro'] = $turma_filtro;

$historico->execute($params);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Controle de Chamada</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="css/hist.css">
    <style>
        .input-negrito {
            font-weight: bold;
        }
        .campo-pequeno {
            width: 50px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="navb">
        <a href="dashboard"><img src="img/back.png" height="40px"></a>
        <h2>HISTÓRICO DE CHAMADA</h2>
        <p></p>
    </div>

    <div class="container bg-light p-3 mb-3">
        <h3 class="mb-4">Pesquisar Controle de Chamada</h3>

        <form method="POST" action="">
            <!-- Filtro de Pesquisa -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <label for="data_filtro" class="form-label">Data</label>
                    <input type="date" class="form-control" id="data_filtro" name="data_filtro" 
                    value="<?php echo htmlspecialchars($data_filtro); ?>">
                </div>

                <div class="col-md-3">
                    <label for="materia_filtro" class="form-label">Matéria</label>
                    <input type="text" class="form-control" id="materia_filtro" name="materia_filtro" 
                    value="<?php echo htmlspecialchars($materia_filtro); ?>" placeholder="Disciplina">
                </div>

                <div class="col-md-3">
                    <label for="aluno_filtro" class="form-label">Aluno</label>
                    <input type="text" class="form-control" id="aluno_filtro" name="aluno_filtro" 
                    value="<?php echo htmlspecialchars($aluno_filtro); ?>" placeholder="Nome do Aluno">
                </div>

                <div class="col-md-3">
                    <label for="turma_filtro" class="form-label">Turma</label>
                    <input type="text" class="form-control" id="turma_filtro" name="turma_filtro" 
                    value="<?php echo htmlspecialchars($turma_filtro); ?>" placeholder="Turma">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </form>

        <h3 class="mb-4">Histórico de Chamadas</h3>

        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark" align="center">
                <tr>
                    <th>Data</th>
                    <th>Turma</th>
                    <th>Disciplina</th>
                    <th>Professor</th>
                    <th>Período</th>
                    <th>Qtde Aulas</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $historico->fetch(PDO::FETCH_ASSOC)) { 
                    $id_controle = $row['id_controle'];
                  
                    $sql_faltas = "SELECT aluno_id, qtde_faltas FROM falta WHERE controle_id = :id_controle";
                    $faltas = $con->prepare($sql_faltas);
                    $faltas->execute(['id_controle' => $id_controle]);

                   
                    $faltas_data = [];
                    while ($falta = $faltas->fetch(PDO::FETCH_ASSOC)) {
                        $faltas_data[] = $falta;
                    }
                ?>
                    <tr>
                        <td><?php echo date("d/m/Y", strtotime($row['data_cont'])); ?></td>
                        <td><?php echo htmlspecialchars($row['turma']); ?></td>
                        <td><?php echo htmlspecialchars($row['materia']); ?></td>
                        <td><?php echo htmlspecialchars($row['professor']); ?></td>
                        <td><?php echo htmlspecialchars($row['periodo']); ?></td>
                        <td><?php echo htmlspecialchars($row['qtde_aula']); ?></td>
                        <td align="center">
                            <a href="editar_controle?id=<?php echo $id_controle; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="excluir_controle?id=<?php echo $id_controle; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este controle de chamada?');">Excluir</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nome Aluno</th>
                                        <th>Faltas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($faltas_data as $falta) {
                                       
                                        $sql_aluno = "SELECT nome FROM alunos WHERE id_alunos = :id_aluno";
                                        $aluno = $con->prepare($sql_aluno);
                                        $aluno->execute(['id_aluno' => $falta['aluno_id']]);
                                        $aluno_data = $aluno->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($aluno_data['nome']); ?></td>
                                            <td><?php echo htmlspecialchars($falta['qtde_faltas']); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
