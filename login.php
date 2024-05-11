<?php

require_once "connection.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $query = "select id, nome, senha from Usuario where nome = ?";

    $stmt = $conexao->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $password_hash = $user['senha'];
        
        if (password_verify($password, $password_hash)) {
            
            $_SESSION["system"] = "docit";
            $_SESSION["username"] = strtoupper($username);
            $_SESSION["idusuario"] = $user['id'];

            echo '<script>window.location.href = "index.php";</script>'; //Lucas, aqui ele encaminha pra tela principal se tiver ok o login. Depois, só substitui "index.php" pela tela que quiser
            exit();

        } else {

            $error_message = "Usuário ou senha incorreta.";         

        }
    } else {
        $error_message = "Usuário não encontrado.";
    }

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOCit! - Armazene documentos</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="icon" href="DOCit/logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <img src="DOCit/marca.png" width="150px" alt="DOCit Logo" draggable="false">
        <form method="POST" action="">
            <h4>Usuário</h4>
            <input type="text" name="username" placeholder="Digite o Usuário" required>
            <h4>Senha</h4>
            <input type="password" name="password" placeholder="Digite a Senha" required>
            <button type="submit">Acessar</button>
           
        </form>
        <?php if (isset($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>
    </div>
</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        const loginContainer = document.querySelector('.login-container');
        loginContainer.style.opacity = '1';
    }, 200);
});
</script>

