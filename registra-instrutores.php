
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registra.css">
    <title>Cadastrar</title>
</head>
<body>

<?php 
    require_once('conexao.php');
    require_once('sidebar.php');

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        header('Location: sidebar.php');
    }
    
    elseif (isset($_POST['nome_instrutor']) && 
    isset($_POST['data_nasc']) &&
    isset($_POST['cpf']) &&
    isset($_POST['email'])){
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
        echo "<div class='center'>";
        echo "<p class='textCadastro'>CPF inválido! Por favor, insira um CPF válido.</p>";
        echo "<p class='textVoltar'><a href='cadastro-instrutores.php'>Voltar</a></p>";
        echo "</div> <!--center-->";
        exit();
    }

        $query = mysqli_query($conexao,"insert into 
        instrutores(nome_instrutor, data_nasc, cpf, email ) 
        values('$nome','$data_nasc','$cpf','$email')");

        echo "<div class='center'>";
        echo "<p class='textCadastro'>Cadastro efetuado com sucesso!</p>";
        echo "<p class='textVoltar'><a href='cadastro-instrutores.php'>Voltar</a></p>";
        echo "</div> <!--center-->";

    }else{
        header('Location: sidebar.php');
    }

?>
