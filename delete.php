<?php
require 'db.php';

try {
    // Verifica se o ID foi passado
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

       
        $stmt = $conn->prepare("DELETE FROM corretores WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        
        header('Location: index.php?status=success&message=' . urlencode('Corretor excluído com sucesso.'));
        exit();
    } else {
        
        header('Location: index.php?status=error&message=' . urlencode('Corretor não encontrado.'));
        exit();
    }
} catch (Exception $e) {
    
    header('Location: index.php?status=error&message=' . urlencode('Erro ao excluir o corretor: ' . $e->getMessage()));
    exit();
}
?>
