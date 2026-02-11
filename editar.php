<?php 
    require_once('conexao.php');

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        header('Location: sidebar.php');
    }else{
        $id = $_GET['id'];

        $query = mysqli_query($conexao, 
        "select id_aluno, nome_aluno, telefone, email, cpf, aulas_realizadas, aulas_restantes, data_nascimento 
        from cadastro_aluno
        where id_aluno = $id");

        $dados = mysqli_fetch_array($query);

        $id = $dados[0];
        $nome = $dados[1];
        $telefone = $dados[2];
        $email = $dados[3];
        $cpf = $dados[4];
        $aulas_realizadas = $dados[5];
        $aulas_restantes = $dados[6];
        $data = $dados[7];
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edita.css">
    <title>Edição</title>
</head>
<body>
    <?php 
        require('sidebar.php');
    ?>
    
    <div class="container ">
            <div class="center">
                <h2>EDITAR ALUNO</h2>

                <form action="atualizar-aluno.php" method="post">
                    <input type="hidden" class="identificacao" name="id" id="id" value="<?= $id ?>">
                    <label for="nome" class="form-label">Nome Completo</label>
                    <input type="text" class="nome" name="nome" id="nome" value="<?= $nome ?>">

                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="telefone" name="telefone" id="telefone" maxlength="12" value="<?= $telefone ?>">

                    <label for="email" class="form-label">Email</label>
                    <input type="mail" class="email" name="email" id="email" value="<?= $email ?>">

                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="cpf" name="cpf" id="cpf" maxlength="11" value="<?= $cpf ?>">

                    <label for="aulas_realizadas" class="form-label">Aulas Realizadas</label>
                    <input type="text" class="aulas_realizadas" name="aulas_realizadas" id="aulas_realizadas" maxlength="11" value="<?= $aulas_realizadas ?>">

                    <label for="aulas_restantes" class="form-label">Aulas Restantes</label>
                    <input type="text" class="aulas_restantes" name="aulas_restantes" id="aulas_restantes" maxlength="11" value="<?= $aulas_restantes ?>">

                    <label for="data" class="form-label">Data de Nascimento</label>
                    <input type="date" class="data" name="data" id="data" value="<?= $data ?>">
                    
                    <button type="submit" class="btnEditar">Editar</button>
                </form>
        </div> <!--center-->
    </div> <!--container-->
</body>
</html>