<?php
include 'conexao.php';

try {
    $query = " SELECT a.id_alunos AS id_aluno, a.nome AS aluno, a.data_nasc, a.matricula, a.rua, a.bairro, a.cidade, a.CEP, a.nome_resp, a.contat_resp, t.numero_turma 
        FROM alunos a LEFT JOIN turma t ON a.id_turma = t.id_turma ORDER BY a.nome ASC";
        
    $stmt = $con->prepare($query);
    $stmt->execute();
    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro ao buscar alunos: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/hist.css">     
    <style>
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        .table { width: 115vh; border-collapse: collapse; }
        .table th, .table td { padding: 0.75rem; border: 1px solid #dee2e6; text-align: left; }
        .table th { background-color: #f8f9fa; }
        .action-buttons { display: flex; gap: 10px; }
        .btn { padding: 5px 10px; text-decoration: none; color: #fff; border-radius: 5px; font-size: 14px; }
        .btn-edit { background-color: #CEBEE4; }
        .btn-delete { background-color: #dc3545; }
    </style>
</head>
<body>
<div class="navb">
    <a href="dashboard">
        <img src="img/back.png" height="40px">
    </a>
    <h2>LISTA DE ALUNOS</h2>
    <p></p>
</div>
    <div class="container">
        <h2>Alunos</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Matrícula</th>
                    <th>Endereço</th>
                    <th>Responsável</th>
                    <th>Contato</th>
                    <th>Turma</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($alunos) > 0): ?>
                    <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?= htmlspecialchars($aluno['aluno']) ?></td>
                            <td><?= htmlspecialchars($aluno['data_nasc']) ?></td>
                            <td><?= htmlspecialchars($aluno['matricula']) ?></td>
                            <td><?= htmlspecialchars($aluno['rua'] . ', ' . $aluno['bairro'] . ', ' . $aluno['cidade'] . ' - ' . $aluno['CEP']) ?></td>
                            <td><?= htmlspecialchars($aluno['nome_resp']) ?></td>
                            <td><?= htmlspecialchars($aluno['contat_resp']) ?></td>
                            <td><?= htmlspecialchars($aluno['numero_turma'] ?: 'Sem Turma') ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a class="btn btn-edit" href="editar_aluno?id=<?= $aluno['id_aluno'] ?>">Editar</a>
                                    <a class="btn btn-delete" href="excluir_aluno?id=<?= $aluno['id_aluno'] ?>" onclick="return confirm('Tem certeza que deseja excluir este aluno?')">Excluir</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">Nenhum aluno encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
