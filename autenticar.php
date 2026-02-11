<?php
session_start();
include("conexao.php"); // Certifique-se de que esse caminho está certo

// Verifique se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];

    // Prepare a consulta
    $sql = "SELECT * FROM instrutores WHERE email = ? AND cpf = ?";
    $stmt = $conn->prepare($sql); // $conn deve ser a sua conexão com o banco de dados

    if ($stmt) {
        // Vincule os parâmetros
        $stmt->bind_param("ss", $email, $cpf);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $_SESSION['instrutor'] = $email;
            header("Location: sidebar.php"); // redireciona para sidebar.php
            exit();
        } else {
            $_SESSION['erro_login'] = "Email ou CPF inválido.";
            header("Location: login.php");
            exit();
        }

        // Feche a declaração
        $stmt->close();
    } else {
        // Se a preparação da declaração falhar
        $_SESSION['erro_login'] = "Erro ao preparar a consulta.";
        header("Location: login.php");
        exit();
    }
} else {
    // Se não for um POST, redirecione para o login
    header("Location: login.php");
    exit();
}

// Feche a conexão
$conn->close();
?>

