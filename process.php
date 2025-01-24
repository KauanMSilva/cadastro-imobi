<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'imobiliaria';

try {
    
    $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o método da requisição é POST,para o cadastro
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim($_POST['nome']);
        $cpf = trim($_POST['cpf']);
        $creci = trim($_POST['creci']);

        // Validação de dados
        if (strlen($cpf) !== 11 || !preg_match('/^\d{11}$/', $cpf)) {
            throw new Exception('CPF inválido! Deve ter exatamente 11 números.');
        }
        if (strlen($nome) < 2) {
            throw new Exception('O nome deve ter pelo menos 2 caracteres.');
        }
        if (strlen($creci) < 2) {
            throw new Exception('O CRECI deve ter pelo menos 2 caracteres.');
        }

        
        $stmt = $conn->prepare("INSERT INTO corretores (nome, cpf, creci) VALUES (:nome, :cpf, :creci)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':creci', $creci);
        $stmt->execute();

        
        header('Location: index.php?status=success&message=' . urlencode('Cadastro realizado com sucesso!'));
        exit();
    }

    
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $id = $_GET['id'];

        
        $stmt = $conn->prepare("DELETE FROM corretores WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        
        header('Location: index.php?status=success&message=' . urlencode('Corretor excluído com sucesso!'));
        exit();
    }

    
    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        
    }
} catch (Exception $e) {
    
    header('Location: index.php?status=error&message=' . urlencode($e->getMessage()));
    exit();
}
?>
