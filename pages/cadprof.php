<?php
include_once 'conexao.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = 'p';
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $cpf = $_POST['cpf'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); 
    $disciplinas = isset($_POST['disciplinas']) ? $_POST['disciplinas'] : [];
    $turmas = isset($_POST['turmas']) ? $_POST['turmas'] : [];

    try {
        $con->beginTransaction();

        $queryUsuarioProf = "INSERT INTO usuarios (nome, login, senha, tipo) VALUES (:nome, :login, :senha, :tipo)";
        $stmtUsuarioProf = $con->prepare($queryUsuarioProf);
        $stmtUsuarioProf->execute([
            ':nome' => $nome,
            ':login' => $cpf,
            ':senha' => $senha,
            ':tipo' => $tipo
        ]);

        $queryProfessor = "INSERT INTO professor (nome, data_nascimento, cpf) VALUES (:nome, :data_nascimento, :cpf)";
        $stmtProfessor = $con->prepare($queryProfessor);
        $stmtProfessor->execute([
            ':nome' => $nome,
            ':data_nascimento' => $data_nascimento,
            ':cpf' => $cpf
        ]);
        $idProfessor = $con->lastInsertId(); 


        $queryInsertDisciplina = "INSERT INTO disciplina (nome_disciplina) VALUES (:nome_disciplina) ON DUPLICATE KEY UPDATE id_disciplina=LAST_INSERT_ID(id_disciplina)";
        $queryInsertTurma = "INSERT INTO turma (numero_turma, nome_curso) VALUES (:numero_turma, :nome_curso) ON DUPLICATE KEY UPDATE id_turma=LAST_INSERT_ID(id_turma)";

        $stmtInsertDisciplina = $con->prepare($queryInsertDisciplina);
        $stmtInsertTurma = $con->prepare($queryInsertTurma);
       
        foreach ($disciplinas as $disciplina) {
            
            $stmtInsertDisciplina->execute([':nome_disciplina' => $disciplina]);
            $idDisciplina = $con->lastInsertId();

          
            if (isset($turmas[$disciplina])) {
                foreach ($turmas[$disciplina] as $turma) {
                    $nome_curso = 'Informática'; //mudar aqui de alguma forma
                    $stmtInsertTurma->execute([
                        ':numero_turma' => $turma,
                        ':nome_curso' => $nome_curso,
                    ]);
                    $idTurma = $con->lastInsertId();

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

        $con->commit();
        header("location:novoprof");
    } catch (Exception $e) {
        $con->rollBack();
        echo "Erro ao realizar o cadastro: " . $e->getMessage();
    }
}
?>