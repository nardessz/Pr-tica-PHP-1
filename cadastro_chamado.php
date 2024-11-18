<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
    <h1>Cadastrar Novo Chamado</h1>

    <?php
    include('db.php'); 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id_cliente = $_POST['id_cliente'];
        $descricao = $_POST['descricao'];
        $criticidade = $_POST['criticidade'];
        $status = 'aberto';
        $data_abertura = date('Y-m-d H:i:s');
        $id_colaborador = $_POST['id_colaborador']; 

        if (empty($id_colaborador)) {
            echo "<p>O campo 'Colaborador Responsável' é obrigatório.</p>";
        } else {

            $sql = "INSERT INTO chamados (id_cliente, descricao, criticidade, status, data_abertura, id_colaborador) 
                    VALUES (?, ?, ?, ?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {

                $stmt->bind_param("issssi", $id_cliente, $descricao, $criticidade, $status, $data_abertura, $id_colaborador);

                if ($stmt->execute()) {
                    echo "<p>Chamado cadastrado com sucesso!</p>";
                } else {
                    echo "<p>Erro ao cadastrar o chamado: " . $stmt->error . "</p>";
                }

                $stmt->close();
            } else {
                echo "<p>Erro ao preparar a consulta: " . $conn->error . "</p>";
            }
        }
    }

    ?>
    <form method="POST">
        <label for="id_cliente">Cliente:</label>
        <select name="id_cliente" required>
            <option value="">Selecione</option>

            <?php
            $sql_clientes = "SELECT id_cliente, nome FROM clientes";
            $result_clientes = $conn->query($sql_clientes);
            while ($cliente = $result_clientes->fetch_assoc()) {
                echo "<option value='{$cliente['id_cliente']}'>{$cliente['nome']}</option>";
            }
            ?>
        </select><br><br>

        <label for="descricao">Descrição do Problema:</label>
        <textarea name="descricao" required></textarea><br><br>

        <label for="criticidade">Criticidade:</label>
        <select name="criticidade" required>
            <option value="baixa">Baixa</option>
            <option value="média">Média</option>
            <option value="alta">Alta</option>
        </select><br><br>

        <label for="id_colaborador">Colaborador Responsável:</label>
        <select name="id_colaborador" required>
            <option value="">Selecione</option>
            <?php
            $sql_colaboradores = "SELECT id_colaborador, nome FROM colaboradores";
            $result_colab = $conn->query($sql_colaboradores);
            while ($colab = $result_colab->fetch_assoc()) {
                echo "<option value='{$colab['id_colaborador']}'>{$colab['nome']}</option>";
            }
            ?>
        </select><br><br>

        <button type="submit">Cadastrar Chamado</button>
    </form>
    <br>
    <a href="/pratica1_carlos/hp.php"><button>Página inicial</button></a>

</body>
</html>
