<?php 
require_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
    header('Location: sidebar.php');
    exit;
}

$id = intval($_GET['id']);
if ($id <= 0) {
    echo "ID inválido.";
    exit;
}

$stmt = mysqli_prepare($conexao, "DELETE FROM veiculos WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
$executado = mysqli_stmt_execute($stmt);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="excluir.css">
    <title>Excluir</title>
</head>
<body>
    <?php require_once('sidebar.php'); ?>

    <div class="center">
        <?php if ($executado): ?>
            <p class="textExcluir">Registro excluído com sucesso!</p>
        <?php else: ?>
            <p class="textExcluir">Erro ao excluir o registro.</p>
        <?php endif; ?>
        <p class="textVoltar"><a href="consulta-veiculos.php">Voltar</a></p>
    </div>
</body>
</html>
