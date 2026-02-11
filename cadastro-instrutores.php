
<?php
session_start();
// Verifica se o instrutor está logado
if (!isset($_SESSION['instrutor'])) {
    header("Location: login.php");
    exit();
}
    require_once('conexao.php');
    
    // Flag para controlar exibição do popup
    $mostrarPopup = false;
    $mensagemPopup = "";
    $tipoPopup = "sucesso"; // sucesso ou erro
    
    // Processamento do formulário
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['nome_instrutor']) && 
            isset($_POST['data_nasc']) &&
            isset($_POST['cpf']) &&
            isset($_POST['email'])) {
                
            $nome = $_POST['nome_instrutor'];
            $data_nasc = str_replace("/","-",$_POST['data_nasc']);
            $cpf = $_POST['cpf'];
            $email = $_POST['email'];

            // Função para validar o CPF
            function validarCPF($cpf) {
                // Remove caracteres não numéricos
                $cpf = preg_replace('/[^0-9]/', '', $cpf);
                
                // Verifica se o CPF tem 11 dígitos
                if (strlen($cpf) != 11) {
                    return false;
                }

                // Verifica se todos os dígitos são iguais
                if (preg_match('/^(\d)\1{10}$/', $cpf)) {
                    return false;
                }

                // Validação do CPF
                for ($t = 9; $t < 11; $t++) {
                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $cpf[$c] * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cpf[$c] != $d) {
                        return false;
                    }
                }
                return true;
            }

            // Valida o CPF
            if (!validarCPF($cpf)) {
                $mostrarPopup = true;
                $mensagemPopup = "CPF inválido! Por favor, insira um CPF válido.";
                $tipoPopup = "erro";
            } else {
                // Usando prepared statements para evitar injeção SQL
                $stmt = $conexao->prepare("INSERT INTO instrutores(nome_instrutor, data_nasc, cpf, email) VALUES (?, ?, ?, ?)");
                
                if ($stmt) {
                    $stmt->bind_param("ssss", $nome, $data_nasc, $cpf, $email);
                    
                    if ($stmt->execute()) {
                        // Cadastro bem-sucedido
                        $mostrarPopup = true;
                        $mensagemPopup = "Cadastro efetuado com sucesso!";
                        $tipoPopup = "sucesso";
                    } else {
                        // Erro na execução
                        $mostrarPopup = true;
                        $mensagemPopup = "Erro ao inserir dados: " . $stmt->error;
                        $tipoPopup = "erro";
                    }
                    
                    $stmt->close();
                } else {
                    // Erro na preparação do statement
                    $mostrarPopup = true;
                    $mensagemPopup = "Erro na preparação da consulta: " . $conexao->error;
                    $tipoPopup = "erro";
                }
            }
        }
    }
    
    // Incluir sidebar
    require "sidebar.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastro.css">
    <title>Cadastro de instrutores</title>

    <style>
        /* Estilo para o popup */
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            z-index: 1000;
            text-align: center;
            min-width: 300px;
        }
        
        .popup-content {
            margin-bottom: 20px;
        }
        
        .popup-btn {
            background-color: orange;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .popup-erro .popup-btn {
            background-color: #d9534f;
        }
        
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 999;
        }
    </style>
</head>
<body>
    <!-- Popup HTML -->
    <div class="overlay" id="overlay"></div>
    <div class="popup <?php echo $tipoPopup == 'erro' ? 'popup-erro' : ''; ?>" id="messagePopup">
        <div class="popup-content">
            <h3 class="<?php echo $tipoPopup; ?>"><?php echo $tipoPopup == 'sucesso' ? 'Sucesso!' : 'Erro!'; ?></h3>
            <p id="popupMessage"><?php echo $mensagemPopup; ?></p>
        </div>
        <button class="popup-btn" onclick="closePopup()">OK</button>
    </div>
    
    <div class="container">
        <div class="center">
            <h2 class="titulo">CADASTRAR INSTRUTOR</h2>
            <div class="inputs">
                <form action="cadastro-instrutores.php" method="post" class="form">
                    <label for="nome_instrutor" class="form-label">Nome Completo</label>
                    <input type="text" class="nome" name="nome_instrutor" id="nome_instrutor" required>

                    <label for="data_nasc" class="form-label">Data de Nascimento</label>
                    <input type="date" class="data" name="data_nasc" id="data_nasc" required>    

                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="cpf" name="cpf" id="cpf" maxlength="11" required> 

                    <label for="email" class="form-label">Email</label>
                    <input type="mail" class="email" name="email" id="email" required>
                    
                    <div class="buttons">
                        <button type="submit" class="btnCadastrar">Cadastrar</button>
                        <button type="reset" class="btnLimpar">Limpar</button>
                        <button type="button" class="btnConsultar" onclick="window.location.href='consulta-instrutores.php'">Consultar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript para o popup -->
    <script>
        function showPopup(message, tipo) {
            document.getElementById('popupMessage').textContent = message;
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('messagePopup').style.display = 'block';
            
            // Altera a classe do popup baseado no tipo (sucesso ou erro)
            if (tipo === 'erro') {
                document.getElementById('messagePopup').classList.add('popup-erro');
            } else {
                document.getElementById('messagePopup').classList.remove('popup-erro');
            }
        }
        
        function closePopup() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('messagePopup').style.display = 'none';
            
            <?php if ($tipoPopup == 'sucesso') { ?>
                // Se foi sucesso, redireciona para a página inicial
                window.location.href = 'cadastro-instrutores.php';
            <?php } ?>
        }
    </script>
    
    <?php 
    // Mostrar o popup se necessário
    if ($mostrarPopup) {
        echo "<script>showPopup('" . addslashes($mensagemPopup) . "', '$tipoPopup');</script>";
    }
    ?>
</body>
</html>