<?php
include 'conexao.php'; 

$nome = $_POST['nome'];
$data_nasc = $_POST['data_nasc'];
$matricula = $_POST['matricula'];
$numero_turma = $_POST['numero_turma']; 
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$cep = $_POST['cep'];
$nome_resp = $_POST['nome_resp'];
$contat_resp = $_POST['contat_resp'];


$stmt = $con->prepare("SELECT COUNT(*) FROM alunos WHERE nome = :nome");
$stmt->execute(['nome' => $nome]);
$count = $stmt->fetchColumn();

if ($count > 0) {
    echo "<script>alert('Aluno já cadastrado!'); window.location.href = 'novoaluno';</script>";
} else {

    $stmt = $con->prepare("SELECT id_turma FROM turma WHERE numero_turma = :numero_turma");
    $stmt->execute(['numero_turma' => $numero_turma]);
    $id_turma = $stmt->fetchColumn();

    if ($id_turma) {
       
        $stmt = $con->prepare("
            INSERT INTO alunos 
            (nome, data_nasc, matricula, rua, bairro, cidade, CEP, nome_resp, contat_resp, id_turma) 
            VALUES 
            (:nome, :data_nasc, :matricula, :rua, :bairro, :cidade, :CEP, :nome_resp, :contat_resp, :id_turma)
        ");
        $stmt->execute([
            'nome' => $nome,
            'data_nasc' => $data_nasc,
            'matricula' => $matricula,
            'rua' => $rua,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'CEP' => $cep,
            'nome_resp' => $nome_resp,
            'contat_resp' => $contat_resp,
            'id_turma' => $id_turma
        ]);

        header("location:novoaluno");
    } else {
  
        echo "<script>alert('Número de turma inválido!'); window.location.href = 'novoaluno';</script>";
    }
}
?>
