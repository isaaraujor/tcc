<?php include 'conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo cadastro</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="everthing">

        <div class="main-title">

            <div class="words">
                <h1 class="wlc">BEM VINDO AO</h1>
                <h1 class="title-tcc">CheckClass!</h1>
            </div>

            <div class="img">
                <img class="pessoa" src="./img/Well-done.png"> 
            </div>

        </div>
        <div class="main-login">

            <div class="form-login">

                <form action="insere-dados.php" method="POST" class="tudo">
    
                    <h2 align="center">Cadastro de usuário</h2>
        
                    <div class="input-box">
                        <label>Nome</label>
                        <input type="text" name="nome" id="nome" required>
                    </div>
        
                    <div class="input-box">
                        <label>Login (CPF)</label>
                        <input type="text" name="login" id="login" required>
                    </div>
    
                    <div class="input-box">
                        <label>Senha</label>
                        <input type="password" name="senha" id="senha" required>
                    </div>
        
                    <div class="input-box">
                        <label>Tipo de usuário</label>
                        <select name="tipo" id="tipo">
                            <option value="prof">Professor</option>
                            <option value="soe">SOE</option>
                        </select>
                    </div>
                    <div class="MMMMEUDEUSSS">
                        <button type="submit" class="btn-tm btn-white">Cadastrar</button>
                    </div>
                    <a href="index.php" align="center">Já tem cadastro? Faça login</a>
                </form>

            </div>   

        </div>
    </div>
</body>
</html>