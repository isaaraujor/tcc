<?php include 'conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckClass</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="css/dash.css">
</head>
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
                    <button class="btn-tm btn-color btn-align"><img class="imgs-buttons" src="img/adduser.png">Novo aluno</button>
                </a>
            </div>
        </div>
        
        <div class="tetudo">
            <nav class="dados-prof">
                <h2>Olá, </h2>
                <div class="img-perfil">
                    <img class="user" src="img/download.png">

                </div>
            </nav>

            <div class="titulo">
                <h3>Faça o controle da turma com</h3><br>
            </div>
            <div class="titulo2">
                <h3 class="digitar" id="texto"></h3>
            </div>
            
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
</body>
</html>