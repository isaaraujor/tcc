<?php
include 'conexao.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID inválido.";
    exit;
}

$idProfessor = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $dataNascimento = $_POST['data_nascimento'];
    $cpf = $_POST['cpf'];
    $disciplinas = isset($_POST['disciplinas']) ? $_POST['disciplinas'] : [];
    $turmas = isset($_POST['turmas']) ? $_POST['turmas'] : [];

    try {
        $con->beginTransaction();
        $stmtProfessor = $con->prepare("
            UPDATE professor 
            SET nome = :nome, data_nascimento = :data_nascimento, cpf = :cpf
            WHERE id_professor = :id_professor
        ");
        $stmtProfessor->execute([
            ':nome' => $nome,
            ':data_nascimento' => $dataNascimento,
            ':cpf' => $cpf,
            ':id_professor' => $idProfessor
        ]);
        foreach($disciplinas as $disciplina1){
            if($disciplina1 != null){
                $stmtDelete = $con->prepare("DELETE FROM disc_turma WHERE id_professor = :id_professor");
                $stmtDelete->execute([':id_professor' => $idProfessor]);
            }
        }
        foreach ($disciplinas as $disciplina) {
            

            $querySelectDisciplina = "SELECT id_disciplina FROM disciplina WHERE nome_disciplina = :disciplina";
            $stmtSelectDisciplina = $con->prepare($querySelectDisciplina);
            $stmtSelectDisciplina->bindValue(':disciplina', $disciplina, PDO::PARAM_STR);
            $stmtSelectDisciplina->execute();

            if ($stmtSelectDisciplina->rowCount() > 0) {
                while ($row = $stmtSelectDisciplina->fetch(PDO::FETCH_ASSOC)) {
                    echo "O ID é: " . $row['id_disciplina'] . "<br>";
                    $idDisciplina = $row['id_disciplina'];
                }
            } else {
                echo "Nenhuma disciplina encontrada";
            }
          
            if (isset($turmas[$disciplina])) {
                foreach ($turmas[$disciplina] as $turma) {

                    $querySelectTurma = "SELECT id_turma FROM turma WHERE numero_turma = :turma";
                    $stmtSelectTurma = $con->prepare($querySelectTurma);
                    $stmtSelectTurma->bindValue(':turma', $turma, PDO::PARAM_STR);
                    $stmtSelectTurma->execute();
        
                    if ($stmtSelectTurma->rowCount() > 0) {
                        while ($row = $stmtSelectTurma->fetch(PDO::FETCH_ASSOC)) {
                            echo "O ID é: " . $row['id_turma'] . "<br>";
                            $idTurma = $row['id_turma'];
                        }
                    } else {
                        echo "Nenhuma turma encontrada";
                    }

                    $queryDiscTurma = "INSERT INTO disc_turma (id_professor, id_disc, id_turma) VALUES (:id_professor, :id_disc, :id_turma)";
                    $stmtDiscTurma = $con->prepare($queryDiscTurma);
                    $stmtDiscTurma->execute([
                        ':id_professor' => $idProfessor,
                        ':id_disc' => $idDisciplina,
                        ':id_turma' => $idTurma
                    ]);
                }
            }
        }


        // $stmtDelete = $con->prepare("DELETE FROM disc_turma WHERE id_professor = :id_professor");
        // $stmtDelete->execute([':id_professor' => $idProfessor]);

        // foreach ($disciplinas as $disciplina) {
        //     $querySelectDisciplina = "SELECT id_disciplina FROM disciplina WHERE nome_disciplina = :disciplina";
        //     $stmtSelectDisciplina = $con->prepare($querySelectDisciplina);
        //     $stmtSelectDisciplina->bindValue(':disciplina', $disciplina, PDO::PARAM_STR);
        //     $stmtSelectDisciplina->execute();
        //     $idDisciplina = $stmtSelectDisciplina->fetchColumn();

        //     if ($idDisciplina && isset($turmas[$disciplina])) {
        //         foreach ($turmas[$disciplina] as $turma) {
        //             $querySelectTurma = "SELECT id_turma FROM turma WHERE numero_turma = :turma";
        //             $stmtSelectTurma = $con->prepare($querySelectTurma);
        //             $stmtSelectTurma->bindValue(':turma', $turma, PDO::PARAM_STR);
        //             $stmtSelectTurma->execute();
        //             $idTurma = $stmtSelectTurma->fetchColumn();

        //             if ($idTurma) {
        //                 $stmtDiscTurma = $con->prepare("
        //                     INSERT INTO disc_turma (id_professor, id_disc, id_turma) 
        //                     VALUES (:id_professor, :id_disc, :id_turma)
        //                 ");
        //                 $stmtDiscTurma->execute([
        //                     ':id_professor' => $idProfessor,
        //                     ':id_disc' => $idDisciplina,
        //                     ':id_turma' => $idTurma
        //                 ]);
        //             }
        //         }
        //     }
        // }

        $con->commit();
        echo "<script>alert('Professor atualizado com sucesso!'); window.location.href = 'listar_prof';</script>";
    } catch (Exception $e) {
        $con->rollBack();
        echo "Erro ao atualizar professor: " . $e->getMessage();
    }
} else {
    try {
        $stmtProfessor = $con->prepare("
            SELECT p.nome, p.data_nascimento, p.cpf
            FROM professor p
            WHERE p.id_professor = :id_professor
        ");
        $stmtProfessor->execute([':id_professor' => $idProfessor]);
        $professor = $stmtProfessor->fetch(PDO::FETCH_ASSOC);

        if (!$professor) {
            echo "Professor não encontrado.";
            exit;
        }
        $stmtDisciplinas = $con->prepare("
            SELECT d.nome_disciplina, t.numero_turma
            FROM disc_turma dt
            INNER JOIN disciplina d ON dt.id_disc = d.id_disciplina
            INNER JOIN turma t ON dt.id_turma = t.id_turma
            WHERE dt.id_professor = :id_professor
        ");
        $stmtDisciplinas->execute([':id_professor' => $idProfessor]);
        $associacoes = $stmtDisciplinas->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Erro ao carregar dados do professor: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Professor</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="css/novo.css">
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
        .navb {
            text-align: center;
            margin-bottom: 20px;
        }
        .navb a {
            display: inline-block;
            margin-right: 10px;
        }
        .navb img {
            height: 40px;
        }
        .divs-checkbox { 
            display: flex; 
            align-items: center; 
            margin-bottom: 10px; 
        }
        .divs-checkbox p {
            margin-left: 10px; 
        }
        .divs-checkboxT { 
            display: flex; 
            flex-wrap: wrap; 
            margin-bottom: 20px; 
            margin-left: 20px; 
        }
        .divs-checkboxT p { 
            margin-right: 10px; 
            margin-bottom: 5px; 
        }
    </style>
</head>
<body>
    <div class="navb">
        <a href="listar_prof">
            <img src="img/back.png" alt="Voltar">
        </a>
        <h2>EDITAR PROFESSOR</h2>
        <p></p>
    </div>
    <div class="container">
        <form method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" class="form-control auto-width-input input-negrito" name="nome" value="<?= htmlspecialchars($professor['nome']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" class="form-control auto-width-input" name="data_nascimento" value="<?= htmlspecialchars($professor['data_nascimento']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="cpf" class="form-label">CPF:</label>
                <input type="text" id="cpf" class="form-control auto-width-input" name="cpf" value="<?= htmlspecialchars($professor['cpf']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="disciplina" class="form-label">Disciplinas e Turmas</label>
                <div>

                <div class="divs-checkbox">
                    <input type="checkbox" name="disciplinas[]" class="disciplina" value="Teste de Software" id="disciplina_Teste de Software">
                    <p>Teste de Software</p>
                </div>
                <div class="divs-checkboxT turma-group" data-disciplina="Teste de Software">
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="151" disabled>
                    <p>151</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="152" disabled>
                    <p>152</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="153" disabled>
                    <p>153</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="251" disabled>
                    <p>251</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="252" disabled>
                    <p>252</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="253" disabled>
                    <p>253</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="254" disabled>
                    <p>254</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="351" disabled>
                    <p>351</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="352" disabled>
                    <p>352</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="353" disabled>
                    <p>353</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="354" disabled>
                    <p>354</p>
                </div>

                <div class="divs-checkbox">
                    <input type="checkbox" name="disciplinas[]" class="disciplina" value="Desenvolvimento de Sistemas" id="disciplina_Desenvolvimento de Sistemas">
                    <p>Desenvolvimento de Sistemas</p>
                </div>
                <div class="divs-checkboxT turma-group" data-disciplina="Desenvolvimento de Sistemas">
                <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="151" disabled>
                    <p>151</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="152" disabled>
                    <p>152</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="153" disabled>
                    <p>153</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="251" disabled>
                    <p>251</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="252" disabled>
                    <p>252</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="253" disabled>
                    <p>253</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="254" disabled>
                    <p>254</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="351" disabled>
                    <p>351</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="352" disabled>
                    <p>352</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="353" disabled>
                    <p>353</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="354" disabled>
                    <p>354</p>
                </div>

                <div class="divs-checkbox">
                    <input type="checkbox" name="disciplinas[]" class="disciplina" value="PD. Moveis" id="disciplina_PD. Moveis">
                    <p>PD. Moveis</p>
                </div>
                <div class="divs-checkboxT turma-group" data-disciplina="PD. Moveis">
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="151" disabled>
                    <p>151</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="152" disabled>
                    <p>152</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="153" disabled>
                    <p>153</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="251" disabled>
                    <p>251</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="252" disabled>
                    <p>252</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="253" disabled>
                    <p>253</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="254" disabled>
                    <p>254</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="351" disabled>
                    <p>351</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="352" disabled>
                    <p>352</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="353" disabled>
                    <p>353</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="354" disabled>
                    <p>354</p>
                </div>

                <div class="divs-checkbox">
                    <input type="checkbox" name="disciplinas[]" class="disciplina" value="Programação de Aplicativos" id="disciplina_Programação de Aplicativos">
                    <p>Programação de Aplicativos</p>
                </div>
                <div class="divs-checkboxT turma-group" data-disciplina="Programação de Aplicativos">
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="151" disabled>
                    <p>151</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="152" disabled>
                    <p>152</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="153" disabled>
                    <p>153</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="251" disabled>
                    <p>251</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="252" disabled>
                    <p>252</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="253" disabled>
                    <p>253</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="254" disabled>
                    <p>254</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="351" disabled>
                    <p>351</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="352" disabled>
                    <p>352</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="353" disabled>
                    <p>353</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="354" disabled>
                    <p>354</p>
                </div>

                <div class="divs-checkbox">
                    <input type="checkbox" name="disciplinas[]" class="disciplina" value="IM. Sistemas" id="disciplina_IM. Sistemas">
                    <p>IM. Sistemas</p>
                </div>
                <div class="divs-checkboxT turma-group" data-disciplina="IM. Sistemas">
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="151" disabled>
                    <p>151</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="152" disabled>
                    <p>152</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="153" disabled>
                    <p>153</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="251" disabled>
                    <p>251</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="252" disabled>
                    <p>252</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="253" disabled>
                    <p>253</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="254" disabled>
                    <p>254</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="351" disabled>
                    <p>351</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="352" disabled>
                    <p>352</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="353" disabled>
                    <p>353</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="354" disabled>
                    <p>354</p>
                </div>

                <div class="divs-checkbox">
                    <input type="checkbox" name="disciplinas[]" class="disciplina" value="Modelagem de Sistemas" id="disciplina_Modelagem de Sistemas">
                    <p>Modelagem de Sistemas</p>
                </div>
                <div class="divs-checkboxT turma-group" data-disciplina="Modelagem de Sistemas">
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="151" disabled>
                    <p>151</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="152" disabled>
                    <p>152</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="153" disabled>
                    <p>153</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="251" disabled>
                    <p>251</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="252" disabled>
                    <p>252</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="253" disabled>
                    <p>253</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="254" disabled>
                    <p>254</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="351" disabled>
                    <p>351</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="352" disabled>
                    <p>352</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="353" disabled>
                    <p>353</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="354" disabled>
                    <p>354</p>
                </div>
            </div>
        </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
</body>
<script>
    document.querySelectorAll('.disciplina').forEach(disciplina => {
        const turmaGroup = document.querySelector(`.turma-group[data-disciplina="${disciplina.value}"]`);
        disciplina.addEventListener('change', () => {
            const turmas = turmaGroup.querySelectorAll('.turma');
            if (disciplina.checked) {
                turmas.forEach(turma => turma.disabled = false);
            } else {
                turmas.forEach(turma => {
                    turma.disabled = true;
                    turma.checked = false;
                });
            }
        });
    });
</script>

<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>

