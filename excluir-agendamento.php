<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="excluir.css">
    <title>Excluir Agendamento</title>
</head>
<body>
    
<?php
    require 'sidebar.php';

$servername = "localhost";
$username = "root"; // seu usuário do MySQL
$password = ""; // sua senha do MySQL
$dbname = "gestao_autoescola";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Excluir agendamento
    $sql = "DELETE FROM agendamentos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<div class='center'>";
        echo "<p class='textEditar'>Agendamento excluído com sucesso!</p>";
        echo "<p class='textVoltar'><a href='agendamento.php'>Voltar</a></p>";
        echo "</div> <!--center-->";
    } else {
        echo "<div class='center'>";
        echo "<p class='textEditar'>Erro ao excluir agendamento: </p>" . $stmt->error;
        echo "<p class='textVoltar'><a href='agendamento.php'>Voltar</a></p>";
        echo "</div> <!--center-->";
    }

    $stmt->close();
} else {
        echo "<div class='center'>";
        echo "<p class='textEditar'>ID do agendamento não fornecido.</p>";
        echo "<p class='textVoltar'><a href='agendamento.php'>Voltar</a></p>";
        echo "</div> <!--center-->";
}

$conn->close();
?>

</body>
</html>