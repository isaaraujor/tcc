<?php 
include "conexao.php";
if(!isset($_SESSION['logado'])){
    header("Location: acessoneg");
    exit;
} 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckClass</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="css/dash.css">
    <style>
        .btn-sair{
            color: #CEBEE4;
            background-color: #2D006C;
            border: none;
            border-radius: 8px;
            font-weight: 70;
            font-size: medium;
            margin-left: 15px;
        }
    </style>
</head>
<?php
 if(!isset($_SESSION['nome'])){

 }else{
?>

<body>
        <div class="navb">
            <div class="btn-navb">
                <h3>CheckClass</h3>
                <a href="controle">
                    <button class="btn-tm btn-color btn-align"><img class="imgs-buttons" src="img/cont.png">Controle</button>
                </a>
                
                <a href="historico">
                    <button class="btn-tm btn-color btn-align"><img class="imgs-buttons" src="img/hist.png">Histórico</button>
                </a>

                <a href="novoaluno">
                    <button class="btn-tm btn-color btn-align"><img class="imgs-buttons" src="img/adduser.png">Adicionar aluno</button>
                </a>

                <a href="novoprof">
                    <button class="btn-tm btn-color btn-align"><img class="imgs-buttons" src="img/adduser.png">Adicionar professor</button>
                </a>
            </div>
        </div>
        
        <div class="tetudo">
            <nav class="dados-prof">
                <h2>Olá, <?php echo $_SESSION['nome'] ?></h2>
                <div class="img-perfil">
                    <img class="user" src="img/download.png">
                    <?php echo $_SESSION['nome']; ?>
                        <a href="logout">
                        <button class="btn-sair" onclick="return confirm('Tem certeza que deseja sair da conta?');">Sair</button>
                        </a>
                </div>
            </nav>

            <div class="titulo">
            <h3>Faça o controle da turma com</h3><br>
            </div>
            <div class="titulo2">
                <h3 class="digitar" id="texto"></h3>

                <script>
        const texto = " Facilidade e Rapidez";
        let index = 0;
        function digitar() {
            if (index < texto.length) {
                document.getElementById("texto").textContent += texto.charAt(index);
                index++;
                setTimeout(digitar, 100);
            } else {
                //reinicia a animação
                setTimeout(reiniciar, 1000);
            }
        }
        function reiniciar() {
            index = 0; 
            document.getElementById("texto").textContent = "";
            digitar(); 
        }

        digitar();
    </script>
            </div>

        </div>
</body>
<?php
 }
 ?>
</html>