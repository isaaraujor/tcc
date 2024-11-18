<?php
session_start();
include_once('./pages/conexao.php');

//verifica se o parametro id_usuario foi passado via get
 $id_usuario= $_SESSION['id_usuario'];
   if (isset($_GET['categoria_id'])) {
        $categoria_id = $_GET['categoria_id'];
        //busca informações sobre o relacionamento entre professor e turma
         $stmt = $con->prepare("SELECT  t.numero_turma, t.nome_curso FROM prof_turma pt              
        LEFT JOIN usuarios p ON pt.professor_id = p.id_usuarios 
                LEFT JOIN turma t ON pt.turma_id = t.id_turma 
                LEFT JOIN disciplina m ON pt.disciplina_id = m.id_disciplina
                WHERE p.id_usuarios = ? and m.id_disciplina=?");

       $params = [$id_usuario,$categoria_id];
       $stmt->execute($params);

       //retorna todos os resultados da consulta
        $subcategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //enviar dados estruturados para o front-
        
        echo json_encode($subcategorias);
    } else {
        echo json_encode(["error" => "Categoria não especificada"]);
    }
?>