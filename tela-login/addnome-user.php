<?php
include 'conexao.php'; 

$sql = "SELECT nome FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Saída do primeiro resultado
    $row = $result->fetch_assoc();
    $nome = $row['nome'];
} 
$conn->close();  

?>