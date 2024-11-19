<?php
include 'conexao.php'; 

$nome = $_POST['nome'];
$data_nasc = $_POST['data_nasc'];
$login= $_POST['login'];
$disciplina = $_POST['disciplina'];
$turma = $_POST['turma'];
$senha = $_POST['senha'];



$stmt = $con->prepare("SELECT COUNT(*) FROM professor WHERE nome = :nome ");
$stmt->execute(['nome' => $nome]);
$count = $stmt->fetchColumn();

if ($count > 0) {
        "<script>alert('Professor já cadastrado!'); window.location.href = 'novoprof';</script>";
} else {
        $stmt = $con->prepare("INSERT INTO professor (nome, data_nascimento,cpf) VALUES (:nome, :data_nascimento, :cpf)");
        $stmt->execute([
            'nome' => $nome,
            'data_nascimento' => $data_nasc,
            'cpf' => $login,
        ]);
        header("location:novoprof");
    }
?>