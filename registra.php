<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registra.css">
    <title>Editar</title>
</head>
<body>

<?php 
    require_once('conexao.php');
    require_once('sidebar.php');

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        header('Location: sidebar.php');
    }
    
    elseif (isset($_POST['nome_aluno']) && 
    isset($_POST['telefone']) && 
    isset($_POST['email']) && 
    isset($_POST['cpf']) && 
    isset($_POST['aulas_realizadas'])&& 
    isset($_POST['aulas_restantes'])&& 
    isset($_POST['data'])){
        $nome = $_POST['nome_aluno'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $aulas_realizadas = $_POST['aulas_realizadas'];
        $aulas_restantes = $_POST['aulas_restantes'];
        $data = str_replace("/","-",$_POST['data']);

        $query = mysqli_query($conexao,"insert into 
        cadastro_aluno(nome_aluno, telefone, email, cpf, aulas_realizadas, aulas_restantes, data_nascimento) 
        values('$nome','$telefone','$email','$cpf','$aulas_realizadas','$aulas_restantes','$data')");

        echo "<div class='center'>";
        echo "<p class='textCadastro'>Cadastro efetuado com sucesso!</p>";
        echo "<p class='textVoltar'><a href='cadastro.php'>Voltar</a></p>";
        echo "</div> <!--center-->";

    }else{
        header('Location: sidebar.php');
    }

?>

</body>
</html>