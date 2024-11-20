
<?php
// Incluindo a conexão com o banco de dados
include_once 'conexao.php'; // Certifique-se de que a conexão retorna um objeto PDO

// Verificando se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtendo os dados enviados do formulário
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $cpf = $_POST['cpf'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); // Criptografar a senha
    $disciplinas = isset($_POST['disciplina']) ? $_POST['disciplina'] : [];
    $turmas = isset($_POST['turma']) ? $_POST['turma'] : [];

    try {
        // Iniciando uma transação no PDO
        $con->beginTransaction();

        // Inserir dados na tabela 'professor'
        $queryProfessor = "INSERT INTO professor (nome, data_nascimento, cpf, senha) VALUES (:nome, :data_nascimento, :cpf, :senha)";
        $stmtProfessor = $con->prepare($queryProfessor);
        $stmtProfessor->execute([
            ':nome' => $nome,
            ':data_nascimento' => $data_nascimento,
            ':cpf' => $cpf,
            ':senha' => $senha
        ]);
        $idProfessor = $con->lastInsertId(); // Obtendo o ID do professor inserido

        // Preparar as queries para inserção e seleção
        $queryInsertDisciplina = "INSERT INTO disciplina (nome_disciplina) VALUES (:nome_disciplina) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)";
        $queryInsertTurma = "INSERT INTO turma (numero_turma) VALUES (:numero_turma) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)";
        $queryDiscTurma = "INSERT INTO disc_turma (id_professor, id_disciplina, id_turma) VALUES (:id_professor, :id_disc, :id_turma)";

        $stmtInsertDisciplina = $con->prepare($queryInsertDisciplina);
        $stmtInsertTurma = $con->prepare($queryInsertTurma);
        $stmtDiscTurma = $con->prepare($queryDiscTurma);

        // Inserir disciplinas e turmas e registrar as combinações
        foreach ($disciplinas as $disciplina) {
            // Inserir ou obter o ID da disciplina
            $stmtInsertDisciplina->execute([':nome_disciplina' => $disciplina]);
            $idDisciplina = $con->lastInsertId();

            foreach ($turmas as $turma) {
                // Inserir ou obter o ID da turma
                $stmtInsertTurma->execute([':numero_turma' => $turma]);
                $idTurma = $con->lastInsertId();

                // Inserir na tabela 'disc_turma'
                $stmtDiscTurma->execute([
                    ':id_professor' => $idProfessor,
                    ':id_disc' => $idDisciplina,
                    ':id_turma' => $idTurma
                ]);
            }
        }

        // Comitar a transação se tudo deu certo
        $con->commit();
        echo "Cadastro realizado com sucesso!";
    } catch (Exception $e) {
        // Reverter a transação em caso de erro
        $con->rollBack();
        echo "Erro ao realizar o cadastro: " . $e->getMessage();
    }
}
?>
