<?php
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

// Verificar se o ID do agendamento foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar agendamento
    $sql = "SELECT agendamentos.id, alunos.nome_aluno, alunos.cpf, agendamentos.data_hora 
            FROM agendamentos 
            JOIN alunos ON agendamentos.aluno_id = alunos.id_aluno 
            WHERE agendamentos.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $agendamento = $result->fetch_assoc();
    } else {
        echo "Agendamento não encontrado.";
        exit;
    }
} else {
    echo "ID do agendamento não fornecido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edita-agendamento.css">
    <title>Editar Agendamento</title>
</head>
<body>

<?php
    require 'sidebar.php';
?>

    <div class="container">
        <h1 class="titulo">Editar Agendamento</h1>
        <form action="atualizar-agendamento.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $agendamento['id']; ?>">
            
            <label for="nome">Nome do Aluno:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $agendamento['nome_aluno']; ?>">
            
            <label for="email">CPF:</label>
            <input type="text" id="cpf" name="cpf" value="<?php echo $agendamento['cpf']; ?>">
            
            <label for="data_hora">Data e Hora:</label>
            <input type="datetime-local" id="data_hora" name="data_hora" value="<?php echo date('Y-m-d\TH:i', strtotime($agendamento['data_hora'])); ?>" required>
            
            <button type="submit">Atualizar Agendamento</button>
        </form>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>