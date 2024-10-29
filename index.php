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
      case "dados-login":
        include_once("./pages/dados-login.php");
        break;
    case "dashboard":
      include_once("./pages/dashboard.php");
      break;
    case "controle":
      include_once("./pages/controle.php");
      break;
    case "logar":
      include_once("./pages/logar.php");
      break;
    default:
      include_once("./pages/home.php");
    } 
  }
