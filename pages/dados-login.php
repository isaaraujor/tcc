<?php

$login = $_POST['login']; 
$senha = $_POST['senha']; 

$stmt = $con->prepare('SELECT * FROM usuarios WHERE login = :login'); 
    $stmt->execute(['login' => $login]);

    
    $user = $stmt->fetch();

    if ($user && password_verify($senha, $user['senha'])) {
        
        echo "Login realizado com sucesso!";
       
        $_SESSION['id_usuario'] = $user['id_usuarios'];
        $_SESSION['tipo'] = $user['tipo']; 
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['logado'] = 1;
        
        header("Location: dashboard");
        exit;
    } else {

        echo "Nome de usuário ou senha incorretos.";
    }

?>