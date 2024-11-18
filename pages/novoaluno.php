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
    <title>Cadastro de novo aluno</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="css/novo.css">
</head>
<body>
    <div class="navb">
    <a href="dashboard">
            <img src="img/back.png" height="40px">
        </a>
        <h2>NOVO CADASTRO ALUNO</h2>
        <p></p>
    </div>
        <form action="cadalunos" method="POST" class="metadinhas">

        <div class="container mt-5">
    <h2>Cadastro de Aluno</h2>
    <form action="/cadastrar-aluno" method="POST">
        <!-- Nome -->
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>

        <!-- Data de Nascimento -->
        <div class="mb-3">
            <label for="data_nasc" class="form-label">Data de Nascimento</label>
            <input type="date" class="form-control" id="data_nasc" name="data_nasc" required>
        </div>

        <!-- Matrícula -->
        <div class="mb-3">
            <label for="matricula" class="form-label">Matrícula</label>
            <input type="text" class="form-control" id="matricula" name="matricula" required>
        </div>

        <!-- Endereço -->
        <div class="mb-3">
            <label for="rua" class="form-label">Rua</label>
            <input type="text" class="form-control" id="rua" name="rua" required>
        </div>

        <!-- Bairro -->
        <div class="mb-3">
            <label for="bairro" class="form-label">Bairro</label>
            <input type="text" class="form-control" id="bairro" name="bairro" required>
        </div>

        <!-- Cidade -->
        <div class="mb-3">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="cidade" name="cidade" required>
        </div>

        <!-- CEP -->
        <div class="mb-3">
            <label for="cep" class="form-label">CEP</label>
            <input type="text" class="form-control" id="cep" name="cep" required>
        </div>

        <!-- Nome do Responsável -->
        <div class="mb-3">
            <label for="nome_resp" class="form-label">Nome do Responsável</label>
            <input type="text" class="form-control" id="nome_resp" name="nome_resp" required>
        </div>

        <!-- Contato do Responsável -->
        <div class="mb-3">
            <label for="contat_resp" class="form-label">Contato do Responsável</label>
            <input type="tel" class="form-control" id="contat_resp" name="contat_resp" required>
        </div>

        <!-- Botão de Enviar -->
        <button type="submit" class="btn-tm btn-white">Cadastrar</button>
    </form>
    
</div>

<!-- Link para o Bootstrap JS e Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
<?php 
}
?>