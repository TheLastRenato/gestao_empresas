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
        <h2 class="titulo">CONSULTAR VEÍCULOS</h2>
            <form action="consulta-veiculos.php" method="post" class="form">
                <div class="input">
                    <input type="text" class="ipt-pesquisar" placeholder="Digite aqui o modelo do veículo" name="pesquisa">
                </div> <!--input-->
                    <div class="button">
                        <button type="submit" class="btnConsultar">Consultar</button>    
            </form> 

                        <form action="cadastro-veiculos.php" method="POST">
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
    $query = mysqli_query($conexao, "SELECT * FROM veiculos");
} else {
    // Se houver pesquisa, filtra os alunos pelo nome
    $query = mysqli_query($conexao, "SELECT * FROM veiculos WHERE modelo LIKE '%$pesquisa%'");
}

$num_linhas = mysqli_num_rows($query);

// Exibe a mensagem se a pesquisa estiver vazia
if ($pesquisa == '' && isset($_POST['pesquisa'])) {
    echo '<p class="mensagem">Digite o modelo do veículo!</p>';
}

// Verifica se há resultados
if ($num_linhas > 0) {
    echo "<table class='tabela'>";
    echo "<tr>
            <th>ID</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Ano Fabricação</th>
            <th>Cor</th>
            <th>Placa</th>
            <th>Manutenção</th>
            <th>Descrição Manutenão</th>
            <th>Ações</th>
          </tr>";

    while ($dados = mysqli_fetch_array($query)) {
        $id = $dados[0];
        $modelo = $dados[1];
        $marca = $dados[2];
        $ano_fabricacao = $dados[3];
        $cor = $dados[4];
        $placa = $dados[5];
        $manutencao = $dados[6];
        $desc_manutencao = $dados[7];

        echo "
            <tr class='veiculo'>
                <td>$id</td>
                <td>$modelo</td>
                <td>$marca</td>
                <td>$ano_fabricacao</td>
                <td>$cor</td>
                <td>$placa</td>
                <td>$manutencao</td>
                <td>$desc_manutencao</td>
                <td>
                    <button onclick=\"window.location.href='editar-veiculos.php?id=$id'\" class='btn btn-primary'>Editar</button>
                    <button onclick=\"window.location.href='excluir-veiculos.php?id=$id'\" class='btn btn-danger'>Excluir</button>
                </td>
            </tr>"; 
    }
    echo "</table>";
} else {
    // Mensagem exibida apenas se não houver resultados
    if ($pesquisa != '') {
        echo "<p>Este veículo não está cadastrado!</p>";
    }
}
?>
</div> <!--container2-->

        

</body>
</html>