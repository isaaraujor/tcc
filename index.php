<?php
  session_start();
  
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

    case "cadastro":
      include_once("./pages/cadastro.php");
      break; 

    case "dashboard":
      include_once("./pages/dashboard.php");
      break;

    case "controle":
      include_once("./pages/controle.php");
      break;

    case "historico":
      include_once("./pages/historico.php");
      break;

    case "novoaluno":
      include_once("./pages/novoaluno.php");
      break;

    default:
      include_once("./pages/dashboard.php");
    } 
  }
