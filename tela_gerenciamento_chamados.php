<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <h1>Gerenciamento de Chamados</h1>


    <form method="GET">
        <label for="status">Status:</label>
        <select name="status">
            <option value="">Selecione</option>
            <option value="aberto">Aberto</option>
            <option value="em andamento">Em andamento</option>
            <option value="resolvido">Resolvido</option>
        </select><br><br>

        <label for="criticidade">Criticidade:</label>
        <select name="criticidade">
            <option value="">Selecione</option>
            <option value="baixa">Baixa</option>
            <option value="média">Média</option>
            <option value="alta">Alta</option>
        </select><br><br>

        <button type="submit">Filtrar</button>
    </form>

    <h2>Chamados</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Criticidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('db.php');

            $status = isset($_GET['status']) ? $_GET['status'] : '';
            $criticidade = isset($_GET['criticidade']) ? $_GET['criticidade'] : '';

            $sql = "SELECT * FROM chamados WHERE status LIKE ? AND criticidade LIKE ?";
            $stmt = $conn->prepare($sql);
            $status_param = "%$status%";
            $criticidade_param = "%$criticidade%";
            $stmt->bind_param("ss", $status_param, $criticidade_param);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_chamado']}</td>
                        <td>{$row['id_cliente']}</td>
                        <td>{$row['descricao']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['criticidade']}</td>
                        <td>
                            <a href='editar_chamado.php?id={$row['id_chamado']}'>Editar</a>
                        </td>
                    </tr>";
            }

            $stmt->close();
            $conn->close();
            ?>
        </tbody>
    </table><br><br>

    <a href="/pratica1_carlos/hp.php"><button>Página inicial </button></a>

</body>
</html>
