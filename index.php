<?php
  session_start();
  include_once("./pages/conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta charset="utf-8">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<TITLE>Controle da turma</title>
<?php
 if(!isset($_GET['url'])){
    $_GET['url']="login";
 }
 if($_GET){
  $url = explode("/",$_GET['url']);
  
  $pagina = $url[0];
  switch($pagina){
    case "login":
      include_once("./pages/login.php");
      break;

    case "dados-login":
      include_once("./pages/dados-login.php");
      break;
   
    case "cadastro":
      include_once("./pages/cadastro.php");
      break; 
    
    case "insere-dados":
      include_once("./pages/insere-dados.php");
      break;

    case "dashboard":
      include_once("./pages/dashboard.php");
      break;

     case "chamada_turma":
      include_once("./pages/chamadaturma.php");
      break;
     
    case "controle":
      include_once("./pages/controle.php");
      break;

    case "historico":
      include_once("./pages/historico.php");
      break;

    case "editar_controle":
      include_once("./pages/editar_controle.php");
      break;

    case "excluir_controle":
      include_once("./pages/excluir_controle.php");
      break;

    case "novoaluno":
      include_once("./pages/novoaluno.php");
      break;

    case "novoprof":
      include_once("./pages/novoprof.php");
      break;

    case "cadalunos":
      include_once("./pages/cadalunos.php");
      break;

    case "cadprof":
      include_once("./pages/cadprof.php");
      break;


    case "acessoneg":
      include_once("./pages/acessoneg.php");
      break;

    case "userperm":
      include_once("./pages/userperm.php");
      break;



    case "teste12345":
      include_once("./pages/teste12345.php");
      break;

    default:
      include_once("./pages/dashboard.php");
    } 
  }