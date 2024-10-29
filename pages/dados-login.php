<?php
session_start();
include 'conexao.php'; 

$login = $_POST['login']; 
$senha = $_POST['senha']; 

$stmt = $con->prepare("SELECT senha FROM usuarios WHERE login = :login");
$stmt->execute(['login' => $login]);
$senhaArmazenada = $stmt->fetchColumn();

if ($senhaArmazenada) {
    if (password_verify($senha, $senhaArmazenada)) {
        $_SESSION['logado'] = 1;
        header("location:dashboard");
        exit;
    } else {
       echo "<script>alert('Senha incorreta!'); window.location.href = 'index.php';</script>";
    }
} else {
    echo "<script>alert('Login não encontrado!'); window.location.href = 'index.php';</script>";
}
?>
