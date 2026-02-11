<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Verifica se o instrutor está logado
if (!isset($_SESSION['instrutor'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sideba.css">
    <title>AutoEscola Santos</title>
</head>
<body>
    <aside class="sidebar">
        <div class="header">
            <img src="" alt="">
            <h1>Auto Escola Santos</h1>
        </div> <!--header-->

    
        <div class="links">
            <a href="cadastro-alunos.php">
                <i class="Alunos"></i>
                <img class="img-aluno" src="imagens/aluno.png" alt="Cadastro">
                <p>Alunos</p>
            </a>

            <a href="cadastro-instrutores.php">
                <i class="Instrutores"></i>
                <img class="img-instrutor" src="imagens/instrutor.png" alt="Alunos">
                <p>Instrutores</p>
            </a>

            <a href="cadastro-veiculos.php">
                <i class="Veiculos"></i>
                <img class="img-veiculo" src="imagens/veiculo.png" alt="Veiculos">
                <p>Veículos</p>
            </a>

            <a href="agendamento.php">
                <i class="Agendamento"></i>
                <img class="img-agendamento" src="imagens/agendamento.png" alt="Agendamento">
                <p>Agendamentos</p>
            </a>

            <a class="relatorio" href="relatorios.php">
                <i class="Relatorios"></i>
                <img class="img-relatorio" src="imagens/relatorio.png" alt="Relatorios">
                <p>Relatórios</p>
            </a>

            <a class="logout" href="logout.php">
                <img class="img-logout" src="imagens/saida.png" alt="logout">
                <p>Logout</p>
            </a>

        </div> <!--links-->
    </aside> <!--sidebar-->
</body>
</html>