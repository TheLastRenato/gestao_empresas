
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

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: sidebar.php');
    exit;
}

if (
    isset($_POST['id']) &&
    isset($_POST['modelo']) &&
    isset($_POST['marca']) &&
    isset($_POST['ano_fabricacao']) &&
    isset($_POST['cor']) &&
    isset($_POST['placa']) &&
    isset($_POST['manutencao']) &&
    isset($_POST['desc_manutencao'])
) {
    // Obtém os dados do formulário
    $id = $_POST['id'];
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $ano_fabricacao = $_POST['ano_fabricacao'];
    $cor = $_POST['cor'];
    $placa = $_POST['placa'];
    $manutencao = $_POST['manutencao'];
    $desc_manutencao = $_POST['desc_manutencao'];

    // Prepara a consulta SQL para evitar SQL Injection
    $stmt = $conexao->prepare("
        UPDATE veiculos 
        SET 
            modelo = ?, 
            marca = ?, 
            ano_fabricacao = ?, 
            cor = ?, 
            placa = ?, 
            manutencao = ?, 
            desc_manutencao = ? 
        WHERE id = ?
    ");
    
    if ($stmt) {
        $stmt->bind_param(
            "sssssssi", 
            $modelo, 
            $marca, 
            $ano_fabricacao, 
            $cor, 
            $placa, 
            $manutencao, 
            $desc_manutencao, 
            $id
        );

        if ($stmt->execute()) {
            // Sucesso na atualização
            echo "<div class='center'>";
            echo "<p class='textEditar'>Edição efetuada com sucesso!</p>";
            echo "<p class='textVoltar'><a href='consulta-veiculos.php'>Voltar</a></p>";
            echo "</div> <!--center-->";
        } else {
            // Erro durante a execução da consulta
            echo "<p>Erro ao atualizar o veículo: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Erro ao preparar a consulta SQL: " . $conexao->error . "</p>";
    }
} else {
    header('Location: sidebar.php');
    exit;
}

?>

</body>
</html>