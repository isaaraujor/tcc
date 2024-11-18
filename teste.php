<?php
include_once('./pages/conexao.php');
   $_GET['categoria_id']=1;
   if (isset($_GET['categoria_id'])) {
        $categoria_id = $_GET['categoria_id'];
        $stmt = $con->prepare("SELECT pt.id_prof_turma, p.id_usuario, p.nome, m.nome_disciplina, t.numero_turma FROM prof_turma pt              LEFT JOIN usuario p ON pt.professor_id = p.id_usuario 
                LEFT JOIN turma t ON pt.turma_id = t.id_turma 
                LEFT JOIN disciplina m ON pt.disciplina_id = m.id_disciplina
                WHERE p.id_usuario = 1");
       // $stmt->execute(['categoria_id' => $categoria_id]);
       $stmt->execute();
        $subcategorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r($subcategorias);
        
      //  echo json_encode($subcategorias); // Retorna as subcategorias como JSON
    }
?>  