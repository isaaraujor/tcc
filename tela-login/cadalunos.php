<?php

include 'conexao.php'; 

$nome = $_POST['nome'];
$data = $_POST['data'];
$matricula = $_POST['matricula'];
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$cep = $_POST['cep'];
$resp = $_POST['resp'];
$contato = $_POST['contato'];


$stmt = $con->prepare("SELECT COUNT(*) FROM alunos WHERE nome = :nome ");
$stmt->execute(['nome' => $nome]);
$count = $stmt->fetchColumn();

if ($count > 0) {
        "<script>alert('Aluno já cadastrado!'); window.location.href = 'novoaluno.php';</script>";
} else {
        $stmt = $con->prepare("INSERT INTO alunos (nome, data_nasc, matricula, rua, bairro, cidade, CEP, nome_resp, contat_resp) VALUES (:nome, :data_nasc, :matricula, :rua, :bairro, :cidade, :CEP, :nome_resp, :contat_resp)");
        $stmt->execute([
            'nome' => $nome,
            'data_nasc' => $data,
            'matricula' => $matricula,
            'rua' => $rua,
            'bairro' => $bairro,
            'cidade'=> $cidade,
            'CEP' => $cep,
            'nome_resp' => $resp,
            'contat_resp' => $contato

        ]);

        header("location:novoaluno.php");
    }
?>