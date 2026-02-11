
<?php 
    require_once('conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="consulta.css">
    <title>Consulta</title>
</head>
<body>

<?php
    require "sidebar.php";
?>
    <div class="container">
        <h2 class="titulo">CONSULTAR ALUNOS</h2>
            <form action="consulta-alunos.php" method="post" class="form">
                <div class="input">
                    <input type="text" class="ipt-pesquisar" placeholder="Digite aqui o nome do aluno" name="pesquisa">
                </div> <!--input-->
                    <div class="button">
                        <button type="submit" class="btnConsultar">Consultar</button>    
            </form> 

                        <form action="cadastro-alunos.php" method="POST">
                            <button type="submit" class="btnVoltar">Voltar</button>
                        </form>
                    </div> <!--button-->
    </div> <!--container-->

    <div class="container2">
    <?php 
require_once('conexao.php');

// Inicializa a variável de pesquisa
$pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';

// Monta a consulta SQL com base na pesquisa
if ($pesquisa == '') {
    // Se não houver pesquisa, seleciona todos os alunos
    $query = mysqli_query($conexao, "SELECT * FROM alunos");
} else {
    // Se houver pesquisa, filtra os alunos pelo nome
    $query = mysqli_query($conexao, "SELECT * FROM alunos WHERE nome_aluno LIKE '%$pesquisa%'");
}

$num_linhas = mysqli_num_rows($query);

// Exibe a mensagem se a pesquisa estiver vazia
if ($pesquisa == '' && isset($_POST['pesquisa'])) {
    echo '<p class="mensagem">Digite o nome do aluno!</p>';
}

// Verifica se há resultados
if ($num_linhas > 0) {
    echo "<table class='tabela'>";
    echo "<tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>CPF</th>
            <th>Aulas Realizadas</th>
            <th>Aulas Restantes</th>
            <th>Data de Nascimento</th>
            <th>Ações</th>
          </tr>";

    while ($dados = mysqli_fetch_array($query)) {
        $id = $dados[0];
        $nome = $dados[1];
        $telefone = $dados[2];
        $email = $dados[3];
        $cpf = $dados[4];
        $aulas_realizadas = $dados[5];
        $aulas_restantes = $dados[6];
        $data_nascimento = date('d/m/Y', strtotime(str_replace("-", "/", $dados[7])));

        echo "
            <tr class='aluno'>
                <td>$id</td>
                <td>$nome</td>
                <td>$telefone</td>
                <td>$email</td>
                <td>$cpf</td>
                <td>$aulas_realizadas</td>
                <td>$aulas_restantes</td>
                <td>$data_nascimento</td>
                <td>
                    <button onclick=\"window.location.href='editar-alunos.php?id=$id'\" class='btn btn-primary'>Editar</button>
                    <button onclick=\"window.location.href='excluir-alunos.php?id=$id'\" class='btn btn-danger'>Excluir</button>
                </td>
            </tr>"; 
    }
    echo "</table>";
} else {
    // Mensagem exibida apenas se não houver resultados
    if ($pesquisa != '') {
        echo "<p>Este aluno não está cadastrado!</p>";
    }
}
?>
</div> <!--container2-->

        

</body>
</html>