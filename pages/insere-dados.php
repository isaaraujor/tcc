<?php
session_start();
include 'conexao.php'; 

$nome = $_POST['nome'];
$login = $_POST['login'];
$senha = $_POST['senha'];
$tipo = $_POST['tipo'];

$stmt = $con->prepare("SELECT COUNT(*) FROM usuarios WHERE login = :login ");
$stmt->execute(['login' => $login]);
$count = $stmt->fetchColumn();

if ($count > 0) {
        "<script>alert('Login já existe!'); window.location.href = 'cadastro';</script>";
} else {
        $stmt = $con->prepare("INSERT INTO usuarios (nome, login, senha, tipo) VALUES (:nome, :login, :senha, :tipo)");
        $stmt->execute([
            'nome' => $nome,
            'login' => $login,
            'senha' => password_hash($senha, PASSWORD_DEFAULT),
            'tipo' => $tipo
        ]);
        header("location:login");
    }
?>