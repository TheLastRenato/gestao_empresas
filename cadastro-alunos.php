
<?php
session_start();
// Verifica se o instrutor está logado
if (!isset($_SESSION['instrutor'])) {
    header("Location: login.php");
    exit();
}
    require_once('conexao.php'); // Mova isso para cá também
    
    // Processamento do formulário
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Verifica se todos os campos estão preenchidos
        if (isset($_POST['nome_aluno'], $_POST['telefone'], $_POST['email'], $_POST['cpf'], $_POST['aulas_realizadas'], $_POST['aulas_restantes'], $_POST['data'])) {
            $nome = $_POST['nome_aluno'];
            $telefone = $_POST['telefone'];
            $email = $_POST['email'];
            $cpf = $_POST['cpf'];
            $aulas_realizadas = $_POST['aulas_realizadas'];
            $aulas_restantes = $_POST['aulas_restantes'];
            $data = str_replace("/", "-", $_POST['data']);

            // Usando prepared statements para evitar injeção SQL
            $stmt = $conexao->prepare("INSERT INTO alunos (nome_aluno, telefone, email, cpf, aulas_realizadas, aulas_restantes, data_nascimento) VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            if ($stmt) {
                $stmt->bind_param("sssssss", $nome, $telefone, $email, $cpf, $aulas_realizadas, $aulas_restantes, $data);
                
                if ($stmt->execute()) {
                    // Flag para mostrar o popup
                    $mostrarPopup = true;
                } else {
                    // Lida com erro na execução
                    $erro = "Erro ao inserir dados: " . $stmt->error;
                }
                
                $stmt->close(); // Fecha o prepared statement
            } else {
                // Lida com erro na preparação do statement
                $erro = "Erro na preparação da consulta: " . $conexao->error;
            }
        }
    }
    
    // Agora inclua o sidebar depois de processar o formulário
    require "sidebar.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastro.css">
    <title>Cadastro de Alunos</title>
</head>
<body>
    <!-- Popup HTML -->
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="successPopup">
        <div class="popup-content">
            <h3>Sucesso!</h3>
            <p>Cadastro realizado com sucesso.</p>
        </div>
        <button class="popup-btn" onclick="closePopup()">OK</button>
    </div>
    
    <!--Estilo para o popup-->
    <style>
    
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
        }

        .popup-content {
            margin-bottom: 20px;
        }

        .popup-btn {
            background-color: #ff9900;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
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

    <div class="container">
        <div class="center">
            <h2 class="titulo">CADASTRAR ALUNO</h2>
            <div class="inputs">
                <form action="cadastro-alunos.php" method="post" class="form">
                    <label for="nome_aluno" class="form-label">Nome Completo</label>
                    <input type="text" class="nome" name="nome_aluno" id="nome_aluno" required>

                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="telefone" name="telefone" id="telefone" maxlength="12" required>

                    <label for="email" class="form-label">Email</label>
                    <input type="mail" class="email" name="email" id="email" required>  

                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="cpf" name="cpf" id="cpf" maxlength="11" required> 

                    <label for="aulas_realizadas" class="form-label">Aulas Realizadas</label>
                    <input type="text" class="aulas_realizadas" name="aulas_realizadas" id="aulas_realizadas" maxlength="11" required>

                    <label for="aulas_restantes" class="form-label">Aulas Restantes</label>
                    <input type="text" class="aulas_restantes" name="aulas_restantes" id="aulas_restantes" maxlength="11" required>

                    <label for="data" class="form-label">Data de Nascimento</label>
                    <input type="date" class="data" name="data" id="data" required>
                    
                    <div class="buttons">
                        <button type="submit" class="btnCadastrar">Cadastrar</button>
                        <button type="reset" class="btnLimpar">Limpar</button>
                        <button type="button" class="btnConsultar" onclick="window.location.href='consulta-alunos.php'">Consultar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript para o popup -->
    <script>
        function showPopup() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('successPopup').style.display = 'block';
        }
        
        function closePopup() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('successPopup').style.display = 'none';
            window.location.href = 'cadastro-alunos.php';
        }
    </script>
    
    <?php 
    // Mostrar o popup se o cadastro foi bem-sucedido
    if (isset($mostrarPopup) && $mostrarPopup) {
        echo "<script>showPopup();</script>";
    }
    
    // Mostrar mensagem de erro se houver
    if (isset($erro)) {
        echo "<script>alert('$erro');</script>";
    }
    ?>
</body>
</html>