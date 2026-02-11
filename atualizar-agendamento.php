

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="atualizar-alunos.css">
    <title>Editar Agendamento</title>
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

$id = $_POST['id'];
$data_hora = $_POST['data_hora'];
$nome = $_POST['nome']; // Obter nome do POST
$cpf = $_POST['cpf']; // Obter CPF do POST

// Atualizar agendamento
$sql = "UPDATE agendamentos SET data_hora = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $data_hora, $id);

if ($stmt->execute()) {
    // Atualizar informações do aluno
    $sql = "UPDATE alunos SET nome_aluno = ?, cpf = ? WHERE id_aluno = (SELECT aluno_id FROM agendamentos WHERE id = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nome, $cpf, $id);

    if ($stmt->execute()) {
        echo "<div class='center'>";
        echo "<p class='textEditar'>Agendamento e informações do aluno atualizados com sucesso!</p>";
        echo "<p class='textVoltar'><a href='agendamento.php'>Voltar</a></p>";
        echo "</div> <!--center-->";
    } else {
        echo "<div class='center'>";
        echo "<p class='textEditar'>Erro ao atualizar informações do aluno: </p>" . $stmt->error;
        echo "<p class='textVoltar'><a href='agendamento.php'>Voltar</a></p>";
        echo "</div> <!--center-->";
    }
} else {
        echo "<div class='center'>";
        echo "<p class='textEditar'>Erro ao atualizar agendamento: </p>" . $stmt->error;
        echo "<p class='textVoltar'><a href='agendamento.php'>Voltar</a></p>";
        echo "</div> <!--center-->";
}

$stmt->close();
$conn->close();
?>

</body>
</html>