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
        $idUsuario = $con->lastInsertId();

        $queryProfessor = "INSERT INTO professor (nome, data_nascimento, cpf, id_usuario) VALUES (:nome, :data_nascimento, :cpf, :id_usuario)";
        $stmtProfessor = $con->prepare($queryProfessor);
        $stmtProfessor->execute([
            ':nome' => $nome,
            ':data_nascimento' => $data_nascimento,
            ':cpf' => $cpf,
            ':id_usuario' => $idUsuario
        ]);
        $idProfessor = $con->lastInsertId(); 

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

        $con->commit();
        header("location:listar_prof");
    } catch (Exception $e) {
        $con->rollBack();
        echo "Erro ao realizar o cadastro: " . $e->getMessage();
    }
}
?>