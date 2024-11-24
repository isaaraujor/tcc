<?php 
include "conexao.php";
if(!isset($_SESSION['logado'])){
    header("Location: acessoneg");
    exit;
} 
try {

    $query = " SELECT 
            c.id_controle AS id_controle,
            c.data_cont AS data_controle,
            d.nome_disciplina AS disciplina,
            t.numero_turma AS turma,
            a.nome AS aluno,
            f.qtde_faltas AS faltas
        FROM 
            controle c
        INNER JOIN 
            disc_turma dt ON c.id_discTurma = dt.id_discTurma
        INNER JOIN 
            disciplina d ON dt.id_disc = d.id_disciplina
        INNER JOIN 
            turma t ON dt.id_turma = t.id_turma
        INNER JOIN 
            falta f ON c.id_controle = f.controle_id
        INNER JOIN 
            alunos a ON f.aluno_id = a.id_alunos
        ORDER BY 
            c.data_cont DESC ";

    $stmt = $con->prepare($query);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro ao buscar histórico: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Faltas</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/hist.css">
    <style>
        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 0.75rem;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            margin-bottom: 20px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 5px 10px;
            text-decoration: none;
            color: #fff;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn-edit {
            background-color: #007bff;
        }

        .btn-delete {
            background-color: #dc3545;
        }
    </style>

</head>
<body>
<div class="navb">
    <a href="dashboard">
            <img src="img/back.png" height="40px">
        </a>
      <h2>HISTÓRICO</h2>
      <p></p>
    </div>
    <div class="container">
        <div class="header">
            <h2>Histórico de Faltas</h2>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Data do Controle</th>
                    <th>Disciplina</th>
                    <th>Turma</th>
                    <th>Nome do Aluno</th>
                    <th>Faltas</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($resultados) > 0): ?>
                    <?php foreach ($resultados as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['data_controle']); ?></td>
                            <td><?php echo htmlspecialchars($row['disciplina']); ?></td>
                            <td><?php echo htmlspecialchars($row['turma']); ?></td>
                            <td><?php echo htmlspecialchars($row['aluno']); ?></td>
                            <td><?php echo htmlspecialchars($row['faltas']); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a class="btn btn-edit" href="editar?id=<?php echo $row['id_controle']; ?>">Editar</a>
                                    <a class="btn btn-delete" href="excluir?id=<?php echo $row['id_controle']; ?>" onclick="return confirm('Tem certeza que deseja excluir este registro?');">Excluir</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Nenhum histórico encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
