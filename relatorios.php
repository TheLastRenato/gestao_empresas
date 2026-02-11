

<?php
session_start();
// Verifica se o instrutor está logado
if (!isset($_SESSION['instrutor'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
// Inclua o arquivo de conexão com o banco de dados




require_once('conexao.php');
require_once('sidebar.php');

// Consultas para obter dados
$result_alunos = $conexao->query("SELECT * FROM alunos");
$result_instrutores = $conexao->query("SELECT * FROM instrutores");

// Consulta com JOINs para pegar nomes dos alunos, instrutores e modelo do veículo nos agendamentos
$query_agendamentos = "
    SELECT 
        a.nome_aluno AS nome_aluno, 
        i.nome_instrutor AS nome_instrutor, 
        v.modelo AS modelo, 
        ag.data_hora AS data_hora
    FROM agendamentos ag
    INNER JOIN alunos a ON ag.aluno_id = a.id_aluno
    LEFT JOIN instrutores i ON ag.instrutor_id = i.id
    LEFT JOIN veiculos v ON ag.veiculo_id = v.id_veiculo
";
$result_agendamentos = $conexao->query($query_agendamentos);

// Verifique se as consultas foram bem-sucedidas
if (!$result_alunos || !$result_instrutores || !$result_agendamentos) {
    die("Erro na consulta ao banco de dados: " . $conexao->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="relatorio.css">
    <title>Relatórios da Autoescola</title>
</head>
<body>

<div class="container">
        <div class="relatorios-container">
            <h2>RELATÓRIOS DA AUTOESCOLA</h2>

            <h2>Alunos</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>CPF</th>
                    <th>Aulas Realizadas</th>
                    <th>Aulas Restantes</th>
                    <th>Data de Nascimento</th>
                </tr>
                <?php
                if ($result_alunos->num_rows > 0) {
                    while($row = $result_alunos->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['id_aluno']) . "</td>
                                <td>" . htmlspecialchars($row['nome_aluno']) . "</td>
                                <td>" . htmlspecialchars($row['telefone']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['cpf']) . "</td>
                                <td>" . htmlspecialchars($row['aulas_realizadas']) . "</td>
                                <td>" . htmlspecialchars($row['aulas_restantes']) . "</td>
                                <td>" . htmlspecialchars(date('d/m/Y', strtotime($row['data_nascimento']))) . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Nenhum aluno encontrado</td></tr>";
                }
                ?>
            </table>

            <h2>Instrutores</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>CPF</th>
                    <th>Email</th>
                </tr>
                <?php
                if ($result_instrutores->num_rows > 0) {
                    while($row = $result_instrutores->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['id']) . "</td>
                                <td>" . htmlspecialchars($row['nome_instrutor']) . "</td>
                                <td>" . htmlspecialchars(date('d/m/Y', strtotime($row['data_nasc']))) . "</td>
                                <td>" . htmlspecialchars($row['cpf']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum instrutor encontrado</td></tr>";
                }
                ?>
            </table>

            <h2>Agendamentos</h2>
            <table>
                <tr>
                    <th>Nome do Aluno</th>
                    <th>Nome do Instrutor</th>
                    <th>Modelo do Veículo</th>
                    <th>Data e Hora</th>
                </tr>
                <?php
                if ($result_agendamentos->num_rows > 0) {
                    while($row = $result_agendamentos->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['nome_aluno']) . "</td>
                                <td>" . htmlspecialchars($row['nome_instrutor']) . "</td>
                                <td>" . htmlspecialchars($row['modelo']) . "</td>
                                <td>" . htmlspecialchars(date('d/m/Y H:i', strtotime($row['data_hora']))) . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Nenhum agendamento encontrado</td></tr>";
                }
                ?>
            </table>
        </div> <!--relatorios-container-->
</div> <!--container-->

</body>
</html>
