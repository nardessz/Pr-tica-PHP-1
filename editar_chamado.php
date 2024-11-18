<?php
include('db.php');

if (isset($_GET['id'])) {
    $id_chamado = $_GET['id'];

    $conn = new mysqli('localhost', 'root', 'root', 'chamados_suporte');
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM chamados WHERE id_chamado = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_chamado);
        $stmt->execute();
        $result = $stmt->get_result();
        
      
        if ($result->num_rows > 0) {
            $chamado = $result->fetch_assoc();
            $status = $chamado['status'];
            $id_colaborador = $chamado['id_colaborador'];
        } else {
            echo "<p>Chamado não encontrado!</p>";
        }
        $stmt->close();
    } else {
        echo "<p>Erro ao consultar o banco de dados: " . $conn->error . "</p>";
    }

    $sql_colaboradores = "SELECT * FROM colaboradores";
    $result_colab = $conn->query($sql_colaboradores);

    $conn->close();
} else {
    echo "<p>ID do chamado não especificado!</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $id_colaborador = $_POST['id_colaborador'];

    $conn = new mysqli('localhost', 'root', 'root', 'chamados_suporte');
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sql = "UPDATE chamados SET status = ?, id_colaborador = ? WHERE id_chamado = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sii", $status, $id_colaborador, $id_chamado);
        if ($stmt->execute()) {
            echo "<p>Chamado atualizado com sucesso!</p>";
        } else {
            echo "<p>Erro ao atualizar o chamado: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p>Erro ao preparar a consulta: " . $conn->error . "</p>";
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
    
    <h1>Editar Chamado</h1>

    <form method="POST">
        <input type="hidden" name="id_chamado" value="<?php echo $id_chamado; ?>">

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="aberto" <?php echo ($status == 'aberto') ? 'selected' : ''; ?>>Aberto</option>
            <option value="em andamento" <?php echo ($status == 'em andamento') ? 'selected' : ''; ?>>Em andamento</option>
            <option value="resolvido" <?php echo ($status == 'resolvido') ? 'selected' : ''; ?>>Resolvido</option>
        </select><br><br>

        <label for="id_colaborador">Colaborador Responsável:</label>
        <select name="id_colaborador" required>
            <option value="">Selecione</option>
            <?php
            while ($colab = $result_colab->fetch_assoc()) {
                $selected = ($colab['id_colaborador'] == $id_colaborador) ? 'selected' : '';
                echo "<option value='{$colab['id_colaborador']}' $selected>{$colab['nome']}</option>";
            }
            ?>
        </select><br><br>

        <button type="submit">Atualizar Chamado</button>
    </form>

    <br>
    <a href="/pratica1_carlos/hp.php"><button>Página inicial </button></a>
</body>
</html>
