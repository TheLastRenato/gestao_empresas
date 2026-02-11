
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="atualizar-alunos.css">
    <title>Editar</title>
</head>
<body>
    
<?php 
    require_once('conexao.php');
    require_once('sidebar.php');

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        header('Location: sidebar.php');
    }
    
    elseif (isset($_POST['nome']) && 
    isset($_POST['telefone']) && 
    isset($_POST['email']) && 
    isset($_POST['cpf']) && 
    isset($_POST['aulas_realizadas'])&& 
    isset($_POST['aulas_restantes'])&& 
    isset($_POST['data'])){
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $aulas_realizadas = $_POST['aulas_realizadas'];
        $aulas_restantes = $_POST['aulas_restantes'];
        $data = str_replace("/","-",$_POST['data']);

        $query = mysqli_query($conexao,"update alunos
        set nome_aluno = '$nome', telefone = '$telefone', email='$email', cpf='$cpf', aulas_realizadas = '$aulas_realizadas', 
        aulas_restantes = '$aulas_restantes', data_nascimento = '$data' where id_aluno = $id");

        echo "<div class='center'>";
        echo "<p class='textEditar'>Edição efetuada com sucesso!</p>";
        echo "<p class='textVoltar'><a href='consulta-alunos.php'>Voltar</a></p>";
        echo "</div> <!--center-->";

    }else{
        header('Location: sidebar.php');
    }
    
?>

</body>
</html>