<?php 
if(!isset($_SESSION['logado'])){
    header("Location: acessoneg");
    exit;
} 
  if(!isset($_POST['btnfaltas'])){
    ?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php

   $nome= $_POST['professor'];
   $periodo = $_POST['periodo'];
   $id_disciplina = $_POST['disciplina'];
   $turma= $_POST['turma'];
   $qtdeaulas = $_POST['qtde'];

  $data= $_POST['data'];
  $pesquisa = $con->prepare("Select nome_disciplina From disciplina where id_disciplina =:id_disciplina");
  $pesquisa->execute(['id_disciplina' => $id_disciplina]);
  $row = $pesquisa->fetch(PDO::FETCH_ASSOC);
  $disciplina = $row['nome_disciplina'];

  $pesquisa1 = $con->prepare("Select id_alunos,nome,matricula,turma.id_turma From alunos 
                            INNER JOIN turma ON turma.id_turma  = alunos.id_turma
                            WHERE turma.id_turma =:turma");
   $pesquisa1 -> execute(['turma' => $turma]);
   $row = $pesquisa1->fetch(PDO::FETCH_ASSOC);
   $idturma= $row['id_turma'];

   $sqlNumTurma = $con->prepare("SELECT numero_turma FROM turma WHERE id_turma = :id_turma");
   $sqlNumTurma->execute(['id_turma' => $idturma]);
   $row2 = $sqlNumTurma->fetch(PDO::FETCH_ASSOC);
   $num_turma = $row2['numero_turma'];
   
?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Controle da turma</title>
  <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="css/cont.css">
    <style>
    .input-negrito {
        font-weight: bold; 
    }
     .auto-width-input {
            width: auto;
            min-width: 100px; 
            max-width: 100%; 
            padding: 0.375rem 0.75rem; 
            display: inline-block;
        }
         .auto-width-select {
            width: auto; 
            min-width: 100px; 
            max-width: 100%; 
            padding: 0.375rem 0.75rem; 
            display: inline-block; 
        }
      .input-custom-size {
            width: 30px;   
            height: 30px;  
        }
        .campo-pequeno {
            width: 50px;
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
    <div class="container bg-light p-3 mb-3">
        <h3 class="mb-4">Chamada Turma</h3>
        <form method = 'POST' action="chamada_turma">
           

            <fieldset class="border p-3 mb-4">
              <div class="row mb-2">
                <div class="col-md-auto" >
                    <label for="professor" class="form-label"><b>Professor</b></label><br>
                    <input type="text" class="form-control auto-width-input" id="professor" name="professor" placeholder="Professor" value="<?php echo $nome ?>" readonly>
                </div>

                <div class="col-md-5">
                    <label for="disciplina" class="form-label"><b>Disciplina</b></label>
                    <input type="text" class="form-control auto-width-input" id="disciplina" name ="disciplina" size="150px" placeholder="Disciplina" value="<?php echo $disciplina ?>" readonly>
                    <input type=hidden name="id_disciplina" value="<?php echo $id_disciplina ?>">
                </div>

          </div>
          <div class="row mb-3">
             <div class="col-md-auto">
                    <label for="turma" class="form-label"><b>Turma</b></label><br>
                    <input type="text" class="form-control" id="turma" name="turma" placeholder="Turma"  value="<?php echo $num_turma ?>" readonly>
             </div>

             <div class="col-md-2">
                    <label for="data" class="form-label"><b>Data</b></label>
                    <input type="date" class="form-control auto-width-input" id="data" name="data" placeholder="Data" value="<?php echo $data ?>"readonly>
               </div>

                <div class="col-md-2">
                    <label for="periodo" class="form-label"><b>Periodo</b></label>
                    <input type="text" class="form-control auto-width-input " id="periodo" name="periodo" placeholder="Data" value="<?php echo $periodo ?>"readonly>
               </div>

                <div class="col-md-1">
                    <label for="periodo" class="form-label"><b>Qtde</b></label>
                    <input type="text" class="form-control " id="qtde" name="qtde" placeholder="Qtde" value="<?php echo $qtdeaulas ?>"readonly>
               </div>
            </div>

             <table class="table table-striped table-bordered table-hover w-auto">
        <thead class="thead-dark" align=center>
            <tr>

                <th align=center>Nome Aluno</th>
                <th>Faltas</th>
            </tr>
        </thead>
        <tbody>
            <?php
               while ($row = $pesquisa1->fetch(PDO::FETCH_ASSOC)) { 
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                  $nome=htmlspecialchars($row['nome']);
                  echo "<input type='hidden' name= 'nomealuno[]'  value=  '$nome'>";
                  echo "<input type='hidden' name='idaluno[]' value=".$row['id_alunos'].">";
                  echo "<td><input type= 'text' name='qtdefaltas[]' class='input-custom-size' value=0 ></td>";
                  echo "</div>";
              }
             
              
            ?>

            </table>
            <input type=hidden name="ultimo" value="<?php echo $ultimoId ?>">
            <button type="submit" name="btnfaltas" class="btn btn-primary">Enviar Faltas</button>
        </form>
    </div>
    <?php
    }else{

    
    $qtdeaulas = $_POST['qtde'];
    $periodo=$_POST['periodo'];
    $nome= $_POST['professor'];
    $id_disciplina = $_POST['id_disciplina'];
    $turma= $_POST['turma'];
    $data= $_POST['data'];
    $pesquisa = $con->prepare("Select nome_disciplina From disciplina where id_disciplina =:id_disciplina");
    $pesquisa->execute(['id_disciplina' => $id_disciplina]);
    $row = $pesquisa->fetch(PDO::FETCH_ASSOC);
    $disciplina= $row['nome_disciplina'];
    
    //*********************************************************************/

    $cadastrar=true;
    $sql_cadastro = "SELECT * from controle";
    $pesquisa_controle = $con ->prepare($sql_cadastro);
    $pesquisa_controle -> execute();
    while($encontrado = $pesquisa_controle->fetch(PDO::FETCH_ASSOC)){
      if($encontrado['data_cont']== $data && $encontrado['turma']==$turma && $encontrado['periodo']== $periodo && 
       $encontrado['materia']==$disciplina && 
       $encontrado['professor']== $nome){
       $cadastrar= false;
      }
    }
    

     if($cadastrar == true){
     $sql_inserecontrole= "Insert into controle(data_cont,turma,periodo,materia,professor,qtde_aula)Values(:data,:turma,:periodo,:materia,:professor,:qtde)";
     $insere_controle = $con ->prepare($sql_inserecontrole);
     $dados = [':data'=>$data,':turma'=>$turma,':periodo'=>$periodo,':materia'=>$disciplina,':professor'=>$nome,':qtde'=>$qtdeaulas];
     $insere_controle -> execute($dados);
    
     }

   ?>
        <head>
        <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Controle da turma</title>
  <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="css/cont.css">
     <style>
    .input-negrito {
        font-weight: bold; 
    }
    .campo-pequeno {
            width: 30px;
        }
    </style>


    </head>
         <div class="navb">
    <a href="dashboard">
            <img src="img/back.png" height="40px">
        </a>
      <h2>CONTROLE PROFESSOR</h2>
      <p></p>
    </div>
     <div class="container bg-light">
        <h3 class="mb-4">Demonstrativo Faltas</h3>
        <form method ='POST' action="chamada_turma">
            
            <fieldset class="border p-2 mb-12">
            <div class="row">
                <div class="col-md-auto" >
                    <label for="professor" class="form-label"><b>Professor</b></label><br>
                    <input type="text" class="form-control input-negrito" id="professor" placeholder="Professor" value="<?php echo $nome ?>" readonly>
                </div>


                <div class="col-md-5">
                    <label for="disciplina" class="form-label"><b>Disciplina</b></label>
                    <input type="text" class="form-control input-negrito" id="disciplina" name="disciplina" placeholder="Disciplina" value="<?php echo $disciplina ?>" readonly>
                </div>

               <div class="row mb-4 p-md-3">
             <div class="col-md-auto">
                    <label for="turma" class="form-label"><b>Turma</b></label><br>
                    <input type="text" class="form-control w-25 input-negrito" id="turma" name="turma" placeholder="Turma"  value="<?php echo $turma ?>" readonly>
             </div>

             <div class="col-md-3">
                    <label for="data" class="form-label"><b>Data</b></label>
                    <input type="date" class="form-control auto-width-input input-negrito" id="data" name="data" placeholder="Data" value="<?php echo $data ?>"readonly>
               </div>

                <div class="col-md-3">
                    <label for="periodo" class="form-label"><b>Periodo</b></label>
                    <input type="text" class="form-control auto-width-input input-negrito " id="periodo" name="periodo" placeholder="Data" value="<?php echo $periodo ?>"readonly>
               </div>

               <div class="col-md-1">
                    <label for="periodo" class="form-label"><b>Qtde</b></label>
                    <input type="text" class="form-control auto-width-input input-negrito " id="periodo" name="periodo" placeholder="Data" value="<?php echo $qtdeaulas ?>"readonly>
               </div>
            </div>
              
        <table class="table table-striped table-bordered table-hover w-auto">
        <thead class="thead-dark" align=center>
            <tr>
                <th align=center>Nome Aluno<br>&nbsp;  </th>
                <th>Faltas<br>Hoje</th>
              </tr>
        </thead>
        <tbody>
        <?php
        
         $sql_cadastro = "SELECT id_controle FROM controle ORDER BY id_controle DESC LIMIT 1";
         $ultimo_id = $con ->prepare($sql_cadastro);
         $ultimo_id -> execute();
         $ultimo_resu = $ultimo_id->fetch(PDO::FETCH_ASSOC);
         $ultimoId = $ultimo_resu['id_controle'];

        $nomes = $_POST['nomealuno'];
        $idalunos=$_POST['idaluno'];
        $qtdefaltas = $_POST['qtdefaltas'];
        $tamanho = count($nomes);
        $i=0;

         $cadastrar1=true;
         $sql_cadastro1 = "SELECT controle_id from falta";
         $pesquisa_controle1 = $con ->prepare($sql_cadastro1);
         $pesquisa_controle1 -> execute();
       
          while($encontrado1 = $pesquisa_controle1->fetch(PDO::FETCH_ASSOC)){
              echo $ultimoId;
            if($encontrado1['controle_id'] == $ultimoId ){
               $cadastrar1= false;
          }
        }
        
        if($cadastrar1 == true){
        $sql_insere = "INSERT Into falta(controle_id,aluno_id,qtde_faltas) VALUES(:controleId,:id_aluno,:qtdefalta)";
        while($i<$tamanho){
            echo "<tr>";
            echo "<td><b>".$nomes[$i]."</td>";
            if($qtdefaltas[$i] > 0){
                "<td style='background-color: lightcoral;' align=center><input type=text class='campo-pequeno' name='qtde' value=$qtdefaltas[$i] size=5 disabled></td>";
          echo "<td style='background-color: lightcoral;' align=center disabled><b>".$qtdefaltas[$i]."</td>";
            $insere = $con ->prepare($sql_insere);
            $dados = [':controleId'=>$ultimoId,':id_aluno'=>$idalunos[$i],':qtdefalta'=>$qtdefaltas[$i]];
            $insere -> execute($dados);
            } else{
              echo "<td align=center><input type=text class='campo-pequeno' name='qtde' value=$qtdefaltas[$i] size=5 disabled></td>";    
            }
         
            $i++;
        }
          echo "</table>";
      }else{
         while($i<$tamanho){
            echo "<tr>";
            echo "<td><b>".$nomes[$i]."</td>";
            if($qtdefaltas[$i] > 0){
            echo "<td style='background-color: lightcoral;' align=center><input type=text class='campo-pequeno' name='qtde' value=$qtdefaltas[$i] size=5 disabled></td>";
             } else{
              echo "<td align=center><input type=text class='campo-pequeno' name='qtde' value=$qtdefaltas[$i] size=5 disabled></td>";    
            }
         
            $i++;
        }
        echo "</table>";
      }
    }
    
    ?>
   
    <fieldset>
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
    <script>
    function arrumaFalta(id) {
    
    const largura = 50;
    const altura = 100;
    const esquerda = (screen.width - largura) / 2;
    const topo = (screen.height - altura) / 2;

   
    window.open(
        `formulario_atualizar.html?id=${id}`, 
        "janelaAtualizar", 
        `width=${largura},height=${altura},left=${esquerda},top=${topo}`
    );
}
</script>
  </html>