<?php
session_start();

if (!isset($_SESSION['instrutor'])) {
    // Redireciona para o login se não estiver logado
    header("Location: ../login.php");
    exit();
}
?>
