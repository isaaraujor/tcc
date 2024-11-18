<?php

$login = $_POST['login']; 
$senha = $_POST['senha']; 

$stmt = $con->prepare('SELECT * FROM usuarios WHERE login = :login'); 
    $stmt->execute(['login' => $login]);

    // Obtendo o usuário do banco de dados
    $user = $stmt->fetch();

    if ($user && password_verify($senha, $user['senha'])) {
        // Login bem-sucedido
        echo "Login realizado com sucesso!";
        // Iniciar uma sessão ou redirecionar o usuário, conforme necessário
        $_SESSION['id_usuario'] = $user['id_usuarios'];
        $_SESSION['tipo'] = $user['tipo']; //a
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['logado'] = 1;
        // Redirecionar para uma página protegida
        header("Location: dashboard.php");
        exit;
    } else {
        // Credenciais inválidas
        echo "Nome de usuário ou senha incorretos.";
    }

?>