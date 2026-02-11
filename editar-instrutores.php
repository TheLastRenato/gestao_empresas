<?php 
    require_once('conexao.php');

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        header('Location: sidebar.php');
    }else{
        $id = $_GET['id'];

        $query = mysqli_query($conexao, 
        "select id, nome_instrutor, data_nasc, cpf, email
        from instrutores
        where id = $id");

        $dados = mysqli_fetch_array($query);

        $id = $dados[0];
        $nome_instrutor = $dados[1];
        $data_nasc = $dados[2];
        $cpf = $dados[3];
        $email = $dados[4];
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editar.css">
    <title>Edição</title>
</head>
<body>
    <?php 
        require('sidebar.php');
    ?>
    
    <div class="container ">
            <div class="center">
                <h2>EDITAR INSTRUTORES</h2>

                <form action="atualizar-instrutor.php" method="post">
                    <input type="hidden" class="identificacao" name="id" id="id" value="<?= $id ?>">
                    <label for="nome_instrutor" class="form-label">Nome Completo</label>
                    <input type="text" class="nome" name="nome_instrutor" id="nome_instrutor" value="<?= $nome_instrutor ?>">

                    <label for="data_nasc" class="form-label">Data de Nascimento</label>
                    <input type="date" class="data" name="data_nasc" id="data_nasc" value="<?= $data ?>">

                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="cpf" name="cpf" id="cpf" maxlength="11" value="<?= $cpf ?>">

                    <label for="email" class="form-label">Email</label>
                    <input type="mail" class="email" name="email" id="email" value="<?= $email ?>">
                    
                    <button type="submit" class="btnEditar">Editar</button>
                </form>
        </div> <!--center-->
    </div> <!--container-->
</body>
</html>