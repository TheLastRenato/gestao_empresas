
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
    
    elseif (isset($_POST['nome_instrutor']) && 
    isset($_POST['data_nasc']) &&
    isset($_POST['cpf']) && 
    isset($_POST['email'])){
        $id = $_POST['id'];
        $nome_instrutor = $_POST['nome_instrutor'];
        $data_nasc = str_replace("/","-",$_POST['data_nasc']);
        $cpf = $_POST['cpf'];
        $email = $_POST['email'];
 

        $query = mysqli_query($conexao,"update instrutores
        set nome_instrutor = '$nome_instrutor', data_nasc = '$data_nasc', cpf='$cpf', email='$email' where id = $id");

        echo "<div class='center'>";
        echo "<p class='textEditar'>Edição efetuada com sucesso!</p>";
        echo "<p class='textVoltar'><a href='consulta-instrutores.php'>Voltar</a></p>";
        echo "</div> <!--center-->";

    }else{
        header('Location: sidebar.php');
    }
    
?>

</body>
</html>