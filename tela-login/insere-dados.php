<?php
include 'conexao.php'; 

$nome = $_POST['nome'];
$login = $_POST['login'];
$senha = $_POST['senha'];
$tipo = $_POST['tipo'];

$sql = "INSERT INTO usuarios (nome, login, senha, tipo) VALUES ('$nome', '$login', '$senha', '$tipo')";

if ($con->query($sql) === TRUE) {
  echo "<script>alert('Login feito com sucesso!');</script>";
} else {
    echo "erro: " . $sql . "<br>" . $con->error;
}
$con->close();
?>