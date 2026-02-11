<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="excluir.css">
    <title>Excluir</title>
</head>
<body>
<?php 
    require_once('conexao.php');
    require_once('sidebar.php');

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        header('Location: sidebar.php');
    }elseif(isset($_GET['id'])){
        $id = $_GET['id'];        

        $query = mysqli_query($conexao,"delete from cadastro_aluno where id_aluno = $id");

        echo "<div class='center'>";
        echo "<p class='textExcluir'>Registro excluído com sucesso!</p>";
        echo "<p class='textVoltar'><a href='consulta-alunos.php'>Voltar</a></p>";
        echo "</div> <!--center-->";
    }

?>
</body>
</html>