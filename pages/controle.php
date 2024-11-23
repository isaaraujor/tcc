<?php 
  $tipo = $_SESSION['tipo'];
if($tipo == 's'){
    header("Location: userperm");
}
else{


if(!isset($_SESSION['logado'])){
    header("Location: acessoneg");
}else{
  $id_usuario = $_SESSION['id_usuario'];
  $pesquisa = $con->prepare('SELECT DISTINCT usuarios.nome,
disciplina.nome_disciplina,disciplina.id_disciplina
FROM usuarios

INNER JOIN disc_turma ON disc_turma.id_professor = usuarios.id_usuarios
INNER JOIN disciplina ON disc_turma.id_disc = disciplina.id_disciplina

WHERE usuarios.id_usuarios=:id_usuarios');
   $pesquisa->execute(['id_usuarios' => $id_usuario]);
   $nome = $_SESSION['nome'];



   $queryPesquisaProfessor = "SELECT id_professor FROM professor WHERE id_usuario = :id_usuario";
   $stmtPesquisaProfessor = $con->prepare($queryPesquisaProfessor);
   $stmtPesquisaProfessor->bindValue(':id_usuario', $id_usuario, PDO::PARAM_STR);
   $stmtPesquisaProfessor->execute();
   if ($stmtPesquisaProfessor->rowCount() > 0) {
       while ($row = $stmtPesquisaProfessor->fetch(PDO::FETCH_ASSOC)) {
           $idProfessor = $row['id_professor']; 
        }
    } else {
        echo "Nenhum professor encontrado";
    }
    $queryPesquisaDisciplina = "SELECT id_disc FROM disc_turma WHERE id_professor = :id_professor";
    $stmtPesquisaDisciplina = $con->prepare($queryPesquisaDisciplina);
    $stmtPesquisaDisciplina->bindValue(':id_professor', $idProfessor, PDO::PARAM_STR);
    $stmtPesquisaDisciplina->execute();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
 
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Controle da turma</title>
  <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="css/cont.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    .input-negrito {
        font-weight: bold; 
    }
     .auto-width-input {
            width: auto;
            min-width: 100px;
            max-width: 100%; 
            padding: 0.375rem 0.75rem; 
        }
         .auto-width-select {
            width: auto; 
            min-width: 150px; 
            padding: 0.375rem 0.75rem;
            display: inline-block; 
        }
</style>

</head>
<body>
    <div class="navb">
    <a href="dashboard">
            <img src="img/back.png" height="40px">
        </a>
      <h2>CONTROLE PROFESSOR</h2>
      <p></p>
    </div>
<body>
    <div class="container bg-light p-3 mb-3">
        <h3 class="mb-4">Formulário de Cadastro de Faltas</h3>
        <form method = 'POST' action="chamada_turma">
            
            <fieldset class="border p-3 mb-4">
                <legend class="w-auto px-2">Informações Disciplina / Turma</legend>
                
                
                <div class="mb-3">
                    <label for="professor" class="form-label">Professor:</label>
                    <input type="text" class="form-control auto-width-input input-negrito" id="professor"  placeholder="Nome do Professor" value="<?php echo $nome ?>" readonly>
                     <input type=hidden name="professor" value="<?php echo $nome ?>">
                </div>
                  
                
                <div class="mb-3">
                    <label for="categoriaSelect" class="form-label">Disciplina:</label><br>
                    <select id="categoriaSelect" class="form-select auto-width-select" name="disciplina" required>
                        <option value="">Escolha Disciplina</option>
                        <?php
                            if ($stmtPesquisaDisciplina->rowCount() > 0) {
                                $idAnterior = null;
                                while ($row = $stmtPesquisaDisciplina->fetch(PDO::FETCH_ASSOC)) {
                                    $idDisciplina = $row['id_disc']; 

                                    if ($idDisciplina !== $idAnterior) {

                                        $querySelectDisciplina = "SELECT nome_disciplina FROM disciplina WHERE id_disciplina = :idDisciplina";
                                        $stmtSelectDisciplina = $con->prepare($querySelectDisciplina);
                                        $stmtSelectDisciplina->bindValue(':idDisciplina', $idDisciplina, PDO::PARAM_STR);
                                        $stmtSelectDisciplina->execute();
                                        if ($stmtSelectDisciplina->rowCount() > 0) {
                                            while ($row = $stmtSelectDisciplina->fetch(PDO::FETCH_ASSOC)) {
                                                $nomeDisciplina = $row['nome_disciplina']; 
                                                echo"<option value=$idDisciplina>$nomeDisciplina</option>";
                                             }
                                         } else {
                                             echo "Nenhuma disciplina encontrada";
                                         }

                                    }
                            
                                    $idAnterior = $idDisciplina;
                                 }
                             } else {
                                 echo "Nenhuma disciplina encontrada";
                             }
                         ?>
                    </select>
                </div>
                 <div class="mb-3">
                    <label for="subcategoriaSelect" class="form-label">Turma</label><br>
                <select id="subcategoriaSelect" class="form-select auto-width-select" name="turma" required>
                    <option value="">Selecione uma Turma</option>
                </select>
                </div>
            </fieldset>
            
            
            <fieldset class="border p-3 mb-4">
                <legend class="w-auto px-2">Detalhes da Aula</legend>
                
                
                <div class="mb-3">
                    <label for="data" class="form-label">Data:</label></br>
                    <input type="date" class="form-control-sm col-2 auto-width-input " id="data" name="data" required>
                </div>
                
                
                <div class="mb-3">
                    <label for="periodo" class="form-label">Período:</label><br>
                    <select class="form-select auto-width-select" id="periodo" name= "periodo" required>
                        <option value="" selected>Escolha o Período</option>
                        <option value="Matutino">Matutino</option>
                        <option value="Vespertino">Vespertino</option>
                        <option value="Noturno">Noturno</option>
                    </select>
                </div>

                 <div class="row-md-1">
                    <label for="periodo" class="form-label">Qtde Aulas:</label><br>
                    <input type="text" class="form-control-sm col-1 " id="qtde" name="qtde" required>
                </div>
            </fieldset>

            <button type="submit" class="btn btn-primary">Puxar</button>
        </form>
    </div>
</body>

    <script>
        $(document).ready(function () {
            $('#categoriaSelect').change(function () {
                const idDisciplina = $(this).val(); // Obtém o ID da disciplina selecionada
                if (idDisciplina) {
                    // Faz uma requisição AJAX para buscar as turmas
                    $.ajax({
                        url: 'buscar_turmas.php', // Arquivo PHP que processará a consulta
                        type: 'POST',
                        data: { id_disciplina: idDisciplina },
                        success: function (response) {
                            // Atualiza o <select> de turmas com as opções recebidas
                            $('#subcategoriaSelect').html(response);
                        },
                        error: function () {
                            alert('Erro ao buscar as turmas.');
                        }
                    });
                } else {
                    // Limpa o <select> de turmas se nenhuma disciplina estiver selecionada
                    $('#subcategoriaSelect').html('<option value="">Selecione uma Turma</option>');
                }
            });
        });
    </script>
 </html>
<?php 
}
}
?>