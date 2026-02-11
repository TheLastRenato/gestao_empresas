<?php 
require_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Location: sidebar.php');
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header('Location: sidebar.php');
    exit;
}

// Consulta segura com prepared statement
$stmt = mysqli_prepare($conexao, 
    "SELECT id, modelo, marca, ano_fabricacao, cor, placa, manutencao, desc_manutencao 
     FROM veiculos 
     WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$dados = mysqli_fetch_array($result, MYSQLI_ASSOC);

if (!$dados) {
    echo "Veículo não encontrado.";
    exit;
}

// Escapar os valores para prevenir XSS
function esc($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editar.css">
    <title>Edição</title>
</head>
<body>
    <?php require('sidebar.php'); ?>
    
    <div class="container">
        <div class="center">
            <h2>EDITAR VEÍCULOS</h2>

            <form action="atualizar-veiculos.php" method="post">
                <input type="hidden" name="id" value="<?= esc($dados['id']) ?>">

                <label for="modelo">Modelo</label>
                <input type="text" name="modelo" id="modelo" value="<?= esc($dados['modelo']) ?>">

                <label for="marca">Marca</label>
                <input type="text" name="marca" id="marca" maxlength="12" value="<?= esc($dados['marca']) ?>">

                <label for="ano_fabricacao">Ano Fabricação</label>
                <input type="text" name="ano_fabricacao" id="ano_fabricacao" value="<?= esc($dados['ano_fabricacao']) ?>">

                <label for="cor">Cor</label>
                <input type="text" name="cor" id="cor" maxlength="11" value="<?= esc($dados['cor']) ?>">

                <label for="placa">Placa</label>
                <input type="text" name="placa" id="placa" maxlength="11" value="<?= esc($dados['placa']) ?>">

                <label for="manutencao">Manutenção</label>
                <select name="manutencao" id="manutencao">
                    <option value="Sim" <?= $dados['manutencao'] == 'Sim' ? 'selected' : '' ?>>Sim</option>
                    <option value="Não" <?= $dados['manutencao'] == 'Não' ? 'selected' : '' ?>>Não</option>
                </select><br>

                <label for="desc_manutencao">Descrição Manutenção</label>
                <input type="text" name="desc_manutencao" id="desc_manutencao" value="<?= esc($dados['desc_manutencao']) ?>">

                <button type="submit" class="btnEditar">Editar</button>
            </form>
        </div>
    </div>
</body>
</html>
