<?php
include 'conexao.php'; 

$nome = $_POST['nome'];
$login = $_POST['login'];
$senha = $_POST['senha'];
$tipo = $_POST['tipo'];

$stmt = $con->prepare("SELECT login FROM usuarios WHERE login = ?");
$username = $login; // Substitua pelo nome de usuário desejado
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

echo"$stmt";


// if($user == $login){

//   echo "<script>alert('Usuário já existe!');</script>";
  
// }
//else{
//   $sql = "INSERT INTO usuarios (nome, login, senha, tipo) VALUES ('$nome', '$login', '$senha', '$tipo')";

//   if ($con->query($sql) === TRUE) {
//     echo "<script>alert('Cadastro feito com sucesso!');</script>";
//   } else {
//       echo "erro: " . $sql . "<br>" . $con->error;
//   }
//   $con->close();
// }

?>