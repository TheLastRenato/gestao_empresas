
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registra.css">
    <title>Cadastrar</title>
</head>
<body>

<?php 
    require_once('conexao.php');
    require_once('sidebar.php');

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        header('Location: sidebar.php');
    }
    
    elseif (isset($_POST['modelo']) && 
    isset($_POST['marca']) && 
    isset($_POST['ano_fabricacao']) && 
    isset($_POST['cor']) && 
    isset($_POST['placa'])&& 
    isset($_POST['manutencao'])&& 
    isset($_POST['desc_manutencao'])){
        $modelo = $_POST['modelo'];
        $marca = $_POST['marca'];
        $ano_fabricacao = $_POST['ano_fabricacao'];
        $cor = $_POST['cor'];
        $placa = $_POST['placa'];
        $manutencao = $_POST['manutencao'];
        $desc_manutencao = $_POST['desc_manutencao'];

        $query = mysqli_query($conexao,"insert into 
        veiculos(modelo, marca, ano_fabricacao, cor, placa, manutencao, desc_manutencao) 
        values('$modelo','$marca','$ano_fabricacao','$cor','$placa','$manutencao','$desc_manutencao')");

        echo "<div class='center'>";
        echo "<p class='textCadastro'>Cadastro efetuado com sucesso!</p>";
        echo "<p class='textVoltar'><a href='cadastro-veiculos.php'>Voltar</a></p>";
        echo "</div> <!--center-->";

    }else{
        header('Location: sidebar.php');
    }

?>

</body>
</html>