<?php 
  $tipo = $_SESSION['tipo'];
if($tipo == 'p'){
    header("Location: userperm");
}
else


if(!isset($_SESSION['logado'])){
    header("Location: acessoneg");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Professores</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/novo.css">

    <style>
        p{
            margin: 0;
        }
        .divs-checkbox{
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .divs-checkbox p{
            margin-left: 10px;
        }

        .divs-checkboxT{
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            margin-left: 20px;
        }
        .divs-checkboxT p{
            margin-right: 10px;
        }
    </style>

</head>
<body>
<div class="navb">
    <a href="dashboard">
            <img src="img/back.png" height="40px">
        </a>
        <h2>NOVO CADASTRO PROFESSORES</h2>
        <p></p>
    </div>
<div class="container mt-5">
    <h2>Cadastro de Professor</h2>
    <form action="/cadastrar-professor" method="POST">
        
        <!-- Nome do professor -->
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>

        <div class="mb-3">
            <label for="data_nasc" class="form-label">Data de nascimento</label>
            <input type="date" class="form-control" id="data_nasc" name="data_nasc" required>
        </div>

        <!-- Email do professor -->
        <div class="mb-3">
            <label for="login" class="form-label">Login (CPF)</label>
            <input type="login" class="form-control" id="login" name="login" required>
        </div>



        <!-- Disciplina que o professor ensina -->

        <div class="mb-3">
            <label for="disciplina" class="form-label">Disciplina</label>
            <div class="divs-checkbox">
                <input type="checkbox" name="TDS" id="disciplina" value="Teste de Software">
                <p>Teste de Software</p>
            </div>
            
            <div class="divs-checkboxT">
            <input type="checkbox" name="151" id="turma" value="151">
            <p>151</p>
            <input type="checkbox" name="152" id="turma" value="152">
            <p>152</p>
            <input type="checkbox" name="153" id="turma" value="153">
            <p>153</p>
            <input type="checkbox" name="251" id="turma" value="251">
            <p>251</p>
            <input type="checkbox" name="252" id="turma" value="252">
            <p>252</p>
            <input type="checkbox" name="253" id="turma" value="253">
            <p>253</p>
            <input type="checkbox" name="351" id="turma" value="351">
            <p>351</p>
            <input type="checkbox" name="352" id="turma" value="352">
            <p>352</p>
            <input type="checkbox" name="353" id="turma" value="353">
            <p>353</p>
            <input type="checkbox" name="354" id="turma" value="354">
            <p>354</p>
            </div>



            <div class="divs-checkbox">
                <input type="checkbox" name="DS" id="disciplina" value="D. Sistemas">
                <p>D. Sistemas</p>
            </div>

            <div class="divs-checkboxT">
            <input type="checkbox" name="151" id="turma" value="151">
            <p>151</p>
            <input type="checkbox" name="152" id="turma" value="152">
            <p>152</p>
            <input type="checkbox" name="153" id="turma" value="153">
            <p>153</p>
            <input type="checkbox" name="251" id="turma" value="251">
            <p>251</p>
            <input type="checkbox" name="252" id="turma" value="252">
            <p>252</p>
            <input type="checkbox" name="253" id="turma" value="253">
            <p>253</p>
            <input type="checkbox" name="351" id="turma" value="351">
            <p>351</p>
            <input type="checkbox" name="352" id="turma" value="352">
            <p>352</p>
            <input type="checkbox" name="353" id="turma" value="353">
            <p>353</p>
            <input type="checkbox" name="354" id="turma" value="354">
            <p>354</p>
            </div>

            <div class="divs-checkbox">
                <input type="checkbox" name="PDM" id="disciplina" value="PD Moveis">
                <p>PD Moveis</p>
            </div>

            <div class="divs-checkboxT">
            <input type="checkbox" name="151" id="turma" value="151">
            <p>151</p>
            <input type="checkbox" name="152" id="turma" value="152">
            <p>152</p>
            <input type="checkbox" name="153" id="turma" value="153">
            <p>153</p>
            <input type="checkbox" name="251" id="turma" value="251">
            <p>251</p>
            <input type="checkbox" name="252" id="turma" value="252">
            <p>252</p>
            <input type="checkbox" name="253" id="turma" value="253">
            <p>253</p>
            <input type="checkbox" name="351" id="turma" value="351">
            <p>351</p>
            <input type="checkbox" name="352" id="turma" value="352">
            <p>352</p>
            <input type="checkbox" name="353" id="turma" value="353">
            <p>353</p>
            <input type="checkbox" name="354" id="turma" value="354">
            <p>354</p>
            </div>

            <div class="divs-checkbox">
                <input type="checkbox" name="PDA" id="disciplina" value="Programação de Aplicativos">
                <p>Programação de Aplicativos</p>
            </div>

            <div class="divs-checkboxT">
            <input type="checkbox" name="151" id="turma" value="151">
            <p>151</p>
            <input type="checkbox" name="152" id="turma" value="152">
            <p>152</p>
            <input type="checkbox" name="153" id="turma" value="153">
            <p>153</p>
            <input type="checkbox" name="251" id="turma" value="251">
            <p>251</p>
            <input type="checkbox" name="252" id="turma" value="252">
            <p>252</p>
            <input type="checkbox" name="253" id="turma" value="253">
            <p>253</p>
            <input type="checkbox" name="351" id="turma" value="351">
            <p>351</p>
            <input type="checkbox" name="352" id="turma" value="352">
            <p>352</p>
            <input type="checkbox" name="353" id="turma" value="353">
            <p>353</p>
            <input type="checkbox" name="354" id="turma" value="354">
            <p>354</p>
            </div>

            <div class="divs-checkbox">
                <input type="checkbox" name="IMS" id="disciplina" value="IM Sistemas">
                <p>IM Sistemas</p>
            </div>

            <div class="divs-checkboxT">
            <input type="checkbox" name="151" id="turma" value="151">
            <p>151</p>
            <input type="checkbox" name="152" id="turma" value="152">
            <p>152</p>
            <input type="checkbox" name="153" id="turma" value="153">
            <p>153</p>
            <input type="checkbox" name="251" id="turma" value="251">
            <p>251</p>
            <input type="checkbox" name="252" id="turma" value="252">
            <p>252</p>
            <input type="checkbox" name="253" id="turma" value="253">
            <p>253</p>
            <input type="checkbox" name="351" id="turma" value="351">
            <p>351</p>
            <input type="checkbox" name="352" id="turma" value="352">
            <p>352</p>
            <input type="checkbox" name="353" id="turma" value="353">
            <p>353</p>
            <input type="checkbox" name="354" id="turma" value="354">
            <p>354</p>
            </div>

            <div class="divs-checkbox">
                <input type="checkbox" name="MDS" id="disciplina" value="Modelagem de Sistemas">
                <p>Modelagem de Sistemas</p>
            </div>

            <div class="divs-checkboxT">
            <input type="checkbox" name="151" id="turma" value="151">
            <p>151</p>
            <input type="checkbox" name="152" id="turma" value="152">
            <p>152</p>
            <input type="checkbox" name="153" id="turma" value="153">
            <p>153</p>
            <input type="checkbox" name="251" id="turma" value="251">
            <p>251</p>
            <input type="checkbox" name="252" id="turma" value="252">
            <p>252</p>
            <input type="checkbox" name="253" id="turma" value="253">
            <p>253</p>
            <input type="checkbox" name="351" id="turma" value="351">
            <p>351</p>
            <input type="checkbox" name="352" id="turma" value="352">
            <p>352</p>
            <input type="checkbox" name="353" id="turma" value="353">
            <p>353</p>
            <input type="checkbox" name="354" id="turma" value="354">
            <p>354</p>
            </div>

            <div class="divs-checkbox">
                <input type="checkbox" name="PI" id="disciplina" value="Projeto Integrador">
                <p>Projeto Integrador</p>
            </div>

            <div class="divs-checkboxT">
            <input type="checkbox" name="151" id="turma" value="151">
            <p>151</p>
            <input type="checkbox" name="152" id="turma" value="152">
            <p>152</p>
            <input type="checkbox" name="153" id="turma" value="153">
            <p>153</p>
            <input type="checkbox" name="251" id="turma" value="251">
            <p>251</p>
            <input type="checkbox" name="252" id="turma" value="252">
            <p>252</p>
            <input type="checkbox" name="253" id="turma" value="253">
            <p>253</p>
            <input type="checkbox" name="351" id="turma" value="351">
            <p>351</p>
            <input type="checkbox" name="352" id="turma" value="352">
            <p>352</p>
            <input type="checkbox" name="353" id="turma" value="353">
            <p>353</p>
            <input type="checkbox" name="354" id="turma" value="354">
            <p>354</p>
            </div>
        </div>

        <!-- Senha -->
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
        </div>

        <!-- Botão de envio -->
        <div class="mb-3">
            <button type="submit" class="btn-tm btn-white">Cadastrar</button>
        </div>
    </form>
</div>
<div class="omgsocorro"></div>

<!-- Scripts do Bootstrap (local) -->
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>

<?php 

?>