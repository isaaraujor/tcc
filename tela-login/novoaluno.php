<?php include 'conexao.php'; ?>

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
        <h2>NOVO CADASTRO</h2>
    </div>
    <div class="metadinhas">
        <form action="cadalunos.php" method="POST" class="metadinhas">

            <div class="metade1">
                <div class="form-cad">
        
                    <div class="tudo">
        
                        <h2 align="center">Cadastrar</h2>
            
                        <div class="input-box">
                            <label>Nome</label>
                            <input type="text" name="nome" id="nome">
                        </div>
            
                        <div class="input-box">
                            <label>Data de nascimento</label>
                            <input type="date" name="data" id="data">
                        </div>
            
                        <div class="input-box">
                            <label>Matrícula</label>
                            <input type="text" name="matricula" id="matricula">
                        </div>
            
                        <div class="input-box">
                            <label>Rua</label>
                            <input type="text" name="rua" id="rua">
                        </div>
            
                        <div class="input-box">
                            <label>Bairro</label>
                            <input type="text" name="bairro" id="bairro">
                        </div>
        
                        <div class="citep">
                            <div class="input-box2">
                                <label>Cidade</label>
                                <input type="text" name="cidade" id="cidade">
                            </div>
                
                            <div class="input-box2">
                                <label>CEP</label>
                                <input type="text" name="cep" id="cep">
                            </div>
                        </div>
            
            
                        <div class="input-box">
                            <label>Nome responsável</label>
                            <input type="text" name="resp" id="resp">
                        </div>
            
                        <div class="input-box">
                            <label>Contato responsável</label>
                            <input type="text" name="contato" id="contato">
                        </div>

                        <div class="MMMMEUDEUSSS">
                            <button type="submit" class="btn-tm btn-white">Cadastrar</button>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="metade2">
    
                <div class="img">
                    <img class="cad" src="img/computer.png"> 
                </div> 
            </div>
        </form>
        
    </div>

</body>
</html>