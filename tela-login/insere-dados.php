<?php
include 'conexao.php'; 

$nome = $_POST['nome'];
$email = $_POST['login'];
$senha = $_POST['senha'];
$tipo = $_POST['tipo'];

$stmt = $con->prepare("SELECT COUNT(*) FROM usuarios WHERE login = :login ");
$stmt->execute(['login' => $email]);
$count = $stmt->fetchColumn();

if ($count > 0) {
        echo "<script>alert('Login já existente!');</script>";
} else {
        $stmt = $con->prepare("INSERT INTO usuarios (nome, login, senha, tipo) VALUES (:nome, :login, :senha, :tipo)");
        $stmt->execute([
            'nome' => $nome,
            'login' => $email,
            'senha' => password_hash($senha, PASSWORD_DEFAULT),
            'tipo' => $tipo
        ]);
        header("location:index.php");
    }
?>