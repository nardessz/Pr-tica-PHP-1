<?php
$servidor = "localhost";
$usuario = "root";
$senha = "root";
$nome_banco = "chamados_suporte"; 
$conn = new mysqli($servidor, $usuario, $senha, $nome_banco);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
$conn->set_charset("utf8");

?>
