
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

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: sidebar.php');
        exit();
    }

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
        $stmt->bind_param("sssssss", $nome, $telefone, $email, $cpf, $aulas_realizadas, $aulas_restantes, $data);

        if ($stmt->execute()) {
            echo "<div class='center'>";
            echo "<p class='textCadastro'>Cadastro efetuado com sucesso!</p>";
            echo "<p class='textVoltar'><a href='cadastro-alunos.php'>Voltar</a></p>";
            echo "</div> <!--center-->";
        } else {
            echo "<div class='center'>";
            echo "<p class='textCadastro'>Erro ao cadastrar: " . $stmt->error . "</p>";
            echo "<p class='textVoltar'><a href='cadastro-alunos.php'>Voltar</a></p>";
            echo "</div> <!--center-->";
        }

        $stmt->close();
    } else {
        header('Location: sidebar.php');
        exit();
    }
?>

</body>
</html>