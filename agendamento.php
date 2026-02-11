
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

// Excluir agendamentos cujo data_hora já expirou
$sql_excluir_expirados = "DELETE FROM agendamentos WHERE data_hora < NOW()";

// Consultar agendamentos com instrutores e veículos
$sql = "SELECT agendamentos.id, alunos.nome_aluno, alunos.cpf, agendamentos.data_hora, 
        instrutores.nome_instrutor AS nome_instrutor, veiculos.modelo AS modelo
        FROM agendamentos 
        JOIN alunos ON agendamentos.aluno_id = alunos.id_aluno
        JOIN instrutores ON agendamentos.instrutor_id = instrutores.id
        JOIN veiculos ON agendamentos.veiculo_id = veiculos.id_veiculo
        ORDER BY agendamentos.data_hora ASC";


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos</title>
    <link rel="stylesheet" href="agendament.css">
</head>
<body>

<?php
    require 'sidebar.php';
?>

<div class="container">
    <div class="center">
        <h1>Agendamentos Realizados</h1>
        <form action='agendar.php' method='POST'>
            <button class="novo" type='submit'>Novo</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Aluno</th>
                    <th>CPF</th>
                    <th>Data e Hora</th>
                    <th>Instrutor</th>
                    <th>Veículo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Saída de dados de cada linha
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nome_aluno']}</td>
                                <td>{$row['cpf']}</td>
                                <td>{$row['data_hora']}</td>
                                <td>{$row['nome_instrutor']}</td>
                                <td>{$row['modelo']}</td>
                                <td>
                                    <form action='editar-agendamento.php?id={$row['id']}' method='POST'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit'>Editar</button>
                                    </form>

                                    <form action='excluir-agendamento.php' method='POST' style='display:inline;'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit' onclick='return confirm(\"Tem certeza que deseja excluir este agendamento?\");'>Excluir</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Nenhum agendamento encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div> <!--center-->
</div> <!--container-->
</body>
</html>

<?php
$conn->close();
?>
