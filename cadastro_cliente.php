<?php
include('db.php');  

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    if (empty($nome) || empty($email)) {
        echo "<p>Nome e e-mail são obrigatórios!</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p>Por favor, insira um e-mail válido.</p>";
    } else {

        $sql = "INSERT INTO clientes (nome, email, telefone) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $nome, $email, $telefone);

            if ($stmt->execute()) {
                echo "<p>Cliente cadastrado com sucesso!</p>";
            } else {
                echo "<p>Erro ao cadastrar cliente: " . $stmt->error . "</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Erro ao preparar a consulta: " . $conn->error . "</p>";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Cadastro de Cliente</h1>

    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone"><br><br>

        <button type="submit">Cadastrar Cliente</button>
    </form>

    <br>
<a href="/pratica1_carlos/hp.php"><button>Página inicial </button></a>
</body>
</html>
