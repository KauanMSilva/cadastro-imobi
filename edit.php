<?php
require 'db.php';

try {
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        
        $stmt = $conn->prepare("SELECT * FROM corretores WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $corretor = $stmt->fetch(PDO::FETCH_ASSOC);

        
        if (!$corretor) {
            throw new Exception('Corretor não encontrado.');
        }
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim($_POST['nome']);
        $cpf = trim($_POST['cpf']);
        $creci = trim($_POST['creci']);

        
        if (strlen($cpf) !== 11 || !preg_match('/^\d{11}$/', $cpf)) {
            throw new Exception('CPF inválido! Deve ter exatamente 11 números.');
        }
        if (strlen($nome) < 2) {
            throw new Exception('O nome deve ter pelo menos 2 caracteres.');
        }
        if (strlen($creci) < 2) {
            throw new Exception('O CRECI deve ter pelo menos 2 caracteres.');
        }

        
        $stmt = $conn->prepare("UPDATE corretores SET nome = :nome, cpf = :cpf, creci = :creci WHERE id = :id");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':creci', $creci);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        
        header('Location: index.php?status=success&message=' . urlencode('Corretor editado com sucesso.'));
        exit();
    }
} catch (Exception $e) {
    
    echo 'Erro: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Corretor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="cadastro-container">
        <h1>Editar Corretor</h1>
        <form action="edit.php?id=<?= $corretor['id'] ?>" method="post">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($corretor['nome']) ?>" required minlength="2">
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" value="<?= htmlspecialchars($corretor['cpf']) ?>" required pattern="\d{11}" title="O CPF deve conter exatamente 11 números.">
            </div>
            <div class="form-group">
                <label for="creci">Creci:</label>
                <input type="text" id="creci" name="creci" value="<?= htmlspecialchars($corretor['creci']) ?>" required minlength="2">
            </div>
            <div class="form-group">
                <button type="submit">Salvar</button>
            </div>
        </form>
    </div>
</body>
</html>
