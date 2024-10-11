<?php 
include_once('conexao.php');


  require_once('conexao.php');
  $login = $_POST['login'];
  $senha = $_POST['senha'];
  $sql = "SELECT * FROM usuarios WHERE login= :login AND senha = :senha";
  $resultado = $con -> prepare($sql);
  $resultado -> bindValue("login",$login);
  $resultado -> bindValue("senha",$senha);
  $resultado -> execute();
  $campo = $resultado -> fetch();
  if($resultado -> rowCount()>0){
     $_SESSION['logado']=1;
     header("location:dashboard.php");
  }else{
   echo "<script>alert('Usuário não existe!');</script>";
  }

  ?>