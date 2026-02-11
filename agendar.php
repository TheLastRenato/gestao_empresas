
<?php
session_start();
// Verifica se o instrutor está logado
if (!isset($_SESSION['instrutor'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento de Aulas</title>
    <link rel="stylesheet" href="agendar.css">
</head>
<body>

<?php
    require 'sidebar.php';
?>

<div class="container">
    <h1 class="titulo">Agendamento de Aulas</h1>
    <form action="agendar.php" method="POST">
        <label for="nome">Nome do Aluno:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required>
        
        <label for="data_hora">Data e Hora:</label>
        <input type="datetime-local" id="data_hora" name="data_hora" required>

        <label for="instrutor">Instrutor:</label>
        <select id="instrutor" name="instrutor" required>
            <?php
            // Conexão com o banco de dados
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "gestao_autoescola";

            // Criar conexão
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

            // Consulta para buscar instrutores
            $sql = "SELECT id, nome_instrutor FROM instrutores";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome_instrutor']}</option>";
                }
            } else {
                echo "<option value=''>Nenhum instrutor encontrado</option>";
            }
            ?>
        </select>

        <label for="veiculo">Veículo:</label>
        <select id="veiculo" name="veiculo" required>
            <?php
            // Consulta para buscar veículos
            $sql = "SELECT id_veiculo, modelo FROM veiculos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id_veiculo']}'>{$row['modelo']}</option>";
                }
            } else {
                echo "<option value=''>Nenhum veículo encontrado</option>";
            }
            ?>
        </select>
        
        <button type="submit">Agendar Aula</button>
    </form>
</div>

<?php
// Reabrindo a conexão para processar o agendamento
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cpf'], $_POST['data_hora'], $_POST['instrutor'], $_POST['veiculo'])) {
        $cpf = $_POST['cpf'];
        $data_hora = $_POST['data_hora'];
        $instrutor_id = $_POST['instrutor'];
        $veiculo_id = $_POST['veiculo'];

        // Verificar se o aluno está cadastrado pelo CPF
        $sql = "SELECT id_aluno FROM alunos WHERE cpf = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $aluno = $result->fetch_assoc();
            $aluno_id = $aluno['id_aluno'];

            // Verificação de Disponibilidade do Veículo
            $sql = "SELECT COUNT(*) FROM agendamentos WHERE veiculo_id = ? AND data_hora = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Erro na preparação da consulta: " . $conn->error);
            }
            $stmt->bind_param("is", $veiculo_id, $data_hora);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close(); // Fechar o statement após o uso

            if ($count > 0) {
                echo "<div class='center'>";
                echo "<p class='textEditar'>O veículo já está agendado para este horário.</p>";
                echo "<p class='textVoltar'><a href='agendamento.php'>Voltar</a></p>";
                echo "</div>";
            } else {
                // Verificação de Disponibilidade do Instrutor
                $sql = "SELECT COUNT(*) FROM agendamentos WHERE instrutor_id = ? AND data_hora = ?";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    die("Erro na preparação da consulta: " . $conn->error);
                }
                $stmt->bind_param("is", $instrutor_id, $data_hora);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close(); // Fechar o statement após o uso

                if ($count > 0) {
                    echo "<div class='center'>";
                    echo "<p class='textEditar'>O instrutor já está agendado para este horário.</p>";
                    echo "<p class='textVoltar'><a href='agendamento.php'>Voltar</a></p>";
                    echo "</div>";
                } else {
                    // Inserir o agendamento
                    $sql = "INSERT INTO agendamentos (aluno_id, instrutor_id, veiculo_id, data_hora) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    if (!$stmt) {
                        die("Erro na preparação da consulta: " . $conn->error);
                    }
                    $stmt->bind_param("iiis", $aluno_id, $instrutor_id, $veiculo_id, $data_hora);

                    if ($stmt->execute()) {
                        echo "<div class='center'>";
                        echo "<p class='textEditar'>Aula agendada com sucesso!</p>";
                        echo "<p class='textVoltar'><a href='agendamento.php'>Voltar</a></p>";
                        echo "</div>";
                    } else {
                        echo "<div class='center'>";
                        echo "<p class='textEditar'>Erro ao agendar aula: </p>" . $stmt->error;
                        echo "<p class='textVoltar'><a href='agendamento.php'>Voltar</a></p>";
                        echo "</div>";
                    }
                }
            }
        } else {
            echo "<div class='center'>";
            echo "<p class='textEditar'>Aluno não encontrado. Por favor, verifique o CPF.</p>";
            echo "<p class='textVoltar'><a href='agendamento.php'>Voltar</a></p>";
            echo "</div>";
        }
    }
}

$conn->close();
?>
</body>
</html>