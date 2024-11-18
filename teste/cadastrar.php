<?php
$link = mysqli_connect("localhost", "root", "", "contchamada");
$turma_arquivo = "354.txt";
$arquivo = fopen($turma_arquivo,"r");
$chave =4;
while (($linha = fgets($arquivo)) !== false) {
    $palavra = trim($linha);
    $tamanho = strlen($palavra);
    echo $matricula = trim(substr($palavra,$tamanho-10,$tamanho));
    echo " ";
    echo $nomealuno= trim(substr($palavra,0,$tamanho-10));
    echo "<br>";
    $sql= "Insert into alunos(nome,matricula,id_turma) Value('$nomealuno','$matricula','$chave')";
    mysqli_query($link,$sql);
}

