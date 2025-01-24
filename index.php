<?php
require 'db.php';

try {
    
    $stmt = $conn->prepare("SELECT * FROM corretores");
    $stmt->execute();
    $corretores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erro ao buscar os dados: " . $e->getMessage());
}


$status = isset($_GET['status']) ? $_GET['status'] : '';
$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Corretores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="cadastro-container">
        <h1>Cadastro de Corretor</h1>

       
        <?php if ($status): ?>
            <div class="alert <?php echo $status; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        
        <form action="process.php" method="post">
            <div class="form-group-inline">
                <div class="form-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" required pattern="\d{11}" title="O CPF deve conter exatamente 11 números.">
                </div>
                <div class="form-group">
                    <label for="creci">Creci:</label>
                    <input type="text" id="creci" name="creci" placeholder="Digite seu Creci" required minlength="2">
                </div>
            </div>
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu Nome" required minlength="2">
            </div>
            <div class="form-group">
                <button type="submit">Enviar</button>
            </div>
        </form>

        
        <?php if (count($corretores) > 0): ?>
            <h2>Corretores Cadastrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Creci</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($corretores as $corretor): ?>
                        <tr>
                            <td><?= htmlspecialchars($corretor['id']) ?></td>
                            <td><?= htmlspecialchars($corretor['nome']) ?></td>
                            <td><?= htmlspecialchars($corretor['cpf']) ?></td>
                            <td><?= htmlspecialchars($corretor['creci']) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $corretor['id'] ?>">Editar</a> | 
                                <a href="delete.php?id=<?= $corretor['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="dois">Nenhum corretor cadastrado ainda.</p>
        <?php endif; ?>
    </div>
</body>
</html>
