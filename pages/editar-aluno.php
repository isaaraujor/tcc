<?php
include 'conexao.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $data_nasc = $_POST['data_nasc'];
    $matricula = $_POST['matricula'];
    $rua = $_POST['rua'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $cep = $_POST['cep'];
    $nome_resp = $_POST['nome_resp'];
    $contat_resp = $_POST['contat_resp'];

    try {
        $stmt = $con->prepare("
            UPDATE alunos 
            SET nome = :nome, data_nasc = :data_nasc, matricula = :matricula, rua = :rua, bairro = :bairro,
                cidade = :cidade, CEP = :cep, nome_resp = :nome_resp, contat_resp = :contat_resp 
            WHERE id_alunos = :id
        ");
        $stmt->execute([
            ':nome' => $nome,
            ':data_nasc' => $data_nasc,
            ':matricula' => $matricula,
            ':rua' => $rua,
            ':bairro' => $bairro,
            ':cidade' => $cidade,
            ':cep' => $cep,
            ':nome_resp' => $nome_resp,
            ':contat_resp' => $contat_resp,
            ':id' => $id
        ]);

        echo "<script>alert('Aluno atualizado com sucesso!'); window.location.href = 'listar_alunos';</script>";
    } catch (PDOException $e) {
        echo "Erro ao atualizar aluno: " . $e->getMessage();
    }
} else {
    try {
        $stmt = $con->prepare("SELECT * FROM alunos WHERE id_alunos = :id");
        $stmt->execute([':id' => $id]);
        $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$aluno) {
            echo "<script>alert('Aluno não encontrado!'); window.location.href = 'listar_alunos';</script>";
            exit;
        }
    } catch (PDOException $e) {
        echo "Erro ao buscar aluno: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
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
    </style>
</head>
<body>
    <div class="navb">
        <a href="listar_alunos">
            <img src="img/back.png" alt="Voltar">
        </a>
        <h2>EDITAR ALUNO</h2>
        <p></p>
    </div>
    <div class="container">
        <form method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" class="form-control auto-width-input input-negrito" name="nome" value="<?= htmlspecialchars($aluno['nome']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="data_nasc" class="form-label">Data de Nascimento:</label>
                <input type="date" id="data_nasc" class="form-control auto-width-input" name="data_nasc" value="<?= htmlspecialchars($aluno['data_nasc']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="matricula" class="form-label">Matrícula:</label>
                <input type="text" id="matricula" class="form-control auto-width-input" name="matricula" value="<?= htmlspecialchars($aluno['matricula']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="rua" class="form-label">Rua:</label>
                <input type="text" id="rua" class="form-control auto-width-input" name="rua" value="<?= htmlspecialchars($aluno['rua']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="bairro" class="form-label">Bairro:</label>
                <input type="text" id="bairro" class="form-control auto-width-input" name="bairro" value="<?= htmlspecialchars($aluno['bairro']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade:</label>
                <input type="text" id="cidade" class="form-control auto-width-input" name="cidade" value="<?= htmlspecialchars($aluno['cidade']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="cep" class="form-label">CEP:</label>
                <input type="text" id="cep" class="form-control auto-width-input" name="cep" value="<?= htmlspecialchars($aluno['CEP']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="nome_resp" class="form-label">Nome do Responsável:</label>
                <input type="text" id="nome_resp" class="form-control auto-width-input" name="nome_resp" value="<?= htmlspecialchars($aluno['nome_resp']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="contat_resp" class="form-label">Contato do Responsável:</label>
                <input type="text" id="contat_resp" class="form-control auto-width-input" name="contat_resp" value="<?= htmlspecialchars($aluno['contat_resp']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
