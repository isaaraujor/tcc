<?php 
  $tipo = $_SESSION['tipo'];
if($tipo == 'p'){
    header("Location: userperm");
}
else{


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

        <!-- Email do professor -->
        <div class="mb-3">
            <label for="login" class="form-label">Login (CPF)</label>
            <input type="login" class="form-control" id="login" name="login" required>
        </div>

        <!-- Disciplina que o professor ensina -->
        <div class="mb-3">
            <label for="disciplina" class="form-label">Disciplina</label>
            <select class="form-select" id="disciplina" name="disciplina" required>
                <option value="" disabled selected>Selecione a disciplina</option>
                <option value="Matemática">Teste de Software</option>
                <option value="Português">D. Sistemas</option>
                <option value="História">PD Moveis</option>
                <option value="Biologia">Programação de Aplicativos</option>
                <option value="Matemática">IM Sistemas</option>
                <option value="Português">Modelagem de Sistemas</option>
                <option value="História">Projeto Integrador</option>
                <!-- Adicione outras disciplinas conforme necessário -->
            </select>
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

<!-- Scripts do Bootstrap (local) -->
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>

<?php 
}
?>