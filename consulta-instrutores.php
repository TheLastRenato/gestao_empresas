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
        <h2 class="titulo">CONSULTAR INSTRUTORES</h2>
            <form action="consulta-instrutores.php" method="post" class="form">
                <div class="input">
                    <input type="text" class="ipt-pesquisar" placeholder="Digite aqui o nome do instrutor" name="pesquisa">
                </div> <!--input-->
                    <div class="button">
                        <button type="submit" class="btnConsultar">Consultar</button>    
            </form> 

                        <form action="cadastro-instrutores.php" method="POST">
                            <button type="submit" class="btnVoltar">Voltar</button>
                        </form>
                    </div> <!--button-->
    </div> <!--container-->

    <div class="container2">
    <?php 
$mensagem = '';
$pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';

// Monta a consulta SQL com base na pesquisa
if ($pesquisa == '') {
    // Se não houver pesquisa, seleciona todos os instrutores
    $query = mysqli_query($conexao, "SELECT * FROM instrutores");
} else {
    // Se houver pesquisa, filtra os instrutores pelo nome
    $query = mysqli_query($conexao, "SELECT * FROM instrutores WHERE nome_instrutor LIKE '%$pesquisa%'");
}

$num_linhas = mysqli_num_rows($query);

// Exibe a mensagem se a pesquisa estiver vazia
if ($pesquisa == '' && isset($_POST['pesquisa'])) {
    $mensagem = 'Digite o nome do instrutor!';
    echo "<p class='mensagem'>$mensagem</p>";
}

// Verifica se há resultados
if ($num_linhas > 0) {
    echo "<table class='tabela'>";
    echo "<tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Data de Nascimento</th>
            <th>CPF</th>
            <th>Email</th>
            <th>Ações</th>
          </tr>";

    while ($dados = mysqli_fetch_array($query)) {
        $id = $dados[0];
        $nome = $dados[1];
        $data_nascimento = date('d/m/Y', strtotime(str_replace("-", "/", $dados[2]))); // Corrigido para o índice correto
        $cpf = $dados[3];
        $email = $dados[4];
        
        echo "
            <tr class='instrutor'>
                <td>$id</td>
                <td>$nome</td>
                <td>$data_nascimento</td>
                <td>$cpf</td>
                <td>$email</td>
                <td>
                    <button onclick=\"window.location.href='editar-instrutores.php?id=$id'\" class='btn btn-primary'>Editar</button>
                    <button onclick=\"window.location.href='excluir-instrutores.php?id=$id'\" class='btn btn-danger'>Excluir</button>
                </td>
            </tr>"; 
    }
    echo "</table>";
} else {
    // Mensagem exibida apenas se não houver resultados
    if ($pesquisa != '') {
        echo "<p>Este instrutor não está cadastrado!</p>";
    }
}
?>
</div> <!--container2-->

        

</body>
</html>