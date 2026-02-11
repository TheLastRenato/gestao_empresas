
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastro.css">
    <title>Cadastro</title>
</head>
<body>

<?php
    require "sidebar.php";
?>
    <div class="container ">
        <div class="center">
            <h2 class="titulo">CADASTRAR ALUNO</h2>
                <div class="inputs">
                    <form action="registra.php" method="post" class="form">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="nome" name="nome_aluno" id="nome_aluno"> <br>

                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="telefone" name="telefone" id="telefone" maxlength="12"> <br>

                        <label for="email" class="form-label">Email</label>
                        <input type="mail" class="email" name="email" id="email"> <br>  

                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="cpf" name="cpf" id="cpf" maxlength="11"> <br> 

                        <label for="aulas_realizadas" class="form-label">Aulas Realizadas</label>
                        <input type="text" class="aulas_realizadas" name="aulas_realizadas" id="aulas_realizadas" maxlength="11"> <br>

                        <label for="aulas_restantes" class="form-label">Aulas Restantes</label>
                        <input type="text" class="aulas_restantes" name="aulas_restantes" id="aulas_restantes" maxlength="11"> <br>

                        <label for="data" class="form-label">Data de Nascimento</label>
                        <input type="date" class="data" name="data" id="data">
                        
                        <div class="buttons">
                            <button type="submit" class="btnCadastrar">Cadastrar</button>
                            <button type="reset" class="btnLimpar">Limpar</button>
                    </form>

                    <form action="consulta-alunos.php" method="post">
                    <button type="submit" class="btnConsultar">Consultar</button>
                    </form>
                    
                    </div> <!--buttons-->
                </div> <!--inputs-->
            </div> <!--center-->
        </div> <!--container-->
</body>
</html>