<?php 
session_start();
if(!isset($_SESSION['logado'])){
    header("Location: acessoneg.php");
}else{

include 'conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Histórico de controle</title>
  <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="css/hist.css">
</head>
<body>
  <div class="navb">
  <a href="dashboard.php">
            <img src="img/back.png" height="40px">
        </a>
    <h2>HISTÓRICO</h2>
    <p></p>
</div>

</body>
</html>
<?php
}
?>