<?php
$host = "localhost";
$user = "root";
$pass = "";
$banco = "contchamada";
$port = 3306;
try{
  $con = new PDO("mysql:host=$host;port=$port;dbname=".$banco,$user,$pass);

}catch(PDOException $erro){
  echo "Erro Conexão ".$erro->getMessage();
}