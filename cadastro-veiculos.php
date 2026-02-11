
<?php
session_start();
// Verifica se o instrutor está logado
if (!isset($_SESSION['instrutor'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastro.css">
    <title>Cadastro de veículos</title>
    <style>
        /* Estilos para o popup */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .popup-content {
            background-color: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        
        .textCadastro {
            font-size: 18px;
            margin-bottom: 20px;
        }
        
        .btn-voltar {
            display: inline-block;
            padding: 10px 20px;
            background-color: orange;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .btn-voltar:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <?php
        require 'sidebar.php';

        // Verificamos se houve um cadastro bem-sucedido
        $cadastroSucesso = false;
        
        if($_SERVER['REQUEST_METHOD'] == 'POST' && 
           isset($_POST['modelo']) && 
           isset($_POST['marca']) && 
           isset($_POST['ano_fabricacao']) && 
           isset($_POST['cor']) && 
           isset($_POST['placa']) && 
           isset($_POST['manutencao']) && 
           isset($_POST['desc_manutencao'])) {
            
            require_once('conexao.php');
            
            $modelo = $_POST['modelo'];
            $marca = $_POST['marca'];
            $ano_fabricacao = $_POST['ano_fabricacao'];
            $cor = $_POST['cor'];
            $placa = $_POST['placa'];
            $manutencao = $_POST['manutencao'];
            $desc_manutencao = $_POST['desc_manutencao'];

            $query = mysqli_query($conexao, "INSERT INTO 
            veiculos(modelo, marca, ano_fabricacao, cor, placa, manutencao, desc_manutencao) 
            VALUES('$modelo','$marca','$ano_fabricacao','$cor','$placa','$manutencao','$desc_manutencao')");
            
            $cadastroSucesso = true;
        }
    ?>

    <div class="container">
        <div class="center">
            <h2 class="titulo">CADASTRAR VEÍCULOS</h2>
                <div class="inputs">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="modelo" name="modelo" id="modelo"> <br>

                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="marca" name="marca" id="marca" maxlength="12"> <br>

                        <label for="ano_fabricacao" class="form-label">Ano Fabricação</label>
                        <input type="text" class="ano_fabricacao" name="ano_fabricacao" id="ano_fabricacao"> <br>  

                        <label for="cor" class="form-label">Cor</label>
                        <input type="text" class="cor" name="cor" id="cor" maxlength="11"> <br> 

                        <label for="placa" class="form-label">Placa</label>
                        <input type="text" class="placa" name="placa" id="placa" maxlength="11"> <br>

                        <label for="manutencao" class="form-label">Manutenção</label>
                        <select name="manutencao" id="manutencao">
                            <option value="sim">Sim</option>
                            <option value="nao">Não</option>
                        </select> <br>

                        <label for="desc_manutencao" class="form-label">Descrição Manutenção</label>
                        <input type="textarea" class="desc_manutencao" name="desc_manutencao" id="desc_manutencao">
                        
                        <div class="buttons">
                            <button type="submit" class="btnCadastrar">Cadastrar</button>
                            <button type="reset" class="btnLimpar">Limpar</button>
                    </form>

                    <form action="consulta-veiculos.php" method="post">
                    <button type="submit" class="btnConsultar">Consultar</button>
                    </form>
                    
                    </div> <!--buttons-->
                </div> <!--inputs-->
            </div> <!--center-->
        </div> <!--container-->

    <?php
        // Se o cadastro foi bem-sucedido, exibimos o popup
        if ($cadastroSucesso) {
            echo '
            <div id="successPopup" class="popup-overlay">
                <div class="popup-content">
                    <p class="textCadastro">Cadastro efetuado com sucesso!</p>
                    <a href="cadastro-veiculos.php" class="btn-voltar">Voltar</a>
                </div>
            </div>
            ';
        }
    ?>

    <script>
        // Script para fechar o popup se clicar fora dele
        document.addEventListener('DOMContentLoaded', function() {
            var popup = document.getElementById('successPopup');
            if (popup) {
                popup.addEventListener('click', function(e) {
                    if (e.target === popup) {
                        window.location.href = 'cadastro-veiculos.php';
                    }
                });
            }
        });
    </script>
</body>
</html>