<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "gestao_autoescola";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>

<?php

$conexao = mysqli_connect('localhost','root','','gestao_autoescola');

?>