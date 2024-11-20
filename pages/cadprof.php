<?php
include_once 'conexao.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $cpf = $_POST['cpf'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); 
    $disciplinas = isset($_POST['disciplinas']) ? $_POST['disciplinas'] : [];
    $turmas = isset($_POST['turmas']) ? $_POST['turmas'] : [];

    try {
        $con->beginTransaction();

        $queryProfessor = "INSERT INTO professor (nome, data_nascimento, cpf, senha) VALUES (:nome, :data_nascimento, :cpf, :senha)";
        $stmtProfessor = $con->prepare($queryProfessor);
        $stmtProfessor->execute([
            ':nome' => $nome,
            ':data_nascimento' => $data_nascimento,
            ':cpf' => $cpf,
            ':senha' => $senha
        ]);
        $idProfessor = $con->lastInsertId(); 


        $queryInsertDisciplina = "INSERT INTO disciplina (nome_disciplina) VALUES (:nome_disciplina) ON DUPLICATE KEY UPDATE id_disciplina=LAST_INSERT_ID(id_disciplina)";
        $queryInsertTurma = "INSERT INTO turma (numero_turma) VALUES (:numero_turma) ON DUPLICATE KEY UPDATE id_turma=LAST_INSERT_ID(id_turma)";
        $queryDiscTurma = "INSERT INTO disc_turma (id_professor, id_disc, id_turma) VALUES (:id_professor, :id_disc, :id_turma)";

        $stmtInsertDisciplina = $con->prepare($queryInsertDisciplina);
        $stmtInsertTurma = $con->prepare($queryInsertTurma);
        $stmtDiscTurma = $con->prepare($queryDiscTurma);

       
        foreach ($disciplinas as $disciplina) {
            
            $stmtInsertDisciplina->execute([':nome_disciplina' => $disciplina]);
            $idDisciplina = $con->lastInsertId();

          
            if (isset($turmas[$disciplina])) {
                foreach ($turmas[$disciplina] as $turma) {
                  
                    $stmtInsertTurma->execute([':numero_turma' => $turma]);
                    $idTurma = $con->lastInsertId();

                  
                    $stmtDiscTurma->execute([
                        ':id_professor' => $idProfessor,
                        ':id_disc' => $idDisciplina,
                        ':id_turma' => $idTurma
                    ]);
                }
            }
        }

        $con->commit();
        header("location:novoprof");
    } catch (Exception $e) {
        $con->rollBack();
        echo "Erro ao realizar o cadastro: " . $e->getMessage();
    }
}
?>
