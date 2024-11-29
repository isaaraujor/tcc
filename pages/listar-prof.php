<?php
include 'conexao.php';

try {
    $query = "SELECT  p.id_professor,  p.nome AS professor,  p.data_nascimento,  p.cpf,  GROUP_CONCAT(DISTINCT d.nome_disciplina SEPARATOR ', ') AS disciplinas, GROUP_CONCAT(DISTINCT t.numero_turma SEPARATOR ', ') AS turmas
        FROM  professor p LEFT JOIN  disc_turma dt ON p.id_professor = dt.id_professor LEFT JOIN  disciplina d ON dt.id_disc = d.id_disciplina
        LEFT JOIN  turma t ON dt.id_turma = t.id_turma GROUP BY  p.id_professor
        ORDER BY p.nome ASC";

    $stmt = $con->prepare($query);
    $stmt->execute();
    $professores = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro ao buscar professores: " . $e->getMessage();
    exit;
}
?>
<?php

try {
    // Obtém o termo de busca, se fornecido
    $filtroGeral = isset($_GET['busca']) ? trim($_GET['busca']) : '';

    // Prepara a consulta SQL com a cláusula WHERE para filtrar os resultados
    $query = "SELECT p.id_professor, p.nome AS professor, p.data_nascimento, p.cpf, 
                     GROUP_CONCAT(DISTINCT d.nome_disciplina SEPARATOR ', ') AS disciplinas, 
                     GROUP_CONCAT(DISTINCT t.numero_turma SEPARATOR ', ') AS turmas
              FROM professor p
              LEFT JOIN disc_turma dt ON p.id_professor = dt.id_professor
              LEFT JOIN disciplina d ON dt.id_disc = d.id_disciplina
              LEFT JOIN turma t ON dt.id_turma = t.id_turma
              WHERE (:busca = '' OR p.nome LIKE :buscaLike 
                     OR p.data_nascimento LIKE :buscaLike 
                     OR p.cpf LIKE :buscaLike 
                     OR d.nome_disciplina LIKE :buscaLike 
                     OR t.numero_turma LIKE :buscaLike)
              GROUP BY p.id_professor
              ORDER BY p.nome ASC";

    // Prepara e executa a consulta
    $stmt = $con->prepare($query);
    $stmt->bindValue(':busca', $filtroGeral, PDO::PARAM_STR);
    $stmt->bindValue(':buscaLike', "%$filtroGeral%", PDO::PARAM_STR);
    $stmt->execute();
    $professores = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro ao buscar professores: " . $e->getMessage();
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Professores</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/hist.css">
    <style>
        .container { 
            max-width: 1000px; 
            margin: 0 auto; 
            padding: 20px; 
        }
        .table { width: 100%; 
            border-collapse: collapse; 
        }
        .table th, .table td {
             padding: 0.75rem; 
             border: 1px solid #dee2e6; 
             text-align: left; 
            }
        .table th { background-color: #f8f9fa;
         }
        .action-buttons { display: flex; 
            gap: 10px; 
        }
        .btn { padding: 5px 10px;
             text-decoration: none;
              color: #fff; 
              border-radius: 5px; 
              font-size: 14px; 
            }
        .btn-edit {
             background-color: #CEBEE4;
             }
        .btn-delete { 
            background-color: #dc3545;
         }
        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar form {
            display: flex;
            gap: 10px; 
            flex-wrap: wrap; 
        }

        .search-bar input, .search-bar button {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .search-bar input {
            flex: 1; 
            min-width: 100px;
        }

        .search-bar button {
            background-color: #007bff;
            color: white;
            border: none;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="navb">
    <a href="dashboard">
        <img src="img/back.png" height="40px">
    </a>
    <h2>LISTA DE PROFESSORES</h2>
    <p></p>
</div>
    <div class="container">
        <h2>Professores</h2>
        <div class="search-bar">
            <form method="GET" action="" style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px;">
                <input type="text" name="busca" placeholder="Buscar pelo professor" 
                       value="<?= isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>" 
                       style="flex: 1; min-width: 200px; padding: 5px; border: 1px solid #ccc; border-radius: 5px;">
            
                <button type="submit" 
                        style="padding: 5px 15px; background-color: #2D006C; color: #CEBEE4; border: none; border-radius: 5px; font-size: 14px;">
                    Buscar
                </button>
            </form>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>CPF</th>
                    <th>Disciplinas</th>
                    <th>Turmas</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($professores) > 0): ?>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= htmlspecialchars($professor['professor']) ?></td>
                            <td><?= htmlspecialchars($professor['data_nascimento']) ?></td>
                            <td><?= htmlspecialchars($professor['cpf']) ?></td>
                            <td><?= htmlspecialchars($professor['disciplinas']) ?></td>
                            <td><?= htmlspecialchars($professor['turmas']) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a class="btn btn-edit" href="editar_prof?id=<?= $professor['id_professor'] ?>">Editar</a>
                                    <a class="btn btn-delete" href="excluir_prof?id=<?= $professor['id_professor'] ?>" onclick="return confirm('Tem certeza que deseja excluir este professor?')">Excluir</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Nenhum professor encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>