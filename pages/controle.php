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
INNER JOIN prof_turma ON prof_turma.professor_id = usuarios.id_usuarios
INNER JOIN disciplina ON prof_turma.disciplina_id = disciplina.id_disciplina
WHERE usuarios.id_usuarios=:id_usuarios');
   $pesquisa->execute(['id_usuarios' => $id_usuario]);
 //  $pesquisa-> execute();
   $nome = $_SESSION['nome'];
  




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
    <style>
    .input-negrito {
        font-weight: bold; /* Aplica negrito ao texto do input */
    }
     .auto-width-input {
            width: auto;
            min-width: 100px; /* Define uma largura mínima */
            max-width: 100%; /* Limita a largura máxima ao container */
            padding: 0.375rem 0.75rem; /* Mantém o padding do Bootstrap */
        }
         .auto-width-select {
            width: auto; /* Largura automática */
            min-width: 150px; /* Define uma largura mínima */
            padding: 0.375rem 0.75rem; /* Mantém o padding padrão do Bootstrap */
            display: inline-block; /* Permite que a largura se ajuste */
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
            <!-- Grupo 1: Informações do Professor -->
            <fieldset class="border p-3 mb-4">
                <legend class="w-auto px-2">Informações Disciplina / Turma</legend>
                
                <!-- Campo Professor -->
                <div class="mb-3">
                    <label for="professor" class="form-label">Professor:</label>
                    <input type="text" class="form-control auto-width-input input-negrito" id="professor"  placeholder="Nome do Professor" value="<?php echo $nome ?>" readonly>
                     <input type=hidden name="professor" value="<?php echo $nome ?>">
                </div>
                  
                <!-- Campo Matéria -->
                <div class="mb-3">
                    <label for="categoriaSelect" class="form-label">Disciplina:</label><br>
                    <select id="categoriaSelect" class="form-select auto-width-select" name="disciplina" required>
                        <option value="">Escolha Disciplina</option>
                        <?php
                         if ($pesquisa->rowCount() > 0) {
                           while ($row = $pesquisa->fetch(PDO::FETCH_ASSOC)) {
                         echo "<option value={$row['id_disciplina']}>{$row['nome_disciplina']}</option>";
                         }
                    } else {
                        echo "<option>Nenhuma opção disponível</option>";
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

            <!-- Grupo 2: Detalhes da Aula -->
            <fieldset class="border p-3 mb-4">
                <legend class="w-auto px-2">Detalhes da Aula</legend>
                
                <!-- Campo Data -->
                <div class="mb-3">
                    <label for="data" class="form-label">Data:</label></br>
                    <input type="date" class="form-control-sm col-2 auto-width-input " id="data" name="data" required>
                </div>
                
                <!-- Campo Período -->
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

            <!-- Botão Puxar -->
            <button type="submit" class="btn btn-primary">Puxar</button>
        </form>
    </div>

</body>
   <script>
        const categoriaSelect = document.getElementById('categoriaSelect');
        const subcategoriaSelect = document.getElementById('subcategoriaSelect');

        categoriaSelect.addEventListener('change', function() {
            const categoriaId = this.value;
            if (categoriaId) {
                fetch(`./buscar_subcategorias.php?categoria_id=${categoriaId}`)
                    .then(response => response.json())
                    .then(data => {
                       console.log('Resposta do servidor:', data); 
                   //   return JSON.parse(data);
                       
                        subcategoriaSelect.innerHTML = "<option value=''>Selecione uma Turma</option>";
                      

                        data.forEach(subcategoria => {
                          const  option = document.createElement('option');
                            option.value = subcategoria.numero_turma;
                            option.textContent = subcategoria.numero_turma+ " - "+subcategoria.nome_curso;
                            subcategoriaSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Erro ao carregar subcategorias:', error));
            } else {
                subcategoriaSelect.innerHTML = "<option value=''>Selecione uma Turma</option>";
                subcategoriaSelect.disabled = true;
            }
        });
    </script>
 </html>
<?php 
}
}
?>