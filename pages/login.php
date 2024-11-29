<?php 
include 'conexao.php'; 

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                <form action="dados-login" method="POST" class="tudo">
                        <h2 align="center">Login de usuário</h2>
                        <div class="input-box">
                            <label>Login</label>
                            <input type="text" name="login" id="login" required>
                        </div>
                        
                        <div class="input-box">
                            <label>Senha</label>
                            <input type="password" name="senha" id="senha" required>
                        </div>
                        
                         <div class="input-box">
                            <label>Tipo de usuário</label>
                            <select name="tipo" id="tipo" required>
                                <option value="prof">Professor</option>
                                <option value="soe">SOE</option>
                            </select>
                        </div> 
                        <div class="MMMMEUDEUSSS">
                            <button type="submit" class="btn-tm btn-white">Entrar</button>
                        </div>
                        <a href="cadastro" align="center">Não tem cadastro? Cadastre-se</a>
                    </form>
                
            </div>   
        </div>
    </div> 
</body>
</html>