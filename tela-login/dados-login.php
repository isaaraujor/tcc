<?php 
include_once('conexao.php');


  require_once('conexao.php');

  $login = $_POST['login'];
  $senha = $_POST['senha'];

  $sqlSenha = "SELECT senha FROM usuarios WHERE login = :login"; // ajuste conforme necessário
  $result = $conn->query($sqlSenha);
  $result -> bindValue("login",$login);
  
  //  Recuperar o resultado
  if ($result->num_rows > 0) {
      // Armazena o valor na variável
      $row = $result->fetch_assoc();
      $corectSenha = $row['senha']; // 'valor' é o nome da coluna
      echo "O valor é: " . $corectSenha;
  }



//   $sql = "SELECT * FROM usuarios WHERE login= :login AND senha = :senha";

//   $resultado = $con -> prepare($sql);

//   $resultado -> bindValue("login",$login);
//   $resultado -> bindValue("senha",$corectSenha);

//   $resultado -> execute();

//   $campo = $resultado -> fetch();
  
//   if($resultado -> rowCount()>0){
//      $_SESSION['logado']=1;
//      header("location:dashboard.php");
//   }else{
//    echo "<script>alert('Usuário não existe!');</script>";
//   }

  ?>