<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Gestão Autoescolas</title>
    <link rel="stylesheet" href="login.css"> 
</head>
<body>
    <div class="container">
        <h2 class="titulo">Login de Instrutor</h2>
        <form action="autenticar.php" method="POST">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" required>

            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="cpf" required>

            <button type="submit">Entrar</button>
        </form>
        <?php
        if (isset($_SESSION['erro_login'])) {
            echo "<p style='color:red; text-align:center; margin-top:15px;'>".$_SESSION['erro_login']."</p>";
            unset($_SESSION['erro_login']);
        }
        ?>
    </div>
</body>
</html>
