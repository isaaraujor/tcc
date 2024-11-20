<?php
$tipo = $_SESSION['tipo'];
if ($tipo == 'p') {
    header("Location: userperm");
    exit;
}
if (!isset($_SESSION['logado'])) {
    header("Location: acessoneg");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Professores</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/novo.css">
    <style>
        .divs-checkbox { 
            display: flex; 
            align-items: center; 
            margin-bottom: 10px; 
        }
        .divs-checkbox p {
            margin-left: 10px; 
        }
        .divs-checkboxT { 
            display: flex; 
            flex-wrap: wrap; 
            margin-bottom: 20px; 
            margin-left: 20px; 
        }
        .divs-checkboxT p { 
            margin-right: 10px; 
            margin-bottom: 5px; 
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
    <form action="cadprof" method="POST">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>

        <div class="mb-3">
            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
        </div>

        <div class="mb-3">
        <label for="cpf" class="form-label">Login (CPF)</label>
            <input type="text" class="form-control" id="cpf" name="cpf" required>
        </div>

        <div class="mb-3">
            <label for="disciplina" class="form-label">Disciplinas e Turmas</label>
            <div>

                <div class="divs-checkbox">
                    <input type="checkbox" name="disciplinas[]" class="disciplina" value="Teste de Software" id="disciplina_Teste de Software">
                    <p>Teste de Software</p>
                </div>
                <div class="divs-checkboxT turma-group" data-disciplina="Teste de Software">
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="151" disabled>
                    <p>151</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="152" disabled>
                    <p>152</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="153" disabled>
                    <p>153</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="251" disabled>
                    <p>251</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="252" disabled>
                    <p>252</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="253" disabled>
                    <p>253</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="254" disabled>
                    <p>254</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="351" disabled>
                    <p>351</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="352" disabled>
                    <p>352</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="353" disabled>
                    <p>353</p>
                    <input type="checkbox" name="turmas[Teste de Software][]" class="turma" value="354" disabled>
                    <p>354</p>
                </div>

                <div class="divs-checkbox">
                    <input type="checkbox" name="disciplinas[]" class="disciplina" value="Desenvolvimento de Sistemas" id="disciplina_Desenvolvimento de Sistemas">
                    <p>Desenvolvimento de Sistemas</p>
                </div>
                <div class="divs-checkboxT turma-group" data-disciplina="Desenvolvimento de Sistemas">
                <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="151" disabled>
                    <p>151</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="152" disabled>
                    <p>152</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="153" disabled>
                    <p>153</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="251" disabled>
                    <p>251</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="252" disabled>
                    <p>252</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="253" disabled>
                    <p>253</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="254" disabled>
                    <p>254</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="351" disabled>
                    <p>351</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="352" disabled>
                    <p>352</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="353" disabled>
                    <p>353</p>
                    <input type="checkbox" name="turmas[Desenvolvimento de Sistemas][]" class="turma" value="354" disabled>
                    <p>354</p>
                </div>

                <div class="divs-checkbox">
                    <input type="checkbox" name="disciplinas[]" class="disciplina" value="PD. Moveis" id="disciplina_PD. Moveis">
                    <p>PD. Moveis</p>
                </div>
                <div class="divs-checkboxT turma-group" data-disciplina="PD. Moveis">
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="151" disabled>
                    <p>151</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="152" disabled>
                    <p>152</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="153" disabled>
                    <p>153</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="251" disabled>
                    <p>251</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="252" disabled>
                    <p>252</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="253" disabled>
                    <p>253</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="254" disabled>
                    <p>254</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="351" disabled>
                    <p>351</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="352" disabled>
                    <p>352</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="353" disabled>
                    <p>353</p>
                    <input type="checkbox" name="turmas[PD. Moveis][]" class="turma" value="354" disabled>
                    <p>354</p>
                </div>

                <div class="divs-checkbox">
                    <input type="checkbox" name="disciplinas[]" class="disciplina" value="" id="disciplina_Programação de Aplicativos">
                    <p>Programação de Aplicativos</p>
                </div>
                <div class="divs-checkboxT turma-group" data-disciplina="Programação de Aplicativos">
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="151" disabled>
                    <p>151</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="152" disabled>
                    <p>152</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="153" disabled>
                    <p>153</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="251" disabled>
                    <p>251</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="252" disabled>
                    <p>252</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="253" disabled>
                    <p>253</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="254" disabled>
                    <p>254</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="351" disabled>
                    <p>351</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="352" disabled>
                    <p>352</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="353" disabled>
                    <p>353</p>
                    <input type="checkbox" name="turmas[Programação de Aplicativos][]" class="turma" value="354" disabled>
                    <p>354</p>
                </div>

                <div class="divs-checkbox">
                    <input type="checkbox" name="disciplinas[]" class="disciplina" value="IM. Sistemas" id="disciplina_IM. Sistemas">
                    <p>IM. Sistemas</p>
                </div>
                <div class="divs-checkboxT turma-group" data-disciplina="IM. Sistemas">
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="151" disabled>
                    <p>151</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="152" disabled>
                    <p>152</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="153" disabled>
                    <p>153</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="251" disabled>
                    <p>251</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="252" disabled>
                    <p>252</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="253" disabled>
                    <p>253</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="254" disabled>
                    <p>254</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="351" disabled>
                    <p>351</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="352" disabled>
                    <p>352</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="353" disabled>
                    <p>353</p>
                    <input type="checkbox" name="turmas[IM. Sistemas][]" class="turma" value="354" disabled>
                    <p>354</p>
                </div>

                <div class="divs-checkbox">
                    <input type="checkbox" name="disciplinas[]" class="disciplina" value="Modelagem de Sistemas" id="disciplina_Modelagem de Sistemas">
                    <p>Modelagem de Sistemas</p>
                </div>
                <div class="divs-checkboxT turma-group" data-disciplina="Modelagem de Sistemas">
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="151" disabled>
                    <p>151</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="152" disabled>
                    <p>152</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="153" disabled>
                    <p>153</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="251" disabled>
                    <p>251</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="252" disabled>
                    <p>252</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="253" disabled>
                    <p>253</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="254" disabled>
                    <p>254</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="351" disabled>
                    <p>351</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="352" disabled>
                    <p>352</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="353" disabled>
                    <p>353</p>
                    <input type="checkbox" name="turmas[Modelagem de Sistemas][]" class="turma" value="354" disabled>
                    <p>354</p>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
    </form>
</div>

<script>
    document.querySelectorAll('.disciplina').forEach(disciplina => {
        const turmaGroup = document.querySelector(`.turma-group[data-disciplina="${disciplina.value}"]`);
        disciplina.addEventListener('change', () => {
            const turmas = turmaGroup.querySelectorAll('.turma');
            if (disciplina.checked) {
                turmas.forEach(turma => turma.disabled = false);
            } else {
                turmas.forEach(turma => {
                    turma.disabled = true;
                    turma.checked = false;
                });
            }
        });
    });
</script>

<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
